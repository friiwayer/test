<?
require_once './../mod/conn.php';
Class Ajax extends Conn 
{
var $image;
var $image_type;
public $post;
public $type;
public $grab = 'http://cronixinc.com/common/php_test_files/images.txt';

public function check()
{
$server = $_SERVER;
if(!empty($server['HTTP_X_REQUESTED_WITH']) && strtolower($server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
{return true;}else{return false;}
}

function remoteFileExists($url){
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_NOBODY, true);
    $result = curl_exec($curl);
    $ret = false;
    if($result !== false){
      $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);  
        if($statusCode == 200){
            $ret = true;   
        }
    }
    curl_close($curl);
    return $ret;
}

public function post($index){
if(isset($_POST[$index])){
if(!empty($_POST[$index])){
$index = $_POST[$index];
$index = trim($index);
$index = htmlspecialchars($index);
return $index;}
else return false;
}else return false;
}

public function edit_img($array,$dir)
{
    for($s=1;$s<=count($array);$s++)
    {
        if(file_get_contents('http://'.$array[$s][0]))
        {
            $this->load('http://'.$array[$s][0]);
            $width = $this->getWidth('http://'.$array[$s][0]);
            $height = $this->getHeight('http://'.$array[$s][0]);
            
            $thumb_width = 600;
            $thumb_height = 600;
            $original_aspect = $width / $height;
            $thumb_aspect = $thumb_width / $thumb_height;
            if ($original_aspect >= $thumb_aspect)
            {
               $new_height = $thumb_height;
               $new_width = $width / ($height / $thumb_height);
            }
            else
            {
               $new_width = $thumb_width;
               $new_height = $height / ($width / $thumb_width);
            }
            
            $dest = imagecreatetruecolor($thumb_width,$thumb_height);//600*600 new image
            $whiteBackground = imagecolorallocate($dest, 255, 255, 255);
            
            if($width > $thumb_width)
            {
            $this->resizeToWidth($thumb_width);
            $src = $this->image;
            imagefill($dest,0,0,$whiteBackground);            
            imagecopyresampled($dest, $src, 0, 0, 0, 0, 600, 600, $thumb_width, $thumb_height);
            //imagecopy($dest,$src,0, 0, 0, 0, $thumb_width, $thumb_height);
            $this->image = $dest;
            $this->save('..'.$dir.'00'.$s.'.jpg',IMAGETYPE_JPEG);
            }elseif($width <= $thumb_width)
            {
            $src = $this->image;
            imagefill($dest,0,0,$whiteBackground);            
            imagecopy($dest,$src,(($thumb_width - $width)/ 2), (($thumb_height - $height) / 2), 0, 0, $thumb_width, $thumb_height);
            $this->image = $dest;
            $this->save('..'.$dir.'00'.$s.'.jpg',IMAGETYPE_JPEG);
            }
         $this->inBase_($array[$s]);   
        }
    }
}

public function inBase_($im)
{

    $date = date('Y-m-d',$im[1]);
    $query = 'INSERT INTO `tst_images` (`name`,`old_path`,`new_path`,`date`) 
    VALUES ("'.$im[3].'","'.$im[2].'","'.$this->image_dir.'","'.$date.'")';
    $this->sql($query);
}

public function hash_()
{
    $url = $_SERVER['REQUEST_URI'];
    
}

public function showImg($order='`date` ASC')
{   
    $dir = $order =='`date` DESC'?'down':'up';
    $query = 'SELECT * FROM `tst_images` ORDER BY '.$order;
    $select = $this->sql($query);
    if($select)
    {
    $tr .= '<tr class="panel-heading brtop shdw"><th>#name</th><th>#img</th><th>#path</th><th><a onclick="filtr(this);return false;" href="#" class="'.$dir.'">#date <span class="caret-'.$dir.'"></span></a></th></tr>';
    while($table = mysql_fetch_array($select))
    {
    $tr .= '
    <tr>
    <td>/00'.$table['name'].'</td>
    <td><img width="'.$this->img_w_out.'" height="'.$this->image_h_out.'" src="'.$table['new_path'].'00'.$table['name'].'.jpg"/></td>
    <td>'.$table['old_path'].'</td>
    <td>'.$table['date'].'</td>
    </tr>';
    }
    echo $tr;
    }
    else{echo false;}
}

///image
private function load($filename) {
      $image_info = getimagesize($filename);
      $this->image_type = $image_info[2];
      if($this->image_type == IMAGETYPE_JPEG ) {
         $this->image = imagecreatefromjpeg($filename);
      } elseif( $this->image_type == IMAGETYPE_GIF){
         $this->image = imagecreatefromgif($filename);
      } elseif( $this->image_type == IMAGETYPE_PNG ) {
         $this->image = imagecreatefrompng($filename);
      }
}
private function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null){
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image,$filename,$compression);
      } elseif( $image_type == IMAGETYPE_GIF ) {
         imagegif($this->image,$filename);
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagealphablending($this->image, false);
         imagesavealpha($this->image,true);        
         imagepng($this->image,$filename);
      }
      imagedestroy($this->image);
      if( $permissions != null) {
         chmod($filename,$permissions);
      }
}

private function output($image_type=IMAGETYPE_JPEG) {
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image);
      } elseif( $image_type == IMAGETYPE_GIF ) {
         imagegif($this->image);
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image);
      }
}
private function getWidth() {
      return imagesx($this->image);
}
private function getHeight() {
      return imagesy($this->image);
}
private function resizeToHeight($height) {
      $ratio = $height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width,$height);
}
private function resizeToWidth($width){
      $ratio = $width / $this->getWidth();
      $height = $this->getheight() * $ratio;
      $this->resize($width,$height);
}
private function scale($scale) {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getheight() * $scale/100;
      $this->resize($width,$height);
}
public function resize($width,$height){
      $new_image = imagecreatetruecolor(600, 600);
      
      if(($this->image_type == IMAGETYPE_GIF) || ($this->image_type==IMAGETYPE_PNG)){
      imagealphablending($new_image, false);
      imagesavealpha($new_image,true);
      $transparent = imagecolorallocatealpha($new_image, 255, 255, 255, 127);
      imagefilledrectangle($new_image, 0, 0, $width, $height, $transparent);
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      }else
      {
      $whiteBackground = imagecolorallocate($new_image, 255, 255, 255);
      imagefill($new_image,0,0,$whiteBackground);
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      }
      
      $this->image = $new_image;
}
////parse file string
public function explodeAll($string,$tpl,$tp_='')
{
    if(!empty($string))
    {
    $return = array();$ar = array();
    $ar = explode($tpl,$string);
    for($f=1;$f<=count($ar)-1;$f++){
        $ar1 = explode(' ',$ar[$f]);
        $te = explode($tp_,$ar1[0]);
        $name = substr($te[1], 0, -4);
        $return[$f] = array($ar1[0],$ar1[1],$tpl.$te[0].$tp_,$name);
    }
    return $return;
    }else{return false;}
}

public function curl_it($url)
{
    if($curl = curl_init()){
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    $out = curl_exec($curl);
    return $out;
    curl_close($curl);
}
}

public function blur($fes,$type,$url)
{
    $expl = array();
    if($type[$fes])
    {
        if($this->remoteFileExists($url))
        {
        $parsed = $this->curl_it($url);
        $expl = $this->explodeAll($parsed,'http://','s/');
        }
    }
    $this->edit_img($expl,$this->image_dir);
}

}

$affrade = new Ajax;
if($affrade->check())
{
if($affrade->post('parse')){$affrade->blur('parse',$_POST,$affrade->grab);}
if($affrade->post('getIm')){$affrade->showImg();}
if($affrade->post('filtr')){$ud = $affrade->post('filtr'); $ord = $ud=='up'?'DESC':'ASC';  $affrade->showImg('`date` '.$ord);}
}
