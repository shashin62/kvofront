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
        $userID = $this->Session->read('User.user_id');
        $this->set('peopleData', $peopleData);
        $this->set('groupData', $groupData);
        $this->set('addressData', $addressData);

        $familyDetails = $this->Tree->buildFamilyJson($peopleId);
//         echo '<pre>';
//        print_r($familyDetails);
//        echo '</pre>';
        $searchedName[] = $peopleData['first_name'] . ' ' . $peopleData['last_name'];        
        
        $treeData = $this->__getDetails($familyDetails['tree'], $peopleId, false, $userID, $this->request->data['id']);
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
    private function __getDetails($data, $id, $type = false, $userId = false, $searchedId = false) {
            $ids[] = $id;
//       echo '<pre>';
//       print_r($data);
//       echo '</pre>';
        $array = array();
        //$tmpArray = array();
        if ( $userId && $searchedId) {
        foreach ( $data as $k => $v ) {
            if ( in_array($searchedId,$v, true) ) {
                
                if ( $v['f'] == $userId || $v['m'] == $userId || $v['es'] == $userId  || in_array($userId, $v['c'], true)) {
                    $tmpArray[$k] = $v;//$data[$searchedId];
                }  else if ( $userId == $v['bid']) {
                    
                    $tmpArray[$k] = $v[$v['bid']];//$data[$searchedId];
                }
            }
        }
        } else {
            $searchedId = $id;
            $tmpArray = $data;
        }
        
        $tmpArray[$searchedId] = $data[$searchedId];
     // echo '<pre>';
    //  print_r($tmpArray);
      //echo $searchedId
      //echo '</pre>';
        
        if ($tmpArray[$searchedId]['bid'] != '' && $type == false) {
            $text = '<span style="font-size:12px;">--<b>Brother of</b>--></span>';
            $array[] = $text;
            $array[] = $data[$tmpArray[$searchedId]['bid']]['n'];
            $familyDetails = $this->Tree->buildFamilyJson($tmpArray[$searchedId]['bid']);
            $flag = true;
           
            $array4 = $this->__getDetails($familyDetails['tree'], $tmpArray[$searchedId]['bid'], $flag);
            $array = array_merge($array, $array4);
        } else {
            $type = true;
        }

//       else if ( in_array($userId, $tmpArray[$searchedId]['c'], true)) {
//      
//           if ($tmpArray[$searchedId]['g'] == 'm') {
//                $text = '<span style="font-size:12px;">--<b>Father of</b>--></span>';
//            } else {
//                $text = '<span style="font-size:12px;">--<b>Son of</b>--></span>';
//            }
//            $array[] = $text;
//            //if ( in_array())
//            $key = array_search($userId, $tmpArray[$searchedId]['c']);  
//            $array[] = $data[$tmpArray[$searchedId]['c'][$key]]['n'];
//            $familyDetails = $this->Tree->buildFamilyJson($userId);
//            $array3 = $this->__getDetails($familyDetails['tree'], $tmpArray[$searchedId]['c'][$key], false);
//            $array = array_merge($array, $array3);
//       }
       if ($tmpArray[$searchedId]['f'] != '' && $type == true) {
            if ($tmpArray[$searchedId]['g'] == 'f') {
                $text = '<span style="font-size:12px;">--<b>Daughter of</b>--></span>';
            } else {
                $text = '<span style="font-size:12px;">--<b>Son of</b>--></span>';
            }
            $array[] = $text;
            $array[] = $data[$tmpArray[$searchedId]['f']]['n'];
            $familyDetails = $this->Tree->buildFamilyJson($tmpArray[$searchedId]['f']);
            $flag = true;
            if ($familyDetails['tree'][$tmpArray[$searchedId]['f']]['bid'] != '') {
                $flag = false;
            }
            $array2 = $this->__getDetails($familyDetails['tree'], $tmpArray[$searchedId]['f'], $flag);
            $array = array_merge($array, $array2);
        } else  if ($data[$searchedId]['es'] != '' && $type == false) {
            $array[] = '<span style="font-size:12px;">--<b>Husband Of</b>--></span>';
            $array[] = $tmpArray[$searchedId]['partner_name'];
       
            $familyDetails = $this->Tree->buildFamilyJson($tmpArray[$searchedId]['es']);
            $flag = true;
            
            $array1 = $this->__getDetails($familyDetails['tree'], $tmpArray[$searchedId]['es'], $flag);
            $array = array_merge($array, $array1);
        } else {
            
          
            //$array3 = $this->__getDetails($data, $searchedId, false);
            //$array = array_merge($array, $array3);
        }
       
        return $array;
    }

}
