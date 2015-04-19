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
    public $uses = array('User', 'People', 'Group', 'PeopleGroup');
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
        $peopleData = $data['People'];
        $groupData = $data['Group'];
        $addressData = $data['Address'];
        
        $this->set('peopleData', $peopleData);
        $this->set('groupData', $groupData);
        $this->set('addressData', $addressData);

        $familyDetails = $this->Tree->buildFamilyJson($peopleId);
        $searchedName[] = $peopleData['first_name'] . ' ' . $peopleData['last_name'];        

        $treeData = $this->__getDetails($familyDetails['tree'], $peopleId, false);
        $tree = array_merge($searchedName, $treeData);
        
        $this->set('treeLinkageData', $tree);
    }
    
    /**
     * Function to iterate through tree and find linkage
     * 
     * @param type $data
     * @param type $id
     * @param type $type
     * @return type
     */
    private function __getDetails($data, $id, $type = false) {
        $array = array();
        if ($data[$id]['es'] != '' && $type == false) {
            $array[] = '<span style="font-size:12px;">--<b>Husband Of</b>--></span>';
            $array[] = $data[$id]['partner_name'];
            $familyDetails = $this->Tree->buildFamilyJson($data[$id]['es']);
            $array1 = $this->__getDetails($familyDetails['tree'], $data[$id]['es'], true);
            $array = array_merge($array, $array1);
        } else if ($data[$id]['f'] != '') {
            if ($data[$id]['g'] == 'f') {
                $text = '<span style="font-size:12px;">--<b>Daughter of</b>--></span>';
            } else {
                $text = '<span style="font-size:12px;">--<b>Son of</b>--></span>';
            }
            $array[] = $text;
            $array[] = $data[$data[$id]['f']]['n'];
            $familyDetails = $this->Tree->buildFamilyJson($data[$id]['f']);
            $flag = false;
            if ($familyDetails['tree'][$data[$id]['f']]['f'] != '') {
                $flag = true;
            }
            $array2 = $this->__getDetails($familyDetails['tree'], $data[$id]['f'], $flag);
            $array = array_merge($array, $array2);
        }
        return $array;
    }

}
