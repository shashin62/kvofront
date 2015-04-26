<?php

App::uses('AppModel', 'Model');

class Sister extends AppModel {
    
    
    
    public function getSisters($id) {
        $this->recursive = -1;
        $options['fields'] = array('Sister.sister_id');
        $options['conditions'] = array('Sister.people_id' => $id);
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