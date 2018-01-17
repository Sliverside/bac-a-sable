<?php

class PagesController extends Controller{

  function view($id){
    $this->loadModel('post');
    $vars['page'] = $this->post->findFirst(array(
      'fields' => 'ID,state,type,content,name,created,slug',
      'conditions' => array(
        $this->post->primaryKey => $id,
        'state' => 1,
        'type' => 'page'
      )
    ));
    if(empty($vars['page'])) {
      $this->e404('page introuvable');
    }
    $this->set($vars);
  }

  function getPagesMenu(){
    $this->loadModel('post');
    return $this->post->find(array(
      'fields' => 'ID, name, slug',
      'conditions' => array(
        'state' => 1,
        'type' => 'page'
      )
    ));
  }

}

?>
