<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

Class SearchController extends AppController {

    public $name = 'Search';
    public $uses = array('User', 'People', 'Group', 'PeopleGroup');
    public $helpers = array('Session');
    public $components = array('Session', 'Tree');

    private function __in_array_r($needle, $haystack, $strict = false) {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && $this->__in_array_r($needle, $item, $strict))) {
                return $item;
            }
        }

        return false;
    }

    public function index() {
        $peopleId = $this->request->data['id'];
        $data = $this->People->search($peopleId);

        $peopleData = $data['People'];
        $groupData = $data['Group'];
        $addressData = $data['Address'];
        
        $this->set('peopleData', $peopleData);
        $this->set('groupData', $groupData);
        $this->set('addressData', $addressData);

        $familyDetails = $this->Tree->buildFamilyJson($peopleId);
        $d[] = $peopleData['first_name'] . ' ' . $peopleData['last_name'];
        
        $treeData = $this->__getDetails($familyDetails['tree'], $peopleId, false);
        $tree = array_merge($d, $treeData);
        

        $this->set('treeLinkageData', $tree);
    }

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
            $array[] = $data[$id]['father'];
            $familyDetails = $this->Tree->buildFamilyJson($data[$id]['f']);
            if ($familyDetails['tree'][$data[$id]['f']]['f'] != '') {
                $flag = true;
            } else {
                $flag = false;
            }
            $array2 = $this->__getDetails($familyDetails['tree'], $data[$id]['f'], $flag);
            $array = array_merge($array, $array2);
        }
        return $array;
    }

}
