<?php

class Conf{

  static $debug = 1;
  static $ServGenTime = true;
  static $databases = array(

    'default' => array(
      'host'     => 'localhost',
      'database' => 'bac-a-sable',
      'login'    => 'bac-a-sable',
      'password' => 'Qx3akaYC3HoZWdpn'
    )

  );

}

Router::prefix('manager', '_admin');

# il faut penser à trier les règles par ordre d'importance, dans la plupart
# des cas si ce n'est tous, moins la règle est précise plus son
# importance est haute
Router::set_home_page('pages/view/ma-premiere-page');
Router::connect('/', 'pages/view/slug:(ma-premiere-page)');
Conf::$debug>0?Router::connect('noredir/:controller', 'controller:([a-z0-9\-]+)'):'';

Router::connect('blog/:slug', 'posts/view/slug:([a-z0-9\-]+)');
Router::connect('blog(/?$)', 'posts/index');

Router::connect(':slug', 'pages/view/slug:([a-z0-9\-]+)');
?>
