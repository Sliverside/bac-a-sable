<?php

class PostsController extends Controller {

  function index(){
    $this->loadModel('post');
    $perPage = 2;
    $conditions = array('state' => 1, 'type' => 'post');
    $vars['posts'] = $this->post->find(array(
      'fields' => 'ID,state,type,content,name,created,slug',
      'conditions' => $conditions,
      'limit' => ($perPage*($this->request->page-1)).','.$perPage
    ));
    $vars['count']['all'] = $this->post->findCount($conditions);
    $vars['pageNumber'] = ceil($vars['count']['all']/$perPage);
    $this->set($vars);
  }

  function view($id){
    $this->loadModel('post');
    $vars['post'] = $this->post->findFirst(array(
      'fields' => 'ID,state,type,content,name,created,slug',
      'conditions' => array(
        $this->post->primaryKey => $id,
        'state' => 1,
        'type' => 'post'
      )
    ));
    if(empty($vars['post'])) {
      $this->e404('Article introuvable');
    }
    $this->set($vars);
  }

  function _admin_index(){
    $this->loadModel('post');
    $perPage = 5;
    $conditions = array('type' => 'post');
    $vars['posts'] = $this->post->find(array(
      'conditions' => $conditions,
      'limit' => ($perPage*($this->request->page-1)).','.$perPage
    ));
    $vars['count']['online'] = $this->post->findCount(array('state' => 1, 'type' => 'post'));
    $vars['count']['all'] = $this->post->findCount($conditions);
    $vars['count']['draft'] = $vars['count']['all'] - $vars['count']['online'];
    $vars['pageNumber'] = ceil($vars['count']['all']/$perPage);
    $this->set($vars);
  }

  function _admin_delete($id){
    $this->loadModel('post');
    $this->post->delete($id);
    $this->redirect('_admin/posts/index');
  }
}

?>
