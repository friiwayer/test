<?
require_once './mod/options.php';

Class Page extends Opt
{   
    public  $body;
    public  $form;
    public  $footer;
    public  $lang;
       
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
        <script type="text/javascript" src="'.$this->_main_dir.'/js/jquery-ui.js"></script>
        <script type="text/javascript" src="'.$this->_main_dir.'/js/Jquery.js"></script>        
        </head>
        '
        ;
    }
    
    
    public function form()
    {
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
    <div class="rdy dn table-responsive">
    <div></div>
    <table class="table"></table>
    </div>
    ';
    }
    
    public function show_img()
    {
    $imagesDir = $this->image_dir;
    if($open = opendir($imagesDir)){
    while (($file = readdir($open)) !==FALSE) 
    {
    if ($file!="."&&$file!="..")
    {
    if(post('imgid')){
    $li .= '<li><a><img onClick="get_imagu(this,'.post('imgid').'); return false;" src="'.$imagesDir.''.$file.'" width="30"  /></a></li>';
    }else{
    $li .= '<li><a><img onClick="get_imagu(this); return false;" src="'.$imagesDir.''.$file.'" width="30"  /></a></li>';
    }
    }
    }
    }else{
    $li = 'wrong direcroty';
    }echo $li;
    }
    
    public function exec_js()
    {
    echo
    '
    <script id="exec_it"></script>
    ';
    }

}
