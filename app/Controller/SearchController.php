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
    public $uses = array('User', 'People', 'Group', 'PeopleGroup','Sister','Brother');

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
        
        $treeData =$this->Tree->buildTreeJson($groupData['group_id']);
//        echo '<pre>';
//        print_r($treeData);
//        echo '</pre>';

        $dataTree = $this->_buildLinkage($treeData['tree'], $this->request->data['id'], $userID);
        
        
//        $data1 = $this->People->getFamilyDetails($this->Session->read('User.group_id'));
//
//        foreach ($data1 as $d1 => $d2) {
//            $this->peopleIds[] = $d2['People']['id'];
//            $this->peopleIds[] = $d2['People']['partner_id'];
//        }
//        
//        $this->peopleIds = array_unique($this->peopleIds);
//
//        $familyDetails = $this->Tree->buildFamilyJson($peopleId);
//
        $searchedName[] = $peopleData['first_name'] . ' ' . $peopleData['last_name'];
//
//        $treeData = $this->__getDetails($familyDetails['tree'], $peopleId, false, $userID, $this->request->data['id']);
        $tree = array_merge($searchedName, $dataTree);

        $this->set('treeLinkageData', $tree);
    }
    
    
    
    private function _buildLinkage($data, $searchedId, $userId) 
    {
//        echo $searchedId;
//        
//        echo $userId;
//        
//        echo '<pre>';
//       // print_r($data[$searchedId]);
//       // print_r($this->peopleIds);
//        echo '</pre>';
//        
        
        
        if ( in_array($userId, $data[$searchedId]['c'])) {
            $childId = array_search($userId, $data[$searchedId]['c']);
            if ($data[$searchedId]['g'] == 'f') {
                $text = '<span style="font-size:12px;">--<b>Mother of</b>--></span>';
            } else {
                $text = '<span style="font-size:12px;">--<b>Father of</b>--></span>';
            }
             $array[] = $text;
            $array[] = $data[$data[$searchedId]['c'][$childId]]['n'];
            
        } else if (in_array($userId, $data[$searchedId]['bid'])) {
            $brotherId = array_search($userId, $data[$searchedId]['bid']);
            
            if ($data[$searchedId]['g'] == 'f') {
                $text = '<span style="font-size:12px;">--<b>Sister of</b>--></span>';
            } else {
                $text = '<span style="font-size:12px;">--<b>Brother of</b>--></span>';
            }
            $array[] = $text;
           
            $array[] = $data[$data[$searchedId]['bid'][$brotherId]]['n'];
            
            
            
            
        } else if (in_array($userId, $data[$searchedId]['sid'])) {
            exit;
        } else if(count(array_intersect($data[$searchedId]['sid'], $this->peopleIds)))
        {
            $common = array_values(array_intersect($data[$searchedId]['sid'], $this->peopleIds));
             $textLabel = 'Sister';
            if ($data[$searchedId]['g'] == 'm') {
                $textLabel = 'Brother of';
            }
            $text = '<span style="font-size:12px;">--<b>' . $textLabel . ' </b>--></span>';
            $array[] = $text;
            $array[] = $data[$common[0]]['n'];
             if( $common[0] != $this->Session->read('User.user_id')) {
            $array1 = $this->_buildLinkage($data, $common[0], $this->Session->read('User.user_id')) ;
            $array = array_merge($array,$array1);
             }
        }
        else if (in_array($data[$searchedId]['es'], $this->peopleIds))
        {
            if ($data[$searchedId]['g'] == 'f') {
                $text = '<span style="font-size:12px;">--<b>Wife of</b>--></span>';
            } else {
                $text = '<span style="font-size:12px;">--<b>Husband of</b>--></span>';
            }
             $array[] = $text;
            $array[] = $data[$data[$searchedId]['es']]['n'];
            if( $data[$searchedId]['es'] != $this->Session->read('User.user_id')) {
                $array1 = $this->_buildLinkage($data, $data[$searchedId]['es'], $this->Session->read('User.user_id')) ;
             $array = array_merge($array,$array1);
            }            
        }
        
        else if ( $userId  == $data[$searchedId]['f']) {
           
             if ($data[$searchedId]['g'] == 'f') {
                $text = '<span style="font-size:12px;">--<b>Daughter of</b>--></span>';
            } else {
                $text = '<span style="font-size:12px;">--<b>Son of</b>--></span>';
            }
             $array[] = $text;
            $array[] = $data[$data[$searchedId]['f']]['n'];
        } else if ( $userId  == $data[$searchedId]['m']) {
            
        } 
        
        else if(count(array_intersect($data[$searchedId]['c'], $this->peopleIds)))
        {
            $common = array_values(array_intersect($data[$searchedId]['c'], $this->peopleIds));
             $textLabel = 'Mother of';
            if ($data[$searchedId]['g'] == 'm') {
                $textLabel = 'Father of';
            }
            $text = '<span style="font-size:12px;">--<b>' . $textLabel . ' </b>--></span>';
            $array[] = $text;
            $array[] = $data[$common[0]]['n'];
             if( $common[0] != $this->Session->read('User.user_id')) {
                $array1 = $this->_buildLinkage($data, $common[0], $this->Session->read('User.user_id')) ;
                $array = array_merge($array,$array1);
             }
        }
//        else if(is_array($data[$searchedId]['sid']))
//        {
//            $textLabel = 'Sister of';
//            if ( $data[$searchedId]['g'] == 'm') {
//                 $textLabel = 'Brother of';
//            }
//            $text = '<span style="font-size:12px;">--<b>' . $textLabel . ' </b>--></span>';
//            $array[] = $text;
//            $array[] = $data[$data[$searchedId]['sid'][0]]['n'];
//             if( $common[0] != $this->Session->read('User.user_id')) {
//                $array1 = $this->_buildLinkage($data, $data[$searchedId]['sid'][0], $this->Session->read('User.user_id')) ;
//                $array = array_merge($array,$array1);
//             }
//        }
        
        else if( $data[$searchedId]['f'] != '') 
        {
            if ($data[$searchedId]['g'] == 'f') {
                $text = '<span style="font-size:12px;">--<b>Daughter of</b>--></span>';
            } else {
                $text = '<span style="font-size:12px;">--<b>Son of</b>--></span>';
            }
             $array[] = $text;
            $array[] = $data[$data[$searchedId]['f']]['n'];
            
        }
            
        
        
        
        return $array;
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
//        echo '<pre>';
//print_r($data);
//
////print_r($this->peopleIds);
//echo '</pre>';
//echo $this->Session->read('User.user_id');
//exit;
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

        if (is_array($tmpArray[$searchedId]['bid']) && $tmpArray[$searchedId]['g'] == 'm' && count(array_intersect($tmpArray[$searchedId]['bid'], $this->peopleIds)) && $isRecursive == false
                
                ) {
            if ( !in_array($this->Session->read('User.user_id'), $tmpArray[$searchedId]['c'] )) {
                
          
            
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
        }

        if (is_array($tmpArray[$searchedId]['sid']) && $tmpArray[$searchedId]['g'] == 'f' && $isRecursive == false) {
//            echo '<pre>';
//           print_r($tmpArray[$searchedId]);
            $common = array_values(array_intersect($tmpArray[$searchedId]['sid'], $this->peopleIds));

            if (count($common)) {
                $textLabel = 'Sister';
                if ( $tmpArray[$searchedId]['g'] == 'm') {
                    $textLabel = 'Brother of';
                }
                $text = '<span style="font-size:12px;">--<b>' . $textLabel . ' </b>--></span>';
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
             if ( !in_array($this->Session->read('User.user_id'), $tmpArray[$searchedId]['c'] )) {
                 
             
            $common = array_values(array_intersect($tmpArray[$searchedId]['sid'], $this->peopleIds));
            $array = array();
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
                } else if ($tmpArray[$common[0]]['es'] != '' && !count(array_intersect($tmpArray[$common[0]]['es'], $this->peopleIds))) {
                    $wifeRelationship = $this->__wifeOfRelationship($tmpArray, $tmpArray, $common[0]);
                    
                    
                  $array = array_merge($array,$wifeRelationship);
                    $isRecursive = true;
                }
            }
            if ($data[$child[0]]['ai'] == $this->Session->read('User.user_id')) {
                 $isRecursive = true;
             }
             }
        }
          if (is_array($tmpArray[$searchedId]['bid']) && $tmpArray[$searchedId]['g'] == 'f' && $isRecursive == false
                
                ) {
                $array = array();
               $key = array_values($tmpArray[$searchedId]['bid']);
                     
              if ( $tmpArray[$searchedId]['g'] == 'f') {
                $text = '<span style="font-size:12px;">--<b>Sister of</b>--></span>';
            } else {
                $text = '<span style="font-size:12px;">--<b>Brother of</b>--></span>';
            }
            $array[] = $text;
            $array[] = $data[$key[0]]['n'];
            
             $familyDetails = $this->Tree->buildFamilyJson($key[0]);
              $textLabel = 'Son Of';
                if ($data[$key[0]]['g'] == 'f') {
                    $textLabel = 'Daughter Of';
                }
                $text = '<span style="font-size:12px;">--<b>' . $textLabel . '</b>--></span>';
                $array[] = $text;
                $array[] = $data[$data[$key[0]]['f']]['n'];
                $isRecursive = true;
          }
        
//echo '<pre>';
//print_r($tmpArray);
//print_r($this->peopleIds);
//echo $this->Session->read('User.user_id');
//exit;
    
        if ($tmpArray[$searchedId]['es'] != '' && !count(array_intersect($tmpArray[$searchedId]['es'], $this->peopleIds)) && $isRecursive == false) {
            $array = array();
            if ( in_array($this->Session->read('User.user_id'), $tmpArray[$searchedId]['c'])) {
             $common = array_values(array_intersect($tmpArray[$searchedId]['c'], $this->peopleIds));
            if ($tmpArray[$searchedId]['g'] == 'f') {
                $text = '<span style="font-size:12px;">--<b>Mother of</b>--></span>';
            } else {
                $text = '<span style="font-size:12px;">--<b>Father of</b>--></span>';
            }
             $array[] = $text;
            $array[] = $data[$common[0]]['n'];
            
                 $isRecursive = true;
            
            } else {

           
            if ( $tmpArray[$searchedId]['g'] == 'f') {
                $text = '<span style="font-size:12px;">--<b>Wife of</b>--></span>';
            } else {
                $text = '<span style="font-size:12px;">--<b>Husband of</b>--></span>';
            }
            $array[] = $text;
            $array[] = $data[$tmpArray[$searchedId]['es']]['n'];
            
             $familyDetails = $this->Tree->buildFamilyJson($tmpArray[$searchedId]['es']);
             
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
        } 
        
        if (is_array($tmpArray[$searchedId]) && count(array_intersect($tmpArray[$searchedId]['c'], $this->peopleIds)) && $isRecursive == false) {
$array = array();
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
            $array = array();
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
            $array = array();
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

        return $array;
    }
    
    
    private function __wifeOfRelationship($data, $tmpArray, $searchedId)
    {
          
            if ( $tmpArray[$searchedId]['g'] == 'f') {
                $text = '<span style="font-size:12px;">--<b>Wife of</b>--></span>';
            } else {
                $text = '<span style="font-size:12px;">--<b>Husband of</b>--></span>';
            }
            $array[] = $text;
            $array[] = $data[$tmpArray[$searchedId]['es']]['n'];
            
             $familyDetails = $this->Tree->buildFamilyJson($tmpArray[$searchedId]['es']);
             
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
            
            return $array;
    }

}
