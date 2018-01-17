<?php

$debug_for_header='';

/**
 * Renvoie $string uniquement quand le mode debug est à un certain niveau
 * @param $string Le text à renvoyer
 * @param $lvl le niveau minimun de debug pour afficher $string
 */
function onDebugMode($string, $lvl= 1){
  if(conf::$debug >= $lvl){
    return $string;
  }
}

/**
 * 
 */
function debug($var, $title='', $toTop=false){
  if (conf::$debug > 0){
    $title= $title !== '' ? 'DEBUG : '.$title : 'DEBUG';
    $title.= $toTop?' (toTop=true)':'';
    $debug = debug_backtrace();
    ob_start();
    ?>
    <pre class='debuger-container'>
    <h2>## <?= $title ?> ##</h2>
    <span class='debugger-trace'><?= $debug[0]['file']." -> line ".$debug[0]['line'] ?></span><br><br>
    <p class='debugger-toggleBacktrace'>Backtrace ></p>
    <div class='debugger-backtrace'>
      <ol>
        <?php foreach ($debug as $k => $v) : if($k>0) : ?>
          <li><?= $v['file']." -> line ".$v['line'] ?></li>
        <?php endif; endforeach; ?>
      </ol>
    </div>
    <span>
    <?php
    if($var === TRUE){
      echo '$var == (bol)TRUE';
    }elseif($var === FALSE){
      echo '$var == (bol)FALSE';
    }elseif($var === NULL){
      echo '$var == NULL ou n\'est pas accessible';
    }elseif($var === ""){
        echo '$var est un `string` vide ($var = "")';
    }elseif(is_numeric($var) && !is_string($var)){
      echo '$var == (num)'.$var;
    }else{
      echo htmlentities(print_r($var, true), ENT_QUOTES | ENT_XML1, 'UTF-8');
    }
    ?>
    </span>
    </pre>
    <?php
    $output = preg_replace(array('/\>\s+/','/\s+\</'), array('>','<'), ob_get_clean());
    if($toTop){$GLOBALS['debug_for_header'] .= $output;}else{echo $output;};
  }
}

 ?>
