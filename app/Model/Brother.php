<?php

App::uses('AppModel', 'Model');

class Brother extends AppModel {
    
    
    
    public function getBrothers($id) {
          $this->recursive = -1;
          $options['fields'] = array('Brother.brother_id');
        $options['conditions'] = array('Brother.people_id' => $id);
      
        try {
            $userData = $this->find('list', $options);
            if ($userData) {
                return $userData;
            } else {
                return array();
            }
        } catch (Exception $e) {
            CakeLog::write('db', __FUNCTION__ . " in " . __CLASS__ . " at " . __LINE__ . $e->getMessage());
            return false;
        }
    }
}