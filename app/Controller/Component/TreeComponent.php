<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::load('model','People');
class TreeComponent extends Component{
    
    
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
    
}
