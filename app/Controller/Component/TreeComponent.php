<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::load('model','People');
class TreeComponent extends Component{
    
    /**
     * 
     * @param type $group_id
     * @return string    
     */
    public function buildTreeJson($group_id = false) {

        $this->autoRender = false;
        $this->layout = null;
        $groupId =  $group_id;
        
        $peopleModel = ClassRegistry::init('People');
         $peopleGroupModel = ClassRegistry::init('PeopleGroup');
            $data = $peopleModel->getFamilyDetails($groupId);
            //check each id exists in other group then get all gamily detials for this group also
            foreach ($data as $key => $value) {
                $groupData[] = $peopleGroupModel->checkExistsInOtherGroup($groupId, $value['People']['id']);
            }

            foreach ($groupData as $k => $v) {
                if (count($v)) {
                    foreach ($v as $k1 => $v1) {
                        $data1 = $peopleModel->getFamilyDetails($v1['PeopleGroup']['group_id'], false, false, true);
                        $data = array_merge($data, $data1);
                    }
                }
            }

            $parentName = $data[0]['People']['first_name'] . ' ' . $data[0]['People']['last_name'];
            $treelevel = 0;
            $tree = array();
            $ids = array();

            $data = array_map("unserialize", array_unique(array_map("serialize", $data)));

            foreach ($data as $key => $value) {
                $peopleData = $value['People'];
                $peopleGroup = $value['Group'];
                $addressData = $value['Address'];
                $exSpouses = $value[0];
                if (!in_array($peopleData['id'], $ids)) {


                    $children = $peopleModel->getChildren($peopleData['id'], $peopleData['gender'], $groupId);
                    $childids = array();
                    foreach ($children as $k => $v) {
                        $childids[] = $v['People']['id'];
                    }
                    $originalPId = $peopleData['id'];
                    $ids[] = $peopleData['id'];
                    if ($peopleGroup['tree_level'] == "" && $treelevel == 0) {
                        $rootId = $peopleGroup['people_id'];
                        //$peopleData['id'] = 'START';
                        $treelevel = 1;
                    }

                    if ($peopleGroup['tree_level'] != '') {
                        if ($peopleGroup['tree_level'] == $rootId) {
                            $tree[$peopleData['id']]['^'] = 'START';
                        } else {
                            $tree[$peopleData['id']]['^'] = $peopleGroup['tree_level'];
                        }
                    }

                    $tree[$peopleData['id']]['n'] = $peopleData['first_name'] . ' ' . $peopleData['last_name'];
                    $tree[$peopleData['id']]['ai'] = $peopleData['id'];

                    if (count($children)) {
                        if ($peopleGroup['tree_level'] == $rootId) {
                            
                        }
                        $tree[$peopleData['id']]['c'] = array_unique($childids);
                        $tree[$peopleData['id']]['cp'] = true;
                    } else {
                        $tree[$peopleData['id']]['c'] = array();
                        $tree[$peopleData['id']]['cp'] = false;
                    }

                    $tree[$peopleData['id']]['e'] = $peopleData['email'];
                    $tree[$peopleData['id']]['u'] = $peopleData['mobile_number'];
                   
                        $tree[$peopleData['id']]['f'] = $peopleData['f_id'];
                    

                    $tree[$peopleData['id']]['m'] = $peopleData['m_id'];
                    $peopleId = $peopleGroup['people_id'];

                    if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/people_images/' . $peopleId . '.' . $peopleData['ext']) === true) {
                        $tree[$peopleData['id']]['r'] = $peopleId . '.' . $peopleData['ext'];
                    } else {
                        $tree[$peopleData['id']]['r'] = '';
                    }
                    $tree[$peopleData['id']]['fg'] = true;
                    $tree[$peopleData['id']]['g'] = $peopleData['gender'] == 'male' ? 'm' : 'f';
                    $tree[$peopleData['id']]['hp'] = true;
                    $tree[$peopleData['id']]['i'] = $peopleData['id'];
                    $tree[$peopleData['id']]['l'] = $peopleData['last_name'] . ' (' . $peopleId . ')';
                    $tree[$peopleData['id']]['p'] = ucfirst($peopleData['first_name']);
                    $tree[$peopleData['id']]['dob'] = date("m/d/Y", strtotime($peopleData['date_of_birth']));
                    $tree[$peopleData['id']]['education'] = $peopleData['education_1'];
                    $tree[$peopleData['id']]['village'] = ucfirst($peopleData['village']);
                    $tree[$peopleData['id']]['father'] = ucfirst($peopleData['father']);
                    $tree[$peopleData['id']]['mother'] = ucfirst($peopleData['mother']);
                    if ($peopleData['gender'] == 'male') {
                        $tree[$peopleData['id']]['partner_name'] = ucfirst($peopleData['partner_name']) . " " . ucfirst($peopleData['first_name']) . " " . $peopleData['last_name'];
                    } else {
                        $tree[$peopleData['id']]['partner_name'] = ucfirst($peopleData['partner_name']) . " " . $peopleData['last_name'];
                    }
                    $tree[$peopleData['id']]['specialty_business_service'] = $peopleData['specialty_business_service'];
                    $tree[$peopleData['id']]['nature_of_business'] = $peopleData['nature_of_business'];
                    $tree[$peopleData['id']]['business_type'] = $peopleData['business_name'];
                    $tree[$peopleData['id']]['name_of_business'] = $peopleData['name_of_business'];
                    $tree[$peopleData['id']]['mobile_number'] = $peopleData['mobile_number'];
                    $tree[$peopleData['id']]['martial_status'] = $peopleData['martial_status'];
                    $tree[$peopleData['id']]['date_of_marriage'] = date("m/d/Y", strtotime($peopleData['date_of_marriage']));
                    $tree[$peopleData['id']]['email'] = $peopleData['email'];
                    $tree[$peopleData['id']]['pid'] = $originalPId;
                    $tree[$peopleData['id']]['gid'] = $peopleData['group_id'];
                    $tree[$peopleData['id']]['father'] = ucfirst($peopleData['father']);
                    $tree[$peopleData['id']]['city'] = ucfirst($addressData['city']);

                    $tree[$peopleData['id']]['suburb'] = $addressData['suburb'];
                    $tree[$peopleData['id']]['suburb_zone'] = ucfirst($addressData['suburb_zone']);

                    if ($peopleData['partner_id'] == $rootId) {

                        if ($peopleData['partner_id'] != '') {
                            $tree[$peopleData['id']]['pc'] = array(
                                'START' => true
                            );
                           // $tree[$peopleData['id']]['es'] = 'START';
                           // $tree[$peopleData['id']]['s'] = 'START';
                        }
                    } else if ($peopleData['partner_id'] != '') {
                        $tree[$peopleData['id']]['pc'] = array(
                            $peopleData['partner_id'] => true
                        );
                        $tree[$peopleData['id']]['es'] = $peopleData['partner_id'];
                        $tree[$peopleData['id']]['s'] = $peopleData['partner_id'];
                    } else {
                        $tree[$peopleData['id']]['pc'] = array();
                        $tree[$peopleData['id']]['es'] = null;
                    }
                    if ($exSpouses['exspouses'] != '') {
                        foreach (explode(',', $exSpouses['exspouses']) as $eKey => $eValue) {
                            $tree[$peopleData['id']]['ep'][$eValue] = "1";
                            $tree[$peopleData['id']]['pc'][$eValue] = true;
                        }
                    }
                    $tree[$peopleData['id']]['q'] = $peopleData['maiden_surname'];
                }
            }
//            echo '<pre>';
//            print_r($tree);
//            exit;
            $jsonData['tree'] = $tree;
            $jsonData['parent_name'] = $parentName;
            if ($group_id) {
                return $jsonData;
            } else {
                echo json_encode($jsonData);
                exit;
            }
       
        }
        
        public function buildFamilyJson ($peopleId = false) {
             $peopleModel = ClassRegistry::init('People');
        if ( isset($_REQUEST['id'])) {
            $id = $_REQUEST['id'];        
            $id = (int) str_replace('?', '',$id);
        } else if( $peopleId ) {
            $id = $peopleId;
        }
       
        $tree = array();
        $ids = array();
        
        $data = $peopleModel->getPeopleDetail ($id);
       
        $allIds = array();
        $childrens = array();
        $rootId = $id;
//        echo '<pre>';
//        print_r($data);
//        echo '</pre>';
        foreach ($data as $key => $value) {
            if (!in_array($value['people']['id'], $allIds)) {
                $allIds[] = $value['people']['id'];
                
                if ($value['people']['f_id']) {
                    $childrens[$value['people']['f_id']][] = $value['people']['id'];
                }
                if ($value['people']['m_id']) {
                    $childrens[$value['people']['m_id']][] = $value['people']['id'];
                }
            }
            
            if ($value['people']['id'] == $rootId) {
                $peopleRootData = $value['people'];
                $addressData = $value['ad'];
                $peopleRootGroup = $value['people_groups'];
                $exSpousesRoot = array_unique($value[0]);
                $brothers =  array_unique($value['brothers']);
                 $sisters =  array_unique($value['sisters']);
                $ids[] = $value['people']['id'];
            }
        }
        
      
        $tree[$peopleId] = $this->formatTree($peopleRootData, $peopleRootGroup, $exSpousesRoot, $rootId, $childrens, $allIds, $addressData, $brothers, $sisters);      

        foreach ($data as $key => $value) {
            $peopleData = $value['people'];
            $peopleGroup = $value['people_groups'];
            $addressData = $value['ad'];
            $exSpouses = array_unique($value[0]);
            $brothers =  array_unique($value['brothers']);
            $sisters =  array_unique($value['sisters']);

            if (!in_array($peopleData['id'], $ids) ) {
                $ids[] = $peopleData['id'];
                $tree[$peopleData['id']] = $this->formatTree($peopleData, $peopleGroup, $exSpouses, $rootId, $childrens, $allIds, $addressData, $brothers, $sisters);
            }
        }

        $jsonData['tree'] = $tree;
        $jsonData['parent_name'] = $peopleRootData['first_name'] . ' ' . $peopleRootData['last_name'];
        
        return $jsonData;
    }
    
    public function formatTree($peopleData, $peopleGroup, $exSpouses, $rootId, $childrens, $allIds, $addressData, $brothers, $sisters) {
      
        $tree = array();
        $iId = $peopleData['id'];
        if ($peopleGroup['tree_level'] != '' && $peopleGroup['people_id'] != $rootId) {
            if ($peopleGroup['tree_level'] == $rootId) {
                $tree['^'] = 'START';
            } else {
                $tree['^'] = $peopleGroup['tree_level'];
            }
        }

        $tree['n'] = $peopleData['first_name'] . ' ' . $peopleData['last_name'];
        $tree['ai'] = $peopleData['id'];

        if (count($childrens[$iId])) {
            $tree['c'] = array_unique($childrens[$iId]);
            $tree['cp'] = true;
        } else {
            $tree['c'] = array();
            $tree['cp'] = false;
        }

        $tree['e'] = $peopleData['email'];
        $tree['u'] = $peopleData['mobile_number'];

       
            $fid = $peopleData['f_id'];
            $tree['f'] = (!in_array($fid, $allIds)) ? null : $fid;
       
        
      
            $mid = ($peopleData['m_id']) ? $peopleData['m_id'] : null;
            $tree['m'] = (!in_array($mid, $allIds)) ? null : $mid;
      

        $peopleId = $peopleData['id'];
        
        if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/people_images/' . $peopleId . '.' . $peopleData['ext']) === true) {
            $tree['r'] = $peopleData['id'];
        } else {
            $tree['r'] = '';
        }
        $tree['fg'] = true;
        $tree['g'] = $peopleData['gender'] == 'male' ? 'm' : 'f';
        $tree['hp'] = true;
        $tree['i'] = $peopleData['id'];
        $tree['l'] = $peopleData['last_name'];
        $tree['p'] = $peopleData['first_name'];
        $tree['bid'] = $brothers;
        $tree['sid'] = $sisters;
        $tree['dob'] = $peopleData['date_of_birth'] != '' ? date("m/d/Y", strtotime($peopleData['date_of_birth'])) : '';
        $tree['education'] = $peopleData['education_1'];
        $tree['village'] = ucfirst($peopleData['village']);
        $tree['father'] = ucfirst($peopleData['father']);
        $tree['mother'] = ucfirst($peopleData['mother']);
        if ( $peopleData['gender'] == 'male') {
            $tree['partner_name'] = ucfirst($peopleData['partner_name']) . " " . ucfirst($peopleData['first_name']) . " " . $peopleData['last_name'] ;
        } else {
            $tree['partner_name'] = ucfirst($peopleData['partner_name']) . " " . $peopleData['last_name'] ;
        }
        $tree['specialty_business_service'] = $peopleData['specialty_business_service'];
        $tree['nature_of_business'] = $peopleData['nature_of_business'];
        $tree['business_type'] = $peopleData['business_name'];
        $tree['name_of_business'] = $peopleData['name_of_business'];
        $tree['mobile_number'] = $peopleData['mobile_number'];
        $tree['martial_status'] = $peopleData['martial_status'];
        $tree['date_of_marriage'] = $peopleData['date_of_marriage'] != ''?  date("m/d/Y", strtotime($peopleData['date_of_marriage'])) : '';
        $tree['email'] = $peopleData['email'];
        $tree['pid'] = $originalPId;
        $tree['gid'] = $peopleData['group_id'];
        $tree['father'] = ucfirst($peopleData['father']);
        $tree['city'] = ucfirst($addressData['city']);

        $tree['suburb'] = $addressData['suburb'];
        $tree['suburb_zone'] = ucfirst($addressData['suburb_zone']);

        $tree['k'] = null;

        if ($peopleData['partner_id'] != '') {
            $tree['pc'] = array(
                $peopleData['partner_id'] => true
            );
            $tree['es'] = $peopleData['partner_id'];
            $tree['s'] = $peopleData['partner_id'];
        } else {
            $tree['pc'] = array();
            $tree['es'] = null;
        }
        if ($exSpouses['exspouses'] != '') {
            foreach (explode(',', $exSpouses['exspouses']) as $eKey => $eValue) {
                $tree['ep'][$eValue] = "1";
                $tree['pc'][$eValue] = true;
            }
        }
        $tree['q'] = $peopleData['maiden_surname'];
        
        return $tree;
    }

    
}
