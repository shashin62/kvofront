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
        
        $selLang = $this->Session->read('Website.language');
        
        $start = isset($this->request->data['start']) ? (int) $this->request->data['start'] : 0;
        $length = isset($this->request->data['length']) ? (int) $this->request->data['length'] : 9;
        
        $articles = $this->Article->getAllArticles($start, $length, $selLang);        

        echo json_encode($articles);
    }
    
    public function detail() {
        $data = $this->Article->find('all', array(
            'conditions' => array('Article.id' => $this->request->params['pass'][0]))
        ); 
        
        $fData = $data[0]['Article'];
        
        $selLang = $this->Session->read('Website.language');
        
        if ($selLang == 'gujurati') {
            $fData['title'] = ($fData['title_gujurati'] != '' && $fData['title_gujurati'] != NULL) ? $fData['title_gujurati'] : $fData['title'];
            $fData['author'] = ($fData['author_gujurati'] != '' && $fData['author_gujurati'] != NULL) ? $fData['author_gujurati'] : $fData['author'];
            $fData['body'] = ($fData['body_gujurati'] != '' && $fData['body_gujurati'] != NULL) ? $fData['body_gujurati'] : $fData['body'];
        } elseif ($selLang == 'hindi') {
            $fData['title'] = ($fData['title_hindi'] != '' && $fData['title_hindi'] != NULL) ? $fData['title_hindi'] : $fData['title'];
            $fData['author'] = ($fData['author_hindi'] != '' && $fData['author_hindi'] != NULL) ? $fData['author_hindi'] : $fData['author'];
            $fData['body'] = ($fData['body_hindi'] != '' && $fData['body_hindi'] != NULL) ? $fData['body_hindi'] : $fData['body'];
        }

        $this->set('data', $fData);
    }

}   