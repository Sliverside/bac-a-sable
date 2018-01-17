<?php
class Dispatcher {

  var $request;

  function __construct() {
    # on apelle la class Request
    $this->request = new Request();
    Router::parse($this->request);
    $controller = $this->loadController();
    $action = $this->request->action;
    if(!$this->request->prefix === false){
      $action = $this->request->prefix.'_'.$action;
    }
    if(!in_array($action, array_diff(get_class_methods($controller),get_class_methods('Controller')))) {
      $this->error('le controller "'.$this->request->controller.'" n\'a pas de method "'.$action.'".');
    }
    call_user_func_array(array($controller, $action), $this->request->params);
    $controller->render($action);
  }

  function error($message){
    $controller = new controller($this->request);
    $controller->e404($message);
  }
  function loadController(){
    $name = ucfirst($this->request->controller).'Controller';
    $file = ROOT.DS.'controllers'.DS.$name.'.php';
    if(file_exists($file)){
      require $file;
      return new $name($this->request);
    }else {
      $this->error(Conf::$debug >= 1 ? 'le controller "'.$this->request->controller.'Controller" n\'existe pas' : 'page introuvable');
    }
  }

}
?>
