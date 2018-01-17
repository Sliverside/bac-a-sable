<?php require ROOT.DS.'templates'.DS.'head.php'; ?>
<?=$GLOBALS['debug_for_header'];?>
<header id="main-header">
  <p>Admin</p>
  <nav id="main-nav">
    <a href="<?= BASE_URL ?>"><?= APP_NAME ?></a>
    <a href="<?= Router::url("_admin/posts/index"); ?>">Articles</a>
  </nav>
</header>
<div id="main-content">
<?= $content_for_layout; ?>
</div>
<?php require ROOT.DS.'templates'.DS.'main-footer.php'; ?>
<?php require ROOT.DS.'templates'.DS.'foot.php'; ?>
