<?php

App::uses('AppModel', 'Model');

class Poll extends AppModel {
    
     var $name = 'Poll';
     
     public $useTable = 'polls';
     
     /**
     * Function to check if name exists in table
     * 
     * @param type $name
     * 
     * @return boolean 
     */
    public function checkPollExists($name) {
        $this->recursive = -1;
        $options['conditions'] = array('Poll.name' => $name);
        $options['fields'] = array('Poll.id');
        try {
            $data = $this->find('all', $options);
            if ($data && isset($data[0]['Poll']) && $data[0]['Poll'] != "") {
                return $data[0]['Poll'];
            } else {
                return array();
            }
        } catch (Exception $e) {
            CakeLog::write('db', __FUNCTION__ . " in " . __CLASS__ . " at " . __LINE__ . $e->getMessage());
            return false;
        }
    }
    
}

