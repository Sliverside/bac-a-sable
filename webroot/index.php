<?php

$debut = microtime(true);

# toutes les request qui ne correspondent pas à un dossier ou fichier
# son redirigées vers cette page, on définis des constante pour accéder
# plus facilement au dossier du site

# nom de l'application
define('APP_NAME', 'Bac à sable');

# separator universelle (/ ou \)
define('DS', DIRECTORY_SEPARATOR);

# lien vers le dossier webroot
define('WEBROOT', dirname(__FILE__));

# lien vers la racine du site
define('ROOT', dirname(WEBROOT));

# lien vers le dossier core du site
define('CORE', ROOT.DS.'core');

# lien vers le dossier du site
  define('BASE_URL', dirname(dirname($_SERVER['SCRIPT_NAME'])));

# on appelle le fichier includes.php qui sert à importer plus facilement
# les ellement principaux du site
require CORE.DS.'includes.php';

# on appelle le class Dispacher (précedement inclus grace au fichier
# includes.php)
new Dispatcher();

if(conf::$ServGenTime == true){
  echo "<p style='margin:0; padding: 3px; position: fixed; bottom:0; left:0; right:0; background-color:rgba(161,48,36,0.8); '> page générée en ".round(microtime(true) - $debut, 5)."s</p>";
}

?>
