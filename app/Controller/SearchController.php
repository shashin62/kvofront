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
       
        foreach ($data as $d1 => $d3) {
            $this->peopleIds[] = $d3['id'];
            $this->peopleIds[] = $d3['partner_id'];
        }
        $peopleData = $data['People'];
        $groupData = $data['Group'];
        $addressData = $data['Address'];
        $userID = $this->Session->read('User.user_id');
        $this->set('peopleData', $peopleData);
        $this->set('groupData', $groupData);
        $this->set('addressData', $addressData);

        $data1 = $this->People->getFamilyDetails($this->Session->read('User.group_id'));

        foreach ($data1 as $d1 => $d2) {
            $this->peopleIds[] = $d2['People']['id'];
            $this->peopleIds[] = $d2['People']['partner_id'];
        }
        
        $this->peopleIds = array_unique($this->peopleIds);

        $familyDetails = $this->Tree->buildFamilyJson($peopleId);

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
        $array = array();
        //$tmpArray = array();
//        if ( $userId && $searchedId) {
//        foreach ( $data as $k => $v ) {
//            if ( in_array($searchedId,$v, true) ) {
//                
//                if ( $v['f'] == $userId || $v['m'] == $userId || $v['es'] == $userId  || in_array($userId, $v['c'], true)) {
//                    $tmpArray[$k] = $v;//$data[$searchedId];
//                }  else if ( $userId == $v['bid']) {
//                    
//                    $tmpArray[$k] = $v[$v['bid']];//$data[$searchedId];
//                }
//            }
//        }
//        } else {
//            $searchedId = $id;
//            $tmpArray = $data;
//        }
//        
        $tmpArray = $data;
        $isRecursive = false;

        if (is_array($tmpArray[$searchedId]['bid']) && $tmpArray[$searchedId]['g'] == 'm' && count(array_intersect($tmpArray[$searchedId]['bid'], $this->peopleIds)) && $isRecursive == false) {
            $common = array_values(array_intersect($tmpArray[$searchedId]['bid'], $this->peopleIds));

            $text = '<span style="font-size:12px;">--<b>Brother of</b>--></span>';
            $array[] = $text;
            $array[] = $data[$common[0]]['n'];
            if ( $data[$common[0]]['f'] != '') {
                $textLabel = 'Son Of';
                if ($data[$common[0]]['g'] == 'f') {
                    $textLabel = 'Daughter Of';
                }
                $text = '<span style="font-size:12px;">--<b>' . $textLabel . '</b>--></span>';
                $array[] = $text;
                $array[] = $data[$data[$common[0]]['f']]['n'];
                $isRecursive = true;
            }
        }

        if (is_array($tmpArray[$searchedId]['sid']) && $tmpArray[$searchedId]['g'] == 'f' && $isRecursive == false) {
            $common = array_values(array_intersect($tmpArray[$searchedId]['sid'], $this->peopleIds));

            if (count($common)) {

                $text = '<span style="font-size:12px;">--<b>Sister of</b>--></span>';
                $array[] = $text;
                $array[] = $data[$common[0]]['n'];

                if (is_array($data[$common[0]]['c']) &&
                        count(array_intersect($data[$common[0]]['c'], $this->peopleIds))
                ) {

                    $child = array_values(array_intersect($data[$common[0]]['c'], $this->peopleIds));
                    //echo '<pre>';

                    $array[] = '<span style="font-size:12px;">--<b>Mother of</b>--></span>';
                    $array[] = $data[$child[0]]['n'];
                }
                 if ($data[$child[0]]['ai'] == $this->Session->read('User.user_id')) {
                 $isRecursive = true;
             }
            }
        }
        if (is_array($tmpArray[$searchedId]['sid']) && $tmpArray[$searchedId]['g'] == 'm' && $isRecursive == false) {
            $common = array_values(array_intersect($tmpArray[$searchedId]['sid'], $this->peopleIds));
            
            if (count($common)) {
                $text = '<span style="font-size:12px;">--<b>Brother of</b>--></span>';
                $array[] = $text;
                $array[] = $data[$common[0]]['n'];

                if (is_array($data[$common[0]]['c']) &&
                        count(array_intersect($data[$common[0]]['c'], $this->peopleIds))
                ) {
                    $child = array_intersect($data[$common[0]]['c'], $this->peopleIds);
                    $array[] = '<span style="font-size:12px;">--<b>Mother of</b>--></span>';
                    $array[] = $data[$child[0]]['n'];
                }
            }
            if ($data[$child[0]]['ai'] == $this->Session->read('User.user_id')) {
                 $isRecursive = true;
             }
        }
//echo '<pre>';
//print_r($tmpArray);
//print_r($this->peopleIds);
//echo $this->Session->read('User.user_id');
//exit;
    
        if ($tmpArray[$searchedId]['es'] != '' && $isRecursive == false) {

            $text = '<span style="font-size:12px;">--<b>Wife of</b>--></span>';
            $array[] = $text;
            $array[] = $data[$tmpArray[$searchedId]['es']]['n'];
             if ( $tmpArray[$searchedId]['es'] == $this->Session->read('User.user_id')) {
                 $isRecursive = true;
             } else {
//                $array1=  $this->__getDetails($data, $id, false,$this->Session->read('User.user_id'), $tmpArray[$searchedId]['es']);
//                array_merge($array,$array1);
                if (in_array($this->Session->read('User.user_id'), $data[$tmpArray[$searchedId]['es']]['bid'])) {
                     $key = array_search($this->Session->read('User.user_id'), $data[$tmpArray[$searchedId]['es']]['bid']);
                     
                    $familyDetails = $this->Tree->buildFamilyJson($data[$tmpArray[$searchedId]['es']]['bid'][$key]);
                    
                   
                    $text = '<span style="font-size:12px;">--<b>Brother of</b>--></span>';
                    $array[] = $text;                  
                    $array[] = $familyDetails['tree'][$data[$tmpArray[$searchedId]['es']]['bid'][$key]]['n'];
                    
                    if ( $data[$tmpArray[$searchedId]['es']]['bid'][$key] == $this->Session->read('User.user_id')) {
                        $isRecursive = true;
                    }
                }
            }
        } 
        
        if (is_array($tmpArray[$searchedId]) && count(array_intersect($tmpArray[$searchedId]['c'], $this->peopleIds)) && $isRecursive == false) {

            $common = array_values(array_intersect($tmpArray[$searchedId]['c'], $this->peopleIds));
            if ($tmpArray[$searchedId]['g'] == 'f') {
                $text = '<span style="font-size:12px;">--<b>Mother of</b>--></span>';
            } else {
                $text = '<span style="font-size:12px;">--<b>Father of</b>--></span>';
            }
             

            $array[] = $text;
            $array[] = $data[$common[0]]['n'];
            
             if ( in_array($this->Session->read('User.user_id'), $data[$common[0]]['c'])) {
                    
                  $key = (array_search($this->Session->read('User.user_id'), $data[$common[0]]['c']));
                  $label = 'Mother of';
                  if (  $data[$common[0]]['g'] == 'm') {
                      $label = 'Father of';
                  }
                   $array[] = '<span style="font-size:12px;">--<b>' . $label . ' </b>--></span>';
                   
                   $d = $data[$common[0]]['c'];
                   
                   
                   $array[] = $data[$d[$key]]['n'];
                }
            
            if ( $data[$common[0]]['ai'] == $this->Session->read('User.user_id')) {
                 $isRecursive = true;
             }
            if (in_array($this->Session->read('User.user_id'), $data[$common[0]['c']])) {
                $key = array_search($this->Session->read('User.user_id'), $tmpArray[$searchedId]['c']);
            }
        } else if ($tmpArray[$searchedId]['f'] != '' && in_array($tmpArray[$searchedId]['f'], $this->peopleIds) && $isRecursive == false) {

            if ($tmpArray[$searchedId]['f'] != $this->Session->read('User.user_id')) {

                
                $common = array_values(array_intersect($tmpArray[$searchedId]['f'], $this->peopleIds));
                $textLabel = 'Son Of';
                if ($tmpArray[$searchedId]['g'] == 'f') {
                    $textLabel = 'Daughter Of';
                }
                $text = '<span style="font-size:12px;">--<b>' . $textLabel . '</b>--></span>';
                $array[] = $text;
                $array[] = $data[$tmpArray[$searchedId]['f']]['n'];
                // echo '<pre>';
                // print_r($data[$tmpArray[$searchedId]['f']]);
                // echo '</pre>';
                if (is_array($data[$tmpArray[$searchedId]['f']]['bid']) && $data[$tmpArray[$searchedId]['f']]['g'] == 'm' && count(array_intersect($data[$tmpArray[$searchedId]['f']]['bid'], $this->peopleIds))) {

                    $brother = array_values(array_intersect($data[$tmpArray[$searchedId]['f']]['bid'], $this->peopleIds));

                    $text = '<span style="font-size:12px;">--<b>Brother of</b>--></span>';
                    $array[] = $text;
                    $array[] = $data[$brother[0]]['n'];
                }
            }
        } else if ( $tmpArray[$searchedId]['f'] != '' && $isRecursive == false) {
                $textLabel = 'Son Of';
                if ($data[$common[0]]['g'] == 'f') {
                    $textLabel = 'Daughter Of';
                }
               $text = '<span style="font-size:12px;">--<b>' . $textLabel . '</b>--></span>';
                $array[] = $text;
                $array[] = $data[$tmpArray[$searchedId]['f']]['n'];
                if ( in_array($this->Session->read('User.user_id'), $data[$tmpArray[$searchedId]['f']]['bid'])) {
                    
                  $key = (array_search($this->Session->read('User.user_id'), $data[$tmpArray[$searchedId]['f']]['bid']));
                   $array[] = '<span style="font-size:12px;">--<b> Brother of </b>--></span>';
                   
                   $d = $data[$tmpArray[$searchedId]['f']]['bid'];
                   
                   
                   $array[] = $data[$d[$key]]['n'];
                }
                $isRecursive = true;
                
            }
//        
//        if ($tmpArray[$searchedId]['es'] != '' && $tmpArray[$searchedId]['es'] == $this->Session->read('User.user_id')) {
//           
//           $text = '<span style="font-size:12px;">--<b>Wife of</b>--></span>';
//            $array[] = $text;
//            $array[] = $data[$tmpArray[$searchedId]['es']]['n'];
//       }
//        else if ( is_array($tmpArray[$searchedId]['c']) 
//                && in_array( $this->Session->read('User.user_id'), $tmpArray[$searchedId]['c'])) {
//            $key = array_search($this->Session->read('User.user_id'), $tmpArray[$searchedId]['c']);
//            $textLabel = 'Father Of';
//            if (  $tmpArray[$searchedId]['g'] == 'f') {
//                $textLabel = 'Mother Of';
//            }
//           $text = '<span style="font-size:12px;">--<b>' . $textLabel . '</b>--></span>';
//            $array[] = $text;
//            $array[] = $data[$tmpArray[$searchedId]['c'][$key]]['n'];
//       }
//       
//        else if ($tmpArray[$searchedId]['bid'] != '' && $type == false && $tmpArray[$searchedId]['g'] == 'm') {
//            $text = '<span style="font-size:12px;">--<b>Brother of</b>--></span>';
//            $array[] = $text;
//            $array[] = $data[$tmpArray[$searchedId]['bid']]['n'];
//            if ($tmpArray[$searchedId]['bid'] != $this->Session->read('User.user_id')) {
//                $familyDetails = $this->Tree->buildFamilyJson($tmpArray[$searchedId]['bid']);
//                $flag = true;
//
//                $array4 = $this->__getDetails($familyDetails['tree'], $tmpArray[$searchedId]['bid'], $flag);
//                $array = array_merge($array, $array4);
//            }
//        } else {
//            $type = true;
//        }
//        
//       
//
//       if ( in_array($userId, $tmpArray[$searchedId]['c'], true)) {
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
//       if ($tmpArray[$searchedId]['f'] != '' && $type == true) {
//            if ($tmpArray[$searchedId]['g'] == 'f') {
//                $text = '<span style="font-size:12px;">--<b>Daughter of</b>--></span>';
//            } else {
//                $text = '<span style="font-size:12px;">--<b>Son of</b>--></span>';
//            }
//            $array[] = $text;
//            $array[] = $data[$tmpArray[$searchedId]['f']]['n'] . '- ' . $tmpArray[$searchedId]['f'] ;
//            
//            if ( $tmpArray[$searchedId]['f'] != $this->Session->read('User.user_id')) {
//                 $familyDetails = $this->Tree->buildFamilyJson($tmpArray[$searchedId]['f']);
//            $flag = true;
//            if ($familyDetails['tree'][$tmpArray[$searchedId]['f']]['bid'] != '') {
//                $flag = false;
//            }
//            $array2 = $this->__getDetails($familyDetails['tree'], $tmpArray[$searchedId]['f'], $flag);
//            $array = array_merge($array, $array2);
//            }
//           
//        }
        return $array;
    }

}
