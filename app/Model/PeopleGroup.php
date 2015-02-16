<?php
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');

Class PeopleGroup extends AppModel
{
    
     public function checkExistsInOtherGroup($groupId, $peopleId)
    {
         $this->recursive = -1;
        $dbh = $this->getDataSource();
        
          $options['conditions']['PeopleGroup.group_id !='] = $groupId;
          $options['conditions']['PeopleGroup.people_id '] = $peopleId;
        $options['fields'] = array('PeopleGroup.group_id','PeopleGroup.tree_level');
        
        try {
            $userData = $this->find('all', $options);
            if ($userData && isset($userData[0]) ) {
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