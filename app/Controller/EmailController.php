<?php

App::uses('AppController', 'Controller');

Class EmailController extends AppController {
    public $name = 'Email';
    public $uses = array('User','Aro','Role','EmailTemplate');
    public $helpers = array('Session');
    public $components = array('Session');
    
}