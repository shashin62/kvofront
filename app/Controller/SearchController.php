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
    }
}