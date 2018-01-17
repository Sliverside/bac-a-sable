<?php
/**
*Controller
**/
class Controller{

  public $request;            # objet request
  public $layout = 'default'; # layout à utiliser pour rendre la vue
  public $vars = array();     # variables à passer à la vue
  private $rendered = false;  # le rendu à été fait ou pas

  /**
  * Constructeur
  * @param $request Objet request de notre application
  **/
  function __construct($request = null){
    if($request) {
      $this->request = $request; # on stocke l'objet request dans l'instance
      require ROOT.DS.'config'.DS.'hook.php';
    }
  }

  /**
  * Permet de rendre une vue
  * @param $view du fichier à rendre (nom du fichier ou chemin depuis /views)
  **/
  public function render($view){
    if($this->rendered){
      return false;
    }
    extract($this->vars);
    if(strpos($view, DS) === 0){
      $view = ROOT.DS.'views'.$view.'.php';
    }else{
      $view = ROOT.DS.'views'.DS.$this->request->controller.DS.$view.'.php';
    }
    ob_start();
    require($view);
    $content_for_layout = ob_get_clean();
    require(ROOT.DS.'views'.DS.'layouts'.DS.$this->layout.'.php');
    $this->rendered = true;
  }

  /**
  * Permet d'initialiser une ou plusieurs variables à passer à la vue
  * @param $key Nom de la variables OU tableaux de variables
  * @param $value Valeur de la variable
  **/
  public function set($key, $value = null){
    if(is_array($key)){
      $this->vars += $key;
    }else{
      $this->vars[$key] = $value;
    }
  }

  /**
  * Permet de charger un Model
  * @param $name Nom du model
  **/
  function loadModel($name) {
    $file = ROOT.DS.'models'.DS.$name.'.php';
    require_once($file);
    if(!isset($this->$name)){
      $this->$name = new $name();
    }
  }

  function e404($message){
    header("HTTP/1.0 404 Not Found");
    $this->set(array(
      'title_for_head'=> APP_NAME.' | Page introuvable',
      'message' => $message
    ));
    $this->render(DS.'errors'.DS.'404');
    die();
  }
  /**
  *Permet d'appeler un controller depuis une vue
  **/
  function request($controller, $action){
    $controller .= 'Controller';
    require_once ROOT.DS.'controllers'.DS.$controller.'.php';
    $c = new $controller();
    return $c->$action();
  }

  function redirect($url, $code = null){
    if($code == 301) {
      header('Status: 301 Moved Permanently', false, 301);
    }
    header("location: ".Router::url($url));
  }

}

?>
