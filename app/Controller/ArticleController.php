<?php

App::uses('AppController', 'Controller');

Class ArticleController extends AppController {
    
    public $name = 'Article';
    
    public $uses = array('Article');

    public function index() {  
        $noOfRecs = $this->Article->find('count');
        
        $this->set('recordsTotal', $noOfRecs);
    }
    
    public function gridArticles() {
        $this->layout = 'ajax';
        $this->autoRender = false;
        
        $start = isset($this->request->data['start']) ? (int) $this->request->data['start'] : 0;
        $length = isset($this->request->data['length']) ? (int) $this->request->data['length'] : 9;
        
        $articles = $this->Article->getAllArticles($start, $length);
        
        /*$result = array(
            "recordsTotal" => $noOfRecs,
            "data" => $data
        );*/
        

        echo json_encode($articles);
    }
    
    public function detail() {
        $data = $this->Article->find('all', array(
            'conditions' => array('Article.id' => $_REQUEST['id']))
        ); 
        
        $this->set('data', $data[0]['Article']);
    }

}   