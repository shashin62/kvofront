<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

Class SearchController extends AppController {
    
    public $name = 'Search';
    public $uses = array('User', 'People', 'Group', 'PeopleGroup');
    public $helpers = array('Session');
    public $components = array('Session','Tree');
    
    private function __in_array_r($needle, $haystack, $strict = false) {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && $this->__in_array_r($needle, $item, $strict))) {
                return $item;
            }
        }

        return false;
    }

    public function index()
    {
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
        
        $familyDetails = $this->Tree->buildTreeJson($peopleData['group_id']);
        //echo '<pre>';
        //print_r($familyDetails);
        //echo '</pre>';
        
           
        $tmpArray = array();
        
        if (array_key_exists($peopleId, $familyDetails['tree'])) {
            
            $tmpArray[$peopleId][] = $familyDetails['tree'][$peopleId]['n'];
        }
        
        if (isset($familyDetails['tree'][$peopleId]['es']) && $familyDetails['tree'][$peopleId]['es'] != '') {
            $partnerId = $familyDetails['tree'][$peopleId]['es'];
            $tmpArray[$peopleId]['Husband Of'] = $familyDetails['tree'][$familyDetails['tree'][$peopleId]['es']]['n'];
       
        
        if (array_key_exists($partnerId, $familyDetails['tree']) && $familyDetails['tree'][$partnerId]['father'] != '') {
            $fatherId = $familyDetails['tree'][$partnerId]['f'];
            $tmpArray[$peopleId]['Daughter Of'] = $familyDetails['tree'][$familyDetails['tree'][$partnerId]['f']]['n'];
        }
        
        if (array_key_exists($fatherId, $familyDetails['tree']) && $familyDetails['tree'][$fatherId]['father'] != '') {
            $parentFatherId = $familyDetails['tree'][$fatherId]['f'];
            $tmpArray[$peopleId]['Son Of'] = $familyDetails['tree'][$familyDetails['tree'][$fatherId]['f']]['n'];
        }
        
         if (array_key_exists($parentFatherId, $familyDetails['tree']) && $familyDetails['tree'][$parentFatherId]['father'] != '') {
            $parent2FatherId = $familyDetails['tree'][$parentFatherId]['f'];
            $tmpArray[$peopleId]['Son Of'] = $familyDetails['tree'][$parent2FatherId]['n'];
        }
        
        if (array_key_exists($parent2FatherId, $familyDetails['tree']) && $familyDetails['tree'][$parent2FatherId]['father'] != '') {
            $parent3FatherId = $familyDetails['tree'][$parent2FatherId]['f'];
            $tmpArray[$peopleId]['Son Of 1'] = $familyDetails['tree'][$parent3FatherId]['n'];
        }
        
        } else if (array_key_exists($familyDetails['tree'][$peopleId]['f'], $familyDetails['tree']) && $familyDetails['tree'][$peopleId]['father'] != '') {
            if ( $familyDetails['tree'][$peopleId]['g'] == 'f') {
                $duaghterText = 'Daughter Of';
            } else {
                $duaghterText = 'Son Of';
            }
            $partnerId = $familyDetails['tree'][$peopleId]['f'];
            $tmpArray[$peopleId][$duaghterText] = $familyDetails['tree'][$familyDetails['tree'][$peopleId]['f']]['n'];
            
             if (array_key_exists($partnerId, $familyDetails['tree']) && $familyDetails['tree'][$partnerId]['father'] != '') {
            $fatherId = $familyDetails['tree'][$partnerId]['f'];
            $tmpArray[$peopleId]['Son Of'] = $familyDetails['tree'][$familyDetails['tree'][$partnerId]['f']]['n'];
        }
        
        if (array_key_exists($fatherId, $familyDetails['tree']) && $familyDetails['tree'][$fatherId]['father'] != '') {
            $parentFatherId = $familyDetails['tree'][$fatherId]['f'];
            $tmpArray[$peopleId]['Son Of level1'] = $familyDetails['tree'][$familyDetails['tree'][$fatherId]['f']]['n'];
        }
        }
        
        $this->set('treeLinkageData', $tmpArray);
       
    }
}