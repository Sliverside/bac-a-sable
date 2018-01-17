<?php $title_for_head = 'Articles | admin - '.APP_NAME; ?>

<h1>Articles</h1>
<?php
echo '<p>Nombre d\'articles : ';
echo $count['all'].'
      (en ligne'.($count['online']>1?'s':'').' : '.$count['online'].',
      brouillon'.($count['draft']>1?'s':'').' : '.$count['draft'].').';
echo '</p>';
?>

<h2>Liste :</h2>

<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Slug</th>
      <th>Content</th>
      <th>Etat</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($posts as $post): ?>
      <tr>
        <td><?=$post->ID?></td>
        <td><?=$post->name?></td>
        <td><?=$post->slug?></td>
        <td><?=$post->content?></td>
        <td><?=$post->state==1?'online':'brouillon'?></td>
        <td>
          <a href='<?=Router::url("_admin/posts/edit/$post->slug");?>'>edit</a> |
          <a href='<?=Router::url("_admin/posts/delete/$post->slug");?>'>delete</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
