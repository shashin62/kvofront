<?php

App::uses('AppController', 'Controller');

Class LanguageController extends AppController {
    
    public function switchLanguage() {
        $this->autoRender = false;
        $id = $this->request->data['id'];
        
        $language = $_REQUEST['lang'];
        
        $this->Session->write('Website.language', $language);
        
        echo 'true';
        exit;
    }
}