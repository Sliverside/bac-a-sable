<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="<?php WEBROOT.DS.'stylsheets'.DS.'main.css' ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="Template pour un nouveau projet">
    <meta name="keywords" content="PHP,HTML,CSS,JavaScript">
    <meta name="author" content="Lilian Moulanier">
    <link rel="stylesheet" href="<?=BASE_URL.'/webroot/stylesheets/main.css'?>">
    <?= onDebugMode('<link rel="stylesheet" href="'.BASE_URL.'/webroot/addons/debugger/debugger.css">') ?>
    <title><?= isset($title_for_head) ? $title_for_head : APP_NAME.' | '.$this->request->action; ?></title>
  </head>
<body>
