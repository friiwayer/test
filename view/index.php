<?
require_once './mod/conn.php';

Class Page extends Conn
{   
    public  $body;
    public  $form;
    public  $footer;
    public  $dn=true;

    public function head()
    {
        echo 
        '
        <head>
       	<meta content="text/html; charset='.$this->_charset.'" http-equiv="Content-Type" />
        <meta http-equiv="content-language" content="en" />	
        <link href="'.$this->_main_dir.'/css/style.css" rel="stylesheet" type="text/css" media="all" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
        <script type="text/javascript" src="'.$this->_main_dir.'/js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="'.$this->_main_dir.'/js/Jquery.js"></script>        
        </head>
        '
        ;
    }
    
    
    public function form()
    {
    if($this->isEmptyDir('images/')){$hide='dn';}else{$hide='';}
    echo
    '<div class="">
    <form class="form-inline col-centered" method="post" onSubmit="return false;">
      <div class="form-group">
        <div class="input-group">
          <div class="input-group-addon"></div>
          <input name="parse" value="1" type="hidden" />
          <input type="text" class="form-control" id="exampleInputAmount" disabled placeholder="'.$this->grabl.'" value="'.$this->grabl.'"/>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">GraBB Images</button>
      <div id="jax"></div>
    </form>
    </div>
    <div class="rdy '.$hide.' table-responsive container">
    <table class="table table-hover panel panel-default" data-example-id="default-media">'.Page::show_img().'
    </table>
    </div>
    ';
    }
    
    public static function isEmptyDir($dir){ 
         return (($files = @scandir($dir)) && count($files) <= 2); 
    }
    
    public function show_img()
    {
    $imagesDir = $this->image_dir;
    if(is_dir('./'.$imagesDir)){
    $query = 'SELECT * FROM `tst_images` ORDER BY `date` ASC';
    $select = $this->sql($query);
    $tr .= '<tr class="panel-heading brtop shdw"><th>#name</th><th>#img</th><th>#path</th><th><a onclick="filtr(this);" href="#" class="up">#date</a></th></tr>';
    WHILE($tir = mysql_fetch_assoc($select))
    {
    $tr .= '
    <tr>
    <td>/00'.$tir['name'].'</td>
    <td><img width="'.$this->img_w_out.'" height="'.$this->image_h_out.'" src="'.$tir['new_path'].'00'.$tir['name'].'.png"/></td>
    <td>'.$tir['old_path'].'</td>
    <td>'.$tir['date'].'</td>
    </tr>';
    }return $tr;
    $dn = false;
    }
    else{return 'error';$dn= true;}
    }
    
    public function exec_js()
    {
    echo
    '
    <script id="exec_it"></script>
    ';
    }

}
