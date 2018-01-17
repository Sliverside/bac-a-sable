<?php require ROOT.DS.'templates'.DS.'head.php'; ?>
<?=$GLOBALS['debug_for_header'];?>
<?php require ROOT.DS.'templates'.DS.'main-header.php'; ?>
<div id="main-content">
<?= $content_for_layout; ?>
</div>
<?php require ROOT.DS.'templates'.DS.'main-footer.php'; ?>
<?php require ROOT.DS.'templates'.DS.'foot.php'; ?>
