<?php $title_for_head = APP_NAME.' | Blog'; ?>
<h1>Blog</h1>
<?= $count['all']==0?'<p>Aucun article disponible, reviens plus tard !</p>':'' ?>
<?php foreach ($posts as $post) : ?>
 <article class="singlePost">
   <h2><a href="<?php echo Router::url("posts/view/slug:{$post->slug}"); ?>"><?php echo $post->name; ?></a></h2>
   <p><?php echo $post->created; ?></p>
   <?php echo $post->content; ?>
 </article>
<?php endforeach; ?>
<div class="pagination">
  <?php for ($i=1; $i<=$pageNumber; $i++): ?>
    <a
      <?php if($this->request->page == $i):?> class="curent-page" <?php endif; ?>
      href="?page=<?php echo $i; ?>"><?php echo $i; ?>
    </a>
  <?php endfor; ?>
</div>
