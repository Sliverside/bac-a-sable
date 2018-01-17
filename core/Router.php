<?php
class Router{

  static $routes = array();
  static $prefixes = array();

  static function prefix($url, $prefix){
    self::$prefixes[$url] = $prefix;
  }

  /**
  * Permet de parser une url
  * @param $url URL à parser
  **/
  static function parse($request){
    $url = $request->url;
    $params =  explode('/',$url);
    if($params[0]===""){
      $params = explode('/',self::$routes[0]['url']);
    } elseif(!in_array($params[0], array_keys(self::$prefixes))){ // if first param is a prefix in $prefixes
      foreach(self::$routes as $route){
        if(preg_match($route['catcher'], $url, $match)){
          if(isset($match['controller'])){
            $request->controller = $match['controller'];
            $request->action = explode('/', trim($match['args'], '/'), 1)[0];
          }else{
            $request->controller = $route['controller'];
            $request->action = isset($match['action'])? $match['action'] : $route['action'];
          }
          $request->params = array();
          foreach($route['params'] as $param_name=>$param_value){
            $request->params[$param_name] = $match[$param_name];
          }
          if(!empty($match['args'])){
            $request->params += explode('/', trim($match['args'], '/'));
          }
          return true;
        }
      }
    }
    if(in_array($params[0], array_keys(self::$prefixes))){
      $request->prefix = self::$prefixes[$params[0]];
      array_shift($params);
    }
    $request->controller = isset($params[0]) ? $params[0] : '';
    $request->action = isset($params[1]) ? $params[1] : 'index';
    $request->params = array_slice($params, 2);
    return true;
  }

  private function format_url($url){
    return '/^'.str_replace('/','\/', $url).'$/';
  }

  static function set_home_page($url){
    Router::connect('/', $url);
  }

  static function connect($redir, $url){
    $r = array();
    $r['params'] = array();
    $r['url'] = $url;
    $r['origin'] = str_replace(':action', '(?P<action>([a-z0-9]+))', $url);
    $r['origin'] = preg_replace('/([a-z0-9]+):([^\/]+)/','${1}:(?P<${1}>${2})', $r['origin']);
    $r['origin'] = self::format_url($r['origin'].'(?P<args>/?.*)');
    $r['redir'] = $redir;

    $params = explode('/', $url);
    foreach($params as $k=>$v){
      if(strpos($v,':')){
        $p = explode(':', $v);
        $r['params'][$p[0]] = $p[1];
      }else{
        if($k==0){
          $r['controller'] = $v;
        }elseif($k==1){
          $r['action'] = $v;
        }
      }
    }
    $r['catcher'] = $redir;
    $r['catcher'] = str_replace(':action', '(?P<action>([a-z0-9]+))', $r['catcher']);

    foreach($r['params'] as $k=>$v){
      $r['catcher'] = str_replace(":$k", "(?P<$k>$v)", $r['catcher']);
    }
    $r['catcher'] = self::format_url($r['catcher'].'(?P<args>/?.*)');
    self::$routes[] = $r;
  }

  static function url($url){
    foreach (self::$prefixes as $k => $v) {
      if(strpos($url, $v) === 0){
        $url = str_replace($v, $k, $url);
        break;
      }
    }
    foreach(self::$routes as $k => $route){
      if(preg_match($route['origin'], $url, $match)){
        # permet de suprimer les expressions régulières (ou autre)
        # qui sont entre parenthèses
        for( ;strpos($route['redir'],'(') && strpos($route['redir'],')'); ){
          $excludeStart= strpos($route['redir'],'(');
          $excludeLength= strpos($route['redir'],')') - $excludeStart + 1;
          $excludeStr= substr($route['redir'], $excludeStart, $excludeLength);
          $route['redir']= str_replace($excludeStr, '', $route['redir']);
        }
        foreach($match as $k => $v){
          if(!is_numeric($k)){
            $route['redir'] = str_replace(":$k",$v, $route['redir']);
          }
        }
        return BASE_URL.str_replace('//', '/', '/'.$route['redir'].$match['args']);
      }
    }
    return BASE_URL.'/'.$url;
  }

}
?>
