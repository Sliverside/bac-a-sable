<nav id="main-nav">
  <?php $pagesMenu = $this->request('pages', 'getPagesMenu'); ?>
  <?php foreach ($pagesMenu as $p) : ?>
  <a
    href="<?php echo Router::url("pages/view/slug:$p->slug"); ?>"
    <?php if(isset($page) && $page != '' && $p->ID == $page->ID) : ?>class="current-page"<?php endif;?>
  >
    <?php echo $p->name ?>
  </a>
  <?php endforeach; ?>
  <a href="<?php echo Router::url('posts/index'); ?>">Blog</a>
</nav>
