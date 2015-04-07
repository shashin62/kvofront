<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

Class SearchController extends AppController {
    
    public $name = 'Search';
    public $uses = array('User', 'People', 'Group', 'PeopleGroup');
    public $helpers = array('Session');
    public $components = array('Session');
    
    public function index()
    {
        $userId = $this->Session->read('User.user_id');
        $peopleId = $this->request->data['id'];
        
        $data = $this->People->search($peopleId);
        
        
        $peopleData = $data['People'];
        $groupData = $data['Group'];
        $addressData = $data['Address'];
        
        $this->set('peopleData', $peopleData);
        $this->set('groupData', $groupData);
        $this->set('addressData', $addressData);
    }
}