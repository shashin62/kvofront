<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

Class SearchController extends AppController {

    /**
     *
     * @var type 
     */
    public $name = 'Search';

    /**
     *
     * @var type 
     */
    public $uses = array('User', 'People', 'Group', 'PeopleGroup', 'Sister', 'Brother');

    /**
     *
     * @var type 
     */
    public $helpers = array('Session');

    /**
     *
     * @var type 
     */
    public $components = array('Session', 'Tree');
    public $peopleIds = [];

    /**
     * 
     * @param type $needle
     * @param type $haystack
     * @param type $strict
     * @return boolean
     */
    private function __in_array_r($needle, $haystack, $strict = false) {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && $this->__in_array_r($needle, $item, $strict))) {
                return $item;
            }
        }
        return false;
    }

    /**
     * 
     */
    public function index() {
        $peopleId = $this->request->data['id'];

        //for profile
        if (!$peopleId) {
            $peopleId = $this->Session->read('User.user_id');
        }

        $data = $this->People->search($peopleId);

        $loggedUserData = $this->People->search($this->Session->read('User.user_id'));
        $sisters = $this->Sister->getSisters($this->Session->read('User.user_id'));
        $brothers = $this->Brother->getBrothers($this->Session->read('User.user_id'));

        foreach ($loggedUserData as $d1 => $d3) {
            $this->peopleIds[] = $d3['id'];
            $this->peopleIds[] = $d3['f_id'];
            $this->peopleIds[] = $d3['m_id'];
            $this->peopleIds[] = $d3['partner_id'];
            foreach ($sisters as $ks => $vs) {
                $this->peopleIds[] = $vs;
            }
            foreach ($brothers as $kb => $vb) {
                $this->peopleIds[] = $vb;
            }
            //$this->peopleIds[] = $d3['brother_id'];
        }
        $peopleData = $data['People'];
        $groupData = $data['Group'];
        $addressData = $data['Address'];
        $userID = $this->Session->read('User.user_id');
        $this->set('peopleData', $peopleData);
        $this->set('groupData', $groupData);
        $this->set('addressData', $addressData);
        $treeData = $this->Tree->buildTreeJson($groupData['group_id']);
        $dataTree = $this->_buildLinkage($treeData['tree'], $this->request->data['id'], $userID, false);
        $searchedName[] = $peopleData['first_name'] . ' ' . $peopleData['last_name'];
        $tree = array_merge($searchedName, $dataTree);
        $this->set('treeLinkageData', $tree);
    }
    
    /**
     * 
     * @param type $data
     * @param type $searchedId
     * @param type $userId
     * @param type $flag
     * @return type
     */
    private function _buildLinkage($data, $searchedId, $userId, $flag) {
        //echo '<pre>';
       // print_r($data[$searchedId]);
       // echo '</pre>';

        if ($userId == $data[$searchedId]['f']) {

            if ($data[$searchedId]['g'] == 'f') {
                $text = '<span style="font-size:12px;">--<b>Daughter of</b>--></span>';
            } else {
                $text = '<span style="font-size:12px;">--<b>Son of</b>--></span>';
            }
            $array[] = $text;
            $array[] = $data[$data[$searchedId]['f']]['n'];
        } else if (count($data[$searchedId]['c']) && in_array($userId, $data[$searchedId]['c'])) {
            $childId = array_search($userId, $data[$searchedId]['c']);
            if ($data[$searchedId]['g'] == 'f') {
                $text = '<span style="font-size:12px;">--<b>Mother of</b>--></span>';
            } else {
                $text = '<span style="font-size:12px;">--<b>Father of</b>--></span>';
            }
            $array[] = $text;
            $array[] = $data[$data[$searchedId]['c'][$childId]]['n'];
        } else if (count($data[$searchedId]['bid']) & in_array($userId, $data[$searchedId]['bid'])) {

            $brotherId = array_search($userId, $data[$searchedId]['bid']);

            if ($data[$searchedId]['g'] == 'f') {
                $text = '<span style="font-size:12px;">--<b>Sister of</b>--></span>';
            } else {
                $text = '<span style="font-size:12px;">--<b>Brother of</b>--></span>';
            }
            $array[] = $text;
            
            if ($brotherId == 0) {
                $array[] = $this->Session->read('User.first_name') . ' ' . $this->Session->read('User.last_name');
              
            } else  {
                 $array[] = $data[$data[$searchedId]['bid'][$brotherId]]['n'];
            }
        } else if (count($data[$searchedId]['sid']) && in_array($userId, $data[$searchedId]['sid'])) {
            exit;
        } else if (count(array_intersect($data[$searchedId]['sid'], $this->peopleIds))) {

            $common = array_values(array_intersect($data[$searchedId]['sid'], $this->peopleIds));
            $textLabel = 'Sister of';
            if ($data[$searchedId]['g'] == 'm') {
                $textLabel = 'Brother of';
            }
            $text = '<span style="font-size:12px;">--<b>' . $textLabel . ' </b>--></span>';
            $array[] = $text;
            $array[] = $data[$common[0]]['n'];
            if ($common[0] != $this->Session->read('User.user_id')) {
                $array1 = $this->_buildLinkage($data, $common[0], $this->Session->read('User.user_id'));
                $array = array_merge($array, $array1);
            }
        } else if ($data[$searchedId]['es'] != '' && in_array($data[$searchedId]['es'], $this->peopleIds)) {
            if ($data[$searchedId]['g'] == 'f') {
                $text = '<span style="font-size:12px;">--<b>Wife of</b>--></span>';
            } else {
                $text = '<span style="font-size:12px;">--<b>Husband of</b>--></span>';
            }
            $array[] = $text;
            $array[] = $data[$data[$searchedId]['es']]['n'];
            if ($data[$searchedId]['es'] != $this->Session->read('User.user_id')) {
                $array1 = $this->_buildLinkage($data, $data[$searchedId]['es'], $this->Session->read('User.user_id'));
                $array = array_merge($array, $array1);
            }
        } else if ($userId == $data[$searchedId]['m']) {
            
        } else if (count(array_intersect($data[$searchedId]['c'], $this->peopleIds))) {
            $common = array_values(array_intersect($data[$searchedId]['c'], $this->peopleIds));
            $textLabel = 'Mother of';
            if ($data[$searchedId]['g'] == 'm') {
                $textLabel = 'Father of';
            }
            $text = '<span style="font-size:12px;">--<b>' . $textLabel . ' </b>--></span>';
            $array[] = $text;
            $array[] = $data[$common[0]]['n'];
            if ($common[0] != $this->Session->read('User.user_id')) {
                $array1 = $this->_buildLinkage($data, $common[0], $this->Session->read('User.user_id'));
                $array = array_merge($array, $array1);
            }
        } else if (count($data[$searchedId]['sid']) && is_array($data[$searchedId]['sid']) && $flag == false) {

            $textLabel = 'Sister of';
            if ($data[$searchedId]['g'] == 'm') {
                $textLabel = 'Brother of';
            }
            $text = '<span style="font-size:12px;">--<b>' . $textLabel . ' </b>--></span>';
            $array[] = $text;
            $array[] = $data[$data[$searchedId]['sid'][0]]['n'];

            if ($data[$searchedId]['sid'][0] != $this->Session->read('User.user_id')) {
                $array1 = $this->_buildLinkage($data, $data[$searchedId]['sid'][0], $this->Session->read('User.user_id'), true);
                $array = array_merge($array, $array1);
            }
        } else if (count($data[$searchedId]['bid']) && is_array($data[$searchedId]['bid']) && $flag == false) {

            $textLabel = 'Sister of';
            if ($data[$searchedId]['g'] == 'm') {
                $textLabel = 'Brother of';
            }
            $text = '<span style="font-size:12px;">--<b>' . $textLabel . ' </b>--></span>';
            $array[] = $text;
            $array[] = $data[$data[$searchedId]['bid'][0]]['n'];

            if ($data[$searchedId]['bid'][0] != $this->Session->read('User.user_id')) {
                $array1 = $this->_buildLinkage($data, $data[$searchedId]['bid'][0], $this->Session->read('User.user_id'), true);
                $array = array_merge($array, $array1);
            }
        } else if ($data[$searchedId]['f'] != '') {

            if ($data[$searchedId]['g'] == 'f') {
                $text = '<span style="font-size:12px;">--<b>Daughter of</b>--></span>';
            } else {
                $text = '<span style="font-size:12px;">--<b>Son of</b>--></span>';
            }
            $array[] = $text;
            $array[] = $data[$data[$searchedId]['f']]['n'];
            if ($data[$searchedId]['f'] != $this->Session->read('User.user_id')) {
                $array1 = $this->_buildLinkage($data, $data[$searchedId]['f'], $this->Session->read('User.user_id'));
                $array = array_merge($array, $array1);
            }
        }
        return $array;
    }
}
