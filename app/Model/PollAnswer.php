<?php

App::uses('AppModel', 'Model');

class PollAnswer extends AppModel {
    
     var $name = 'PollAnswer';
     
     public $useTable = 'poll_answers';
      
     public function getPollCount ($pollId, $pollOption) {
         $res = $this->find('all', array('conditions' => array('poll_id' => $pollId, 'poll_option' => $pollOption)));
         return count($res) + 1;
     } 
    
}

