<?php
class Request{

  public $url;
  public $page = 1;
  public $prefix = false;

  function __construct(){
    # initialise la variable public url contenant l'url appelé par le visiteur
    $this->url = isset($_SERVER['PATH_INFO'])?$_SERVER['PATH_INFO']:'/';
    $this->url = trim( $this->url,'/');
    if(isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0){
      $this->page = round($_GET['page']);
    }
  }

}
?>
