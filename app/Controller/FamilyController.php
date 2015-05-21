<?php

/**
 * Controller file
 *
 * PHP version 5.5
 *
 * @category  Controller
 * @package   KVO Admin
 * @author    S
 * @copyright 2014 KVO Admin
 * @version   GIT:$
 * @since     1.0
 */
App::uses('AppController', 'Controller');

/**
 * Controller class for Family Controller
 * 
 * @category  Controiller
 * @package   KVO Admin
 * @author    S
 * @copyright 2014 KVO Admin
 * @since     1.0
 */
Class FamilyController extends AppController {

    /**
     *
     * @var type 
     */
    public $name = 'Family';

    /**
     *
     * @var array 
     */
    public $uses = array(
        'User', 'Aro', 'Role', 'Note',
        'People', 'Village', 'Education', 'State', 'BloodGroup',
        'Group', 'Address', 'PeopleGroup', 'Suburb', 'Surname', 'Translation',
        'ZipCode', 'Spouse', 'ZipCode','BusinessNature','BusinessType','Brother','Sister', 'PeopleEducation'
    );

    /**
     *
     * @var type 
     */
    public $helpers = array('Session');

    /**
     *
     * @var type 
     */
    public $components = array('Session');

    public function getAjaxSearch() {
        $this->autoRender = false;

        $type = $_REQUEST['type'];
        if( $_REQUEST['sSearch_1'] != '' && $_REQUEST['sSearch_2'] != '' ) {
            $_REQUEST['on'] = 'onsubmit';
        }
        $data = $this->People->getAllPeoples($_REQUEST);
        echo json_encode($data);
    }

    /**
     * index function - page landing
     */
    public function index() {
        if (!$this->Session->read('Auth.User')) {
            $this->Session->destroy();
            $this->Cookie->delete('Auth.User');

            $this->redirect('/user/login');
        }
        $requestData = $_REQUEST;
        $this->set('module', $requestData['module']);
        $this->set('first_name', isset($this->request->data['first_name']) ?
                        $this->request->data['first_name'] : '');
        $this->set('last_name', isset($this->request->data['last_name']) ?
                        $this->request->data['last_name'] : '');
        $this->set('date_of_birth', isset($this->request->data['date_of_birth']) ? $this->request->data['date_of_birth'] : '');
        $this->set('mobile_number', isset($this->request->data['mobile_number']) ?
                        $this->request->data['mobile_number'] : '');
        $this->set('village', isset($this->request->data['village']) ?
                        $this->request->data['village'] : '');

        if ($requestData['type'] == 'self') {
            $userId = $requestData['fid']; //$this->Session->read('User.user_id');
            $toFetchData = true;
            $peopleId = $requestData['fid'];
        } else {
            $userId = '';
            $toFetchData = false;
            $peopleId = $requestData['fid'];
        }

        $getPeopleData = $this->People->getPeopleData($peopleId, true, $_REQUEST['gid']);
        $array = array();
        $array['gid'] = $_REQUEST['gid'];
        $this->set('main_surname', $getPeopleData['People']['main_surname']);
        $getOwnerDetails = $this->People->getParentPeopleDetails($array);

        $this->set('name', $getOwnerDetails['first_name']);
        $this->set('address_id', $getOwnerDetails['address_id']);

        // add primary relationships to user- spouse, father, mother and childrens
        switch ($requestData['type']) {
            case 'addspouse':
                $pageTitle = 'Add Spouse of ' . $_REQUEST['name_parent'];
                // by default set gender, martial status
                //  as spouse is always female and married
                $this->set('gender', 'Female');
                $this->set('martial_status', 'Married');
                $this->set('sect', 'Deravasi');
                $this->set('parent_name', $_REQUEST['first_name']);
                $this->set('last_name', $getPeopleData['People']['last_name']);
                // set surname and village to read only mode
                $this->set('village', $getPeopleData['People']['village']);
                $this->set('readonly', true);
                $this->set('main_surname', $getPeopleData['People']['main_surname']);
                $this->set('sect', $getPeopleData['People']['sect']);
                $this->set('date_of_marriage', $getPeopleData['People']['date_of_marriage'] ? date("d/m/Y", strtotime($getPeopleData['People']['date_of_marriage'])) : '' );
                break;
            case 'addexspouse':
                $this->set('gender', 'Female');
                $this->set('martial_status', 'Married');
                $this->set('sect', 'Deravasi');
                $this->set('parent_name', $_REQUEST['first_name']);
                $this->set('last_name', $getPeopleData['People']['last_name']);
                // set surname and village to read only mode
                $this->set('village', $getPeopleData['People']['village']);
                $this->set('readonly', true);
                $this->set('main_surname', $getPeopleData['People']['main_surname']);
                $this->set('sect', $getPeopleData['People']['sect']);
                break;
            case 'addfather':
                $pageTitle = 'Add Father of ' . $_REQUEST['name_parent'];
                $this->set('gender', 'Male');
                $this->set('sect', 'Sthanakvasi');
                $this->set('martial_status', 'Married');
                if ($getPeopleData['People']['tree_level'] == '') {
                    $this->set('readonly', true);
                } else {
                    $this->set('readonly', false);
                }
                $this->set('village', $getPeopleData['People']['village']);
                $this->set('last_name', $getPeopleData['People']['last_name']);
                break;
            case 'addmother':
                $pageTitle = 'Add Mother of ' . $_REQUEST['name_parent'];
                $this->set('sect', 'Deravasi');
                $this->set('gender', 'Female');
                $this->set('martial_status', 'Married');
                if ($getPeopleData['People']['tree_level'] == '') {
                    $this->set('readonly', true);
                } else {
                    $this->set('readonly', false);
                }

                $this->set('last_name', $getPeopleData['People']['last_name']);
                $this->set('village', $getPeopleData['People']['village']);
                break;
            case 'addchilld':
                $pageTitle = 'Add Child of ' . $_REQUEST['name_parent'];
                $this->set('readonly', true);
                $this->set('last_name', $getPeopleData['People']['last_name']);
                $this->set('village', $getPeopleData['People']['village']);
                $mothers = $this->People->getAllSpouses($peopleId);
                $this->set('countm', count($mothers));
                //echo '<pre>';print_r($mothers);exit;

                $this->set(compact('mothers'));
                break;
            case 'addnew':
                $pageTitle = 'Add New Family';
//                $this->set('gender', 'male');
//                $this->set('sect','sthanakvasi');
//                $this->set('martial_status', 'Married');

                break;
            case 'addbrother':
                $pageTitle = 'Add Brother of ' . $_REQUEST['name_parent'];
                $this->set('gender', 'Male');
                $this->set('sect', 'Sthanakvasi');
                $this->set('martial_status', 'Single');
                if ($getPeopleData['People']['tree_level'] == '') {
                    $this->set('readonly', true);
                } else {
                    $this->set('readonly', false);
                }
                $this->set('village', $getPeopleData['People']['village']);
                $this->set('last_name', $getPeopleData['People']['last_name']);
                break;
            case 'addsister':
                $pageTitle = 'Add Sister of ' . $_REQUEST['name_parent'];
                $this->set('gender', 'Female');
                $this->set('sect', 'Deravasi');
                $this->set('martial_status', 'Single');
                if ($getPeopleData['People']['tree_level'] == '') {
                    $this->set('readonly', true);
                } else {
                    $this->set('readonly', false);
                }
                $this->set('village', $getPeopleData['People']['village']);
                $this->set('last_name', $getPeopleData['People']['last_name']);
                break;
            default:
                $requestData['type'] = 'self';
                $pageTitle = 'Create your family - edit your Details';
                break;
        }

        $this->set('gid', $_REQUEST['gid']);
        $this->set('pid', $peopleId);
        $this->set('pageTitle', $pageTitle);
        $this->set('userType', $requestData['type']);

        $villages = $this->Village->find('list', array('fields' => array('Village.name', 'Village.name')));
        $this->set(compact('villages'));

        $educations = $this->Education->find('list', array('fields' => array('Education.name', 'Education.name')));
        $this->set(compact('educations'));

        $states = $this->State->find('list', array('fields' => array('State.name', 'State.name')));
        $this->set(compact('states'));

        $main_surnames = $this->Surname->find('list', array('fields' => array('Surname.name', 'Surname.name')));
        $this->set(compact('main_surnames'));

        $bloodgroups = $this->BloodGroup->find('list', array('fields' => array('BloodGroup.name', 'BloodGroup.name')));
        $this->set(compact('bloodgroups'));

        $sessionData = $this->Session->read('User');

        if ($requestData['type'] == 'self') {

            //$getPeopleData = $this->People->getPeopleData($userId, $toFetchData);
            if ($getPeopleData['People']['date_of_marriage'] == '0000-00-00 00:00:00') {
                $getPeopleData['People']['date_of_marriage'] = '';
            }
            if ($getPeopleData['People']['date_of_birth'] == '0000-00-00 00:00:00') {
                $getPeopleData['People']['date_of_birth'] = '';
            }
            if ($getPeopleData['People']['date_of_death'] == '0000-00-00 00:00:00') {
                $getPeopleData['People']['date_of_death'] = '';
            }
            $this->set('readonly', false);
            $this->set('first_name', $getPeopleData['People']['first_name']);
            $this->set('date_of_birth', $getPeopleData['People']['date_of_birth'] ? date("d/m/Y", strtotime($getPeopleData['People']['date_of_birth'])) : '' );
            $this->set('date_of_marriage', $getPeopleData['People']['date_of_marriage'] ? date("d/m/Y", strtotime($getPeopleData['People']['date_of_marriage'])) : '');
            $this->set('date_of_death', $getPeopleData['People']['date_of_death'] ? date("d/m/Y", strtotime($getPeopleData['People']['date_of_death'])) : '');
            $this->set('address_id', $getPeopleData['People']['address_id']);
            $this->set('main_surname', $getPeopleData['People']['main_surname']);
            $this->set('last_name', $getPeopleData['People']['last_name']);
            $this->set('is_late', $getPeopleData['People']['is_late']);
            $this->set('non_kvo', $getPeopleData['People']['non_kvo']);
            $this->set('mobile_number', $getPeopleData['People']['mobile_number'] ? $getPeopleData['People']['mobile_number'] : $sessionData['mobile_number'] );
            $this->set('email', $getPeopleData['People']['email']);
            $this->set('gender', $getPeopleData['People']['gender']);
            $this->set('martial_status', $getPeopleData['People']['martial_status']);
            $this->set('maiden_surname', $getPeopleData['People']['maiden_surname']);
            $this->set('sect', $getPeopleData['People']['sect']);
            $this->set('state', $getPeopleData['People']['state']);
            /*$this->set('education_1', $getPeopleData['People']['education_1']);
            $this->set('education_2', $getPeopleData['People']['education_2']);
            $this->set('education_3', $getPeopleData['People']['education_3']);
            $this->set('education_4', $getPeopleData['People']['education_4']);
            $this->set('education_5', $getPeopleData['People']['education_5']);*/
            $this->set('year_of_passing_1', $getPeopleData['People']['year_of_passing_1']);
            $this->set('year_of_passing_2', $getPeopleData['People']['year_of_passing_2']);
            $this->set('year_of_passing_3', $getPeopleData['People']['year_of_passing_3']);
            $this->set('year_of_passing_4', $getPeopleData['People']['year_of_passing_4']);
            $this->set('year_of_passing_5', $getPeopleData['People']['year_of_passing_5']);
            $this->set('village', $getPeopleData['People']['village']);
            $this->set('maiden_village', $getPeopleData['People']['maiden_village']);
            $this->set('blood_group', $getPeopleData['People']['blood_group']);
            $this->set('tree_level', $getPeopleData['Group']['tree_level']);
            $this->set('call_again', $getPeopleData['People']['call_again']);
            $this->set('village', $getPeopleData['People']['village']);
            $this->set('ext', $getPeopleData['People']['ext']);
            $this->set('mahajan_membership_number', $getPeopleData['People']['mahajan_membership_number']);
            $this->set('same', $getPeopleData['People']['address_id'] == $getOwnerDetails['address_id'] ? true : false);
            // $getOwnerDetails
        }
    }

    public function transferUser() {
        $this->autoRender = false;
        $this->layout = 'ajax';
        $idToTransfer = $_REQUEST['id'];
        $ownerGroupId = $_REQUEST['ownergroupid'];

        $updatePeple = array();
        $updatePeple['People']['group_id'] = $ownerGroupId;
        $updatePeple['People']['id'] = $idToTransfer;
        $this->People->save($updatePeple);

        $getOwnerId = $this->Group->find('all', array('fields' => array('Group.people_id'), 'conditions'
            => array('Group.id' => $ownerGroupId)));

        $this->PeopleGroup->deleteAll(array('people_id' => $idToTransfer, 'group_id' => $ownerGroupId));

        $peopleGroup = array();
        $peopleGroup['PeopleGroup']['group_id'] = $ownerGroupId;
        $peopleGroup['PeopleGroup']['people_id'] = $idToTransfer;
        $peopleGroup['PeopleGroup']['tree_level'] = $getOwnerId[0]['Group']['people_id'];

        if ($this->PeopleGroup->save($peopleGroup)) {
            $msg['success'] = 1;
            $msg['message'] = 'Transfered successfully';
        } else {
            $msg['success'] = 0;
            $msg['message'] = 'System Error, Please try again';
        }
        $this->set(compact('msg'));
        $this->render("/Elements/json_messages");
    }

    public function transfer() {
        if (!$this->Session->read('Auth.User')) {
            $this->Session->destroy();
            $this->Cookie->delete('Auth.User');

            $this->redirect('/user/login');
        }
        $userID = $this->Session->read('User.user_id');

        $data = $this->request->data;

        $this->set('data', $data);
    }

    /**
     *  AJAX Callback - function to edit own details for creating tree
     */
    public function editOwnDetails() {
        if (!$this->Session->read('Auth.User')) {
            $this->Session->destroy();
            $this->Cookie->delete('Auth.User');

            $this->redirect('/user/login');
        }
        $this->layout = 'ajax';
        $this->autoRender = false;
        $userID = $this->Session->read('User.user_id');

        $data = $this->request->data['People'];

        if ($_REQUEST['peopleid'] != '') {
            $getPeopleDetail = $this->People->find('all', array('fields' => array('People.first_name',
                    'People.last_name', 'People.maiden_surname', 'People.group_id',
                    'People.f_id', 'People.partner_id', 'People.m_id', 'People.partner_name', 'People.village'),
                'conditions' => array('People.id' => $_REQUEST['peopleid']))
            );
        }

        $this->request->data['People']['sect'] = $this->request->data['sect'];
        $this->request->data['People']['gender'] = $this->request->data['gender'];
        $this->request->data['People']['martial_status'] = $this->request->data['martial_status'];

        $this->request->data['People']['is_late'] = $this->request->data['is_late'];
        
        $this->request->data['People']['mobile_number'] = $this->request->data['mobile_number'];
        $this->request->data['People']['date_of_birth'] = $this->request->data['date_of_birth'];

        //insert in translation tables to track missing transaltions
        $getalltranslations = $this->Translation->find('all', array('fields' => array('Translation.id'),
            'conditions' => array('Translation.name' => $this->request->data['People']['first_name'])));

        $translation = array();
        if (count($getalltranslations) == 0) {
            $translation[0]['Translation']['name'] = $this->request->data['People']['first_name'];
            $translation[0]['Translation']['created'] = date('Y-m-d H:i:s');
        }
        $getalltranslation = $this->Translation->find('all', array('fields' => array('Translation.id'),
            'conditions' => array('Translation.name' => $this->request->data['People']['last_name'])));


        if (count($getalltranslation) == 0) {
            $translation[1]['Translation']['name'] = $this->request->data['People']['last_name'];
            $translation[1]['Translation']['created'] = date('Y-m-d H:i:s');
        }

        $this->Translation->saveAll($translation);

        $same = $this->request->data['People']['is_same'];
        $array = array();
        $array['gid'] = $getPeopleDetail[0]['People']['group_id'];
        $getOwnerDetails = $this->People->getParentPeopleDetails($array);
        $parentId = $getOwnerDetails['id'];

        if ($this->request->data['People']['date_of_birth'] != '') {
            $date = date_parse_from_format("d/m/Y", $this->request->data['People']['date_of_birth']);
            $this->request->data['People']['date_of_birth'] = "$date[year]-$date[month]-$date[day]";
        }
        if ($this->request->data['People']['date_of_death'] != '') {
            $date1 = date_parse_from_format("d/m/Y", $this->request->data['People']['date_of_death']);
            $this->request->data['People']['date_of_death'] = "$date1[year]-$date1[month]-$date1[day]";
        }
        if ($this->request->data['People']['date_of_marriage'] != '') {
            $date2 = date_parse_from_format("d/m/Y", $this->request->data['People']['date_of_marriage']);
            $this->request->data['People']['date_of_marriage'] = "$date2[year]-$date2[month]-$date2[day]";
        }

        switch ($_REQUEST['type']) {
            case 'addbrother':
                $this->request->data['People']['tree_level'] = $userID == $_REQUEST['peopleid'] ? 'START' : $_REQUEST['peopleid'];
                $this->request->data['People']['group_id'] = $getPeopleDetail[0]['People']['group_id'];
                $msg['status'] = 1;
                $result = $this->People->checkEmailExists($this->request->data['People']['email']);
                
                if (!empty($result) && !empty($this->request->data['People']['email']) && $this->request->data['People']['id'] == '') {
                    $msg['status'] = 0;
                    $msg['error']['name'][] = "email";
                    $msg['error']['errormsg'][] = __('This Email already exists.');
                }

                if (isset($this->request->data['People']['mobile_number']) && !empty($this->request->data['People']['mobile_number'])) {
                    $phoneData = $this->People->checkPhoneExists($this->request->data['People']['mobile_number']);

                    if (!empty($phoneData) && $this->request->data['People']['id'] == '') {
                        $msg['status'] = 0;
                        $msg['error']['name'][] = "mobile_number";
                        $msg['error']['errormsg'][] = __('This Phone already exists.');
                    }
                }
                if ($msg['status'] == 1) {
                    $this->request->data['People']['created_by'] = $this->Session->read('User.user_id');
                    $this->request->data['People']['created'] = date('Y-m-d H:i:s');
                    $this->request->data['People']['b_id'] = $_REQUEST['peopleid'];                    
                    $this->request->data['People']['brother'] = $getPeopleDetail[0]['People']['first_name'];
                    $this->request->data['People']['m_id'] = $getPeopleDetail[0]['People']['m_id'];
                    $this->request->data['People']['mother'] = $getPeopleDetail[0]['People']['mother'];
                    $this->request->data['People']['f_id'] = $getPeopleDetail[0]['People']['f_id'];
                    $this->request->data['People']['father'] = $getPeopleDetail[0]['People']['father'];
                    
                    if ($this->People->save($this->request->data)) {
                        $msg['status'] = 1;
                        $brotherId = $this->People->id;
                        $updateParentUser = array();
                        $updateParentUser['b_id'] = $brotherId;
                        $updateParentUser['brother'] = $this->request->data['People']['first_name'];
                        $updateParentUser['id'] = $_REQUEST['peopleid'];
                        $this->People->updateBrotherDetails($updateParentUser);

                        $getBrotherDetails = $this->People->find('all', array('fields' => array('People.m_id', 'People.mother', 'People.f_id', 'People.father'),
                            'conditions' => array('People.id' => $_REQUEST['peopleid']))
                        );

                        $message = 'Brother has been added';
                        $peopleGroup = array();
                        $peopleGroup['PeopleGroup']['group_id'] = $getPeopleDetail[0]['People']['group_id'];
                        $peopleGroup['PeopleGroup']['people_id'] = $this->People->id;
                        $peopleGroup['PeopleGroup']['tree_level'] = $_REQUEST['peopleid'];
                        $this->PeopleGroup->save($peopleGroup);
                    
                        //add to brother table
                        $brotherData = array();
                    $brotherData['Brother']['people_id'] = $_REQUEST['peopleid'];
                    $brotherData['Brother']['brother_id'] = $this->People->id;
                    $brotherData['Brother']['created'] = date('Y-m-d H:i:s');
                    $this->Brother->save($brotherData);
                        if ($same == 1) {
                            $this->_copyAddress($parentId, $this->People->id, true);
                        }
                    }
                }
                break;
            case 'addsister':
                    $this->request->data['People']['tree_level'] = $userID == $_REQUEST['peopleid'] ? 'START' : $_REQUEST['peopleid'];
                $this->request->data['People']['group_id'] = $getPeopleDetail[0]['People']['group_id'];
                $msg['status'] = 1;
                $result = $this->People->checkEmailExists($this->request->data['People']['email']);
                
                if (!empty($result) && !empty($this->request->data['People']['email']) && $this->request->data['People']['id'] == '') {
                    $msg['status'] = 0;
                    $msg['error']['name'][] = "email";
                    $msg['error']['errormsg'][] = __('This Email already exists.');
                }

                if (isset($this->request->data['People']['mobile_number']) && !empty($this->request->data['People']['mobile_number'])) {
                    $phoneData = $this->People->checkPhoneExists($this->request->data['People']['mobile_number']);

                    if (!empty($phoneData) && $this->request->data['People']['id'] == '') {
                        $msg['status'] = 0;
                        $msg['error']['name'][] = "mobile_number";
                        $msg['error']['errormsg'][] = __('This Phone already exists.');
                    }
                }
                if ($msg['status'] == 1) {
                    $this->request->data['People']['created_by'] = $this->Session->read('User.user_id');
                    $this->request->data['People']['created'] = date('Y-m-d H:i:s');
                    $this->request->data['People']['s_id'] = $_REQUEST['peopleid'];                    
                    $this->request->data['People']['sister'] = $getPeopleDetail[0]['People']['first_name'];
                    $this->request->data['People']['m_id'] = $getPeopleDetail[0]['People']['m_id'];
                    $this->request->data['People']['mother'] = $getPeopleDetail[0]['People']['mother'];
                    $this->request->data['People']['f_id'] = $getPeopleDetail[0]['People']['f_id'];
                    $this->request->data['People']['father'] = $getPeopleDetail[0]['People']['father'];
                    
                    if ($this->People->save($this->request->data)) {
                        $msg['status'] = 1;
                        $brotherId = $this->People->id;
                        $updateParentUser = array();
                        $updateParentUser['s_id'] = $brotherId;
                        $updateParentUser['sister'] = $this->request->data['People']['first_name'];
                        $updateParentUser['id'] = $_REQUEST['peopleid'];
                        $this->People->updateBrotherDetails($updateParentUser);

                        $getBrotherDetails = $this->People->find('all', array('fields' => array('People.m_id', 'People.mother', 'People.f_id', 'People.father'),
                            'conditions' => array('People.id' => $_REQUEST['peopleid']))
                        );

                        $message = 'Sister has been added';
                        $peopleGroup = array();
                        $peopleGroup['PeopleGroup']['group_id'] = $getPeopleDetail[0]['People']['group_id'];
                        $peopleGroup['PeopleGroup']['people_id'] = $this->People->id;
                        $peopleGroup['PeopleGroup']['tree_level'] = $_REQUEST['peopleid'];
                        $this->PeopleGroup->save($peopleGroup);
                          $brotherData = array();
                $brotherData['Sister']['people_id'] = $_REQUEST['peopleid'];
                $brotherData['Sister']['sister_id'] = $this->People->id;
                $brotherData['Sister']['created'] = date('Y-m-d H:i:s');
                $this->Sister->save($brotherData);
                
                        if ($same == 1) {
                            $this->_copyAddress($parentId, $this->People->id, true);
                        }
                    }
                }
                break;
            case 'addnew':
                $msg['status'] = 1;
                $result = $this->People->checkEmailExists($this->request->data['People']['email']);

                if (!empty($result) && !empty($this->request->data['People']['email']) && $this->request->data['People']['id'] == '') {
                    $msg['status'] = 0;
                    $msg['error']['name'][] = "email";
                    $msg['error']['errormsg'][] = __('This Email already exists.');
                }

                if (isset($this->request->data['People']['mobile_number']) && !empty($this->request->data['People']['mobile_number'])) {
                    $phoneData = $this->People->checkPhoneExists($this->request->data['People']['mobile_number']);

                    if (!empty($phoneData) && $this->request->data['People']['id'] == '') {
                        $msg['status'] = 0;
                        $msg['error']['name'][] = "mobile_number";
                        $msg['error']['errormsg'][] = __('This Phone already exists.');
                    }
                }
                if ($msg['status'] == 1) {
                    $groupData = array();
                    $groupData['Group']['name'] = 'Family of ' . $this->request->data['People']['first_name'];
                    $groupData['Group']['created'] = date('Y-m-d H:i:s');

                    $this->Group->save($groupData);
                    $this->request->data['People']['group_id'] = $this->Group->id;
                    $this->request->data['People']['created_by'] = $this->Session->read('User.user_id');
                    $this->request->data['People']['created'] = date('Y-m-d H:i:s');
                    if ($this->People->save($this->request->data)) {
                        $msg['status'] = 1;
                        $message = 'Family has been created';
                        $peopleGroup = array();
                        $peopleGroup['PeopleGroup']['group_id'] = $this->Group->id;
                        $peopleGroup['PeopleGroup']['people_id'] = $this->People->id;
                        $this->PeopleGroup->save($peopleGroup);
                        //update group table with people id
                        $groupData = array();
                        $groupData['Group']['people_id'] = $this->People->id;
                        $groupData['Group']['id'] = $this->Group->id;
                        $msg['grpid'] = $this->Group->id;
                        $this->Group->save($groupData);
                    } else {
                        $msg['success'] = 0;
                        $msg['message'] = 'System Error, Please trye again';
                    }
                }
                break;
            case 'addexspouse':
                $this->request->data['People']['partner_id'] = $_REQUEST['peopleid'];
                $this->request->data['People']['tree_level'] = $userID == $_REQUEST['peopleid'] ? 'START' : $_REQUEST['peopleid'];
                $this->request->data['People']['group_id'] = $getPeopleDetail[0]['People']['group_id'];
                $msg['status'] = 1;
                $result = $this->People->checkEmailExists($this->request->data['People']['email']);

                if (!empty($result) && !empty($this->request->data['People']['email']) && $this->request->data['People']['id'] == '') {
                    $msg['status'] = 0;
                    $msg['error']['name'][] = "email";
                    $msg['error']['errormsg'][] = __('This Email already exists.');
                }

                if (isset($this->request->data['People']['mobile_number']) && !empty($this->request->data['People']['mobile_number'])) {
                    $phoneData = $this->People->checkPhoneExists($this->request->data['People']['mobile_number']);
                    if (!empty($phoneData) && $this->request->data['People']['id'] == '') {
                        $msg['status'] = 0;
                        $msg['error']['name'][] = "mobile_number";
                        $msg['error']['errormsg'][] = __('This Phone already exists.');
                    }
                }
                $name = $getPeopleDetail[0]['People']['first_name'] . '' . $getPeopleDetail[0]['People']['lastname'];
                $this->request->data['People']['partner_name'] = $name;
                $this->request->data['People']['created_by'] = $this->Session->read('User.user_id');
                $this->request->data['People']['created'] = date('Y-m-d H:i:s');
                if ($msg['status'] == 1) {
                    if ($this->People->save($this->request->data)) {
                        $msg['status'] = 1;
                        $partnerId = $this->People->id;
                        $updateParentUser = array();
                        $updateParentUser['spouse_id'] = $partnerId;
                        $updateParentUser['spouse_name'] = $this->request->data['People']['first_name'];
                        $updateParentUser['people_id'] = $_REQUEST['peopleid'];
                        $updateParentUser['created'] = date('Y-m-d H:i:s');
                        $this->Spouse->save($updateParentUser);
                        $message = 'Ex- Spouse has been added';
                        $peopleGroup = array();
                        $peopleGroup['PeopleGroup']['group_id'] = $getPeopleDetail[0]['People']['group_id'];
                        $peopleGroup['PeopleGroup']['people_id'] = $this->People->id;
                        $peopleGroup['PeopleGroup']['tree_level'] = $_REQUEST['peopleid'];
                        $this->PeopleGroup->save($peopleGroup);
                        if ($same == 1) {
                            $this->_copyAddress($parentId, $this->People->id);
                        }
                    }
                } else {
                    $msg['success'] = 0;
                    $msg['message'] = 'System Error, Please trye again';
                }
                break;
            case 'addspouse':
                $this->request->data['People']['partner_id'] = $_REQUEST['peopleid'];
                $this->request->data['People']['tree_level'] = $userID == $_REQUEST['peopleid'] ? 'START' : $_REQUEST['peopleid'];
                $this->request->data['People']['group_id'] = $getPeopleDetail[0]['People']['group_id'];
                //unset($this->request->data['People']['village']);
                // $this->request->data['People']['village'] = $getPeopleDetail[0]['People']['village'];
                $msg['status'] = 1;
                $result = $this->People->checkEmailExists($this->request->data['People']['email']);

                if (!empty($result) && !empty($this->request->data['People']['email']) && $this->request->data['People']['id'] == '') {
                    $msg['status'] = 0;
                    $msg['error']['name'][] = "email";
                    $msg['error']['errormsg'][] = __('This Email already exists.');
                }

                if (isset($this->request->data['People']['mobile_number']) && !empty($this->request->data['People']['mobile_number'])) {
                    $phoneData = $this->People->checkPhoneExists($this->request->data['People']['mobile_number']);
                    if (!empty($phoneData) && $this->request->data['People']['id'] == '') {
                        $msg['status'] = 0;
                        $msg['error']['name'][] = "mobile_number";
                        $msg['error']['errormsg'][] = __('This Phone already exists.');
                    }
                }
                $name = $getPeopleDetail[0]['People']['first_name'] . '' . $getPeopleDetail[0]['People']['lastname'];
                $this->request->data['People']['partner_name'] = $name;

                $this->request->data['People']['created_by'] = $this->Session->read('User.user_id');
                $this->request->data['People']['created'] = date('Y-m-d H:i:s');
                if ($msg['status'] == 1) {
                    if ($this->People->save($this->request->data)) {
                        $msg['status'] = 1;
                        $partnerId = $this->People->id;
                        $updateParentUser = array();
                        $updateParentUser['partner_id'] = $partnerId;
                        $updateParentUser['partner_name'] = $this->request->data['People']['first_name'];
                        $updateParentUser['id'] = $_REQUEST['peopleid'];
                        $this->People->updateSpouseDetails($updateParentUser);
                        $message = 'Spouse has been added';
                        $peopleGroup = array();
                        $peopleGroup['PeopleGroup']['group_id'] = $getPeopleDetail[0]['People']['group_id'];
                        $peopleGroup['PeopleGroup']['people_id'] = $this->People->id;
                        $peopleGroup['PeopleGroup']['tree_level'] = $_REQUEST['peopleid'];
                        $this->PeopleGroup->save($peopleGroup);
                        if ($same == 1) {
                            $this->_copyAddress($parentId, $this->People->id);
                        }
                    }
                } else {
                    $msg['success'] = 0;
                    $msg['message'] = 'System Error, Please trye again';
                }
                break;
            case 'addfather':

                $this->request->data['People']['tree_level'] = $userID == $_REQUEST['peopleid'] ? 'START' : $_REQUEST['peopleid'];
                $this->request->data['People']['group_id'] = $getPeopleDetail[0]['People']['group_id'];
                //unset($this->request->data['People']['village']);
                //$this->request->data['People']['village'] = $getPeopleDetail[0]['People']['village'];
                $msg['status'] = 1;
                $result = $this->People->checkEmailExists($this->request->data['People']['email']);
                if (!empty($result) && !empty($this->request->data['People']['email']) && $this->request->data['People']['id'] == '') {
                    $msg['status'] = 0;
                    $msg['error']['name'][] = "email";
                    $msg['error']['errormsg'][] = __('This Email already exists.');
                }

                if (isset($this->request->data['People']['mobile_number']) && !empty($this->request->data['People']['mobile_number'])) {
                    $phoneData = $this->People->checkPhoneExists($this->request->data['People']['mobile_number']);

                    if (!empty($phoneData) && $this->request->data['People']['id'] == '') {
                        $msg['status'] = 0;
                        $msg['error']['name'][] = "mobile_number";
                        $msg['error']['errormsg'][] = __('This Phone already exists.');
                    }
                }
                if ($msg['status'] == 1) {
                    $this->request->data['People']['created_by'] = $this->Session->read('User.user_id');
                    $this->request->data['People']['created'] = date('Y-m-d H:i:s');
                    if ($this->People->save($this->request->data)) {
                        $msg['status'] = 1;
                        $fatherId = $this->People->id;
                        $updateParentUser = array();
                        $updateParentUser['f_id'] = $fatherId;
                        $updateParentUser['father'] = $this->request->data['People']['first_name'];
                        $updateParentUser['id'] = $_REQUEST['peopleid'];
                        $this->People->updateFatherDetails($updateParentUser);
                        //check if mother exists in table for child
                        $getMotherDetails = $this->People->find('all', array('fields' => array('People.m_id', 'People.mother'),
                            'conditions' => array('People.id' => $_REQUEST['peopleid']))
                        );

                        if (!empty($getMotherDetails[0]['People']['m_id'])) {
                            $data = array();
                            $data['partner_id'] = $getMotherDetails[0]['People']['m_id'];
                            $data['partner_name'] = $getMotherDetails[0]['People']['mother'];
                            $data['id'] = $fatherId;
                            $this->People->updateSpouseDetails($data);
                            //back update father row for parter details
                            $data = array();
                            $data['partner_id'] = $fatherId;
                            $data['partner_name'] = $this->request->data['People']['first_name'];
                            $data['id'] = $getMotherDetails[0]['People']['m_id'];
                            $this->People->updateSpouseDetails($data);
                        }

                        $message = 'Father has been added';
                        $peopleGroup = array();
                        $peopleGroup['PeopleGroup']['group_id'] = $getPeopleDetail[0]['People']['group_id'];
                        $peopleGroup['PeopleGroup']['people_id'] = $this->People->id;
                        $peopleGroup['PeopleGroup']['tree_level'] = $_REQUEST['peopleid'];
                        $this->PeopleGroup->save($peopleGroup);
                        if ($same == 1) {
                            $this->_copyAddress($parentId, $this->People->id);
                        }
                    }
                } else {
                    $msg['success'] = 0;
                    $msg['message'] = 'System Error, Please trye again';
                }

                break;
            case 'addchilld':                
                
                // get childrens ids
                $childs = $this->People->find('all', array(
                    'conditions' => array('People.f_id' => $_REQUEST['peopleid']),
                    'fields' => array('People.id', 'People.gender')
                ));
              
                 
                
                $mothers = $this->People->getAllSpouses($_REQUEST['peopleid']);
                //echo '<pre>';print_r($mothers);exit;
                if (count($mothers) > 1) {
                    $this->request->data['People']['m_id'] = $_REQUEST['data']['People']['mothers'];
                    $this->request->data['People']['mother'] = $mothers[$_REQUEST['data']['People']['mothers']];
                } else {
                    $this->request->data['People']['m_id'] = $getPeopleDetail[0]['People']['partner_id'];
                    $this->request->data['People']['mother'] = $getPeopleDetail[0]['People']['partner_name'];
                }
                $this->request->data['People']['tree_level'] = $userID == $_REQUEST['peopleid'] ? 'START' : $_REQUEST['peopleid'];
                $this->request->data['People']['group_id'] = $getPeopleDetail[0]['People']['group_id'];
                $this->request->data['People']['f_id'] = $_REQUEST['peopleid'];

                $this->request->data['People']['father'] = $getPeopleDetail[0]['People']['first_name'];

                // unset($this->request->data['People']['village']);
                // $this->request->data['People']['village'] = $getPeopleDetail[0]['People']['village'];
                $msg['status'] = 1;
                $result = $this->People->checkEmailExists($this->request->data['People']['email']);

                if (!empty($result) && !empty($this->request->data['People']['email']) && $this->request->data['People']['id'] == '') {
                    $msg['status'] = 0;
                    $msg['error']['name'][] = "email";
                    $msg['error']['errormsg'][] = __('This Email already exists.');
                }

                if (isset($this->request->data['People']['mobile_number'])) {
                    $phoneData = $this->People->checkPhoneExists($this->request->data['People']['mobile_number']);

                    if (!empty($phoneData) && !empty($this->request->data['People']['mobile_number']) && $this->request->data['People']['id'] == '') {
                        $msg['status'] = 0;
                        $msg['error']['name'][] = "mobile_number";
                        $msg['error']['errormsg'][] = __('This Phone already exists.');
                    }
                }
                if ($msg['status'] == 1) {
                    $this->request->data['People']['created_by'] = $this->Session->read('User.user_id');
                    $this->request->data['People']['created'] = date('Y-m-d H:i:s');
                    if ($this->People->save($this->request->data)) {
                        $msg['status'] = 1;
                        $message = 'Child has been added';
                        $peopleGroup = array();
                        $peopleGroup['PeopleGroup']['group_id'] = $getPeopleDetail[0]['People']['group_id'];
                        $peopleGroup['PeopleGroup']['people_id'] = $this->People->id;
                        $peopleGroup['PeopleGroup']['tree_level'] = $_REQUEST['peopleid'];
                        $this->PeopleGroup->save($peopleGroup);
                        if ($same == 1) {
                            $this->_copyAddress($parentId, $this->People->id);
                        }
                        if ($this->request->data['People']['gender'] == 'Male') {
                            $brotherData = array();
                            foreach ($childs as $key => $value) {
                                $brotherData[$key]['Brother']['people_id'] = $value['People']['id'];
                                $brotherData[$key]['Brother']['brother_id'] = $this->People->id;
                            }

                            $this->Brother->saveAll($brotherData);
                           
                             $addBrotherForNew = array();
                            foreach ($childs as $key => $value) {
                                
                                if ($value['People']['gender'] == 'Male') {
                                    $addBrotherForNew[$key]['Brother']['people_id'] = $this->People->id;
                                    $addBrotherForNew[$key]['Brother']['brother_id'] = $value['People']['id'];
                                   
                                } 
                            }
                             $this->Brother->saveAll($addBrotherForNew);
                            $addSisterForNew = array();
                              foreach ($childs as $key => $value) {
                                
                                if ($value['People']['gender'] == 'Female') {
                                    $addSisterForNew[$key]['Sister']['people_id'] = $this->People->id;
                                    $addSisterForNew[$key]['Sister']['sister_id'] = $value['People']['id'];
                                   
                                } 
                            }
                             $this->Sister->saveAll($addSisterForNew);
                           
                            
                            
                        } else {
                            $sisterData = array();
                            foreach ($childs as $key => $value) {
                                $sisterData[$key]['Sister']['people_id'] = $value['People']['id'];
                                $sisterData[$key]['Sister']['sister_id'] = $this->People->id;
                            }

                            $this->Sister->saveAll($sisterData);
                            $addBrotherForNew = array();
                            foreach ($childs as $key => $value) {
                                
                                if ($value['People']['gender'] == 'Male') {
                                    $addBrotherForNew[$key]['Brother']['people_id'] = $this->People->id;
                                    $addBrotherForNew[$key]['Brother']['brother_id'] = $value['People']['id'];
                                   
                                } 
                            }
                             $this->Brother->saveAll($addBrotherForNew);
                            $addSisterForNew = array();
                              foreach ($childs as $key => $value) {
                                
                                if ($value['People']['gender'] == 'Female') {
                                    $addSisterForNew[$key]['Sister']['people_id'] = $this->People->id;
                                    $addSisterForNew[$key]['Sister']['sister_id'] = $value['People']['id'];
                                   
                                } 
                            }
                             $this->Sister->saveAll($addSisterForNew);
                           
                        }
                    }
                } else {
                    $msg['success'] = 0;
                    $msg['message'] = 'System Error, Please trye again';
                }

                break;
            case 'addmother':

                $this->request->data['People']['tree_level'] = $userID == $_REQUEST['peopleid'] ? 'START' : $_REQUEST['peopleid'];
                $this->request->data['People']['group_id'] = $getPeopleDetail[0]['People']['group_id'];
                //unset($this->request->data['People']['village']);
                //$this->request->data['People']['village'] = $getPeopleDetail[0]['People']['village'];
                $msg['status'] = 1;
                $result = $this->People->checkEmailExists($this->request->data['People']['email']);

                if (!empty($result) && !empty($this->request->data['People']['email']) && $this->request->data['People']['id'] == '') {
                    $msg['status'] = 0;
                    $msg['error']['name'][] = "email";
                    $msg['error']['errormsg'][] = __('This Email already exists.');
                }

                if (isset($this->request->data['People']['mobile_number'])) {
                    $phoneData = $this->People->checkPhoneExists($this->request->data['People']['mobile_number']);

                    if (!empty($phoneData) && !empty($this->request->data['People']['mobile_number']) && $this->request->data['People']['id'] == '') {
                        $msg['status'] = 0;
                        $msg['error']['name'][] = "mobile_number";
                        $msg['error']['errormsg'][] = __('This Phone already exists.');
                    }
                }
                if ($msg['status'] == 1) {
                    $this->request->data['People']['created_by'] = $this->Session->read('User.user_id');
                    $this->request->data['People']['created'] = date('Y-m-d H:i:s');
                    if ($this->People->save($this->request->data)) {
                        $msg['status'] = 1;
                        $motherId = $this->People->id;
                        $updateParentUser = array();
                        $updateParentUser['m_id'] = $motherId;
                        $updateParentUser['mother'] = $this->request->data['People']['first_name'];
                        $updateParentUser['id'] = $_REQUEST['peopleid'];
                        $this->People->updateMotherDetails($updateParentUser);
                        //check if father exists in table for child
                        $getFatherDetails = $this->People->find('all', array('fields' => array('People.f_id', 'People.father'),
                            'conditions' => array('People.id' => $_REQUEST['peopleid']))
                        );
                        if (!empty($getFatherDetails[0]['People']['f_id'])) {
                            $data = array();
                            $data['partner_id'] = $getFatherDetails[0]['People']['f_id'];
                            $data['partner_name'] = $getFatherDetails[0]['People']['father'];
                            $data['id'] = $motherId;
                            $this->People->updateSpouseDetails($data);

                            //back update father row for parter details
                            $data = array();
                            $data['partner_id'] = $motherId;
                            $data['partner_name'] = $this->request->data['People']['first_name'];
                            $data['id'] = $getFatherDetails[0]['People']['f_id'];
                            $this->People->updateSpouseDetails($data);
                        }

                        $message = 'Mother has been added';
                        $peopleGroup = array();
                        $peopleGroup['PeopleGroup']['group_id'] = $getPeopleDetail[0]['People']['group_id'];
                        $peopleGroup['PeopleGroup']['people_id'] = $this->People->id;
                        $peopleGroup['PeopleGroup']['tree_level'] = $_REQUEST['peopleid'];
                        $this->PeopleGroup->save($peopleGroup);
                        if ($same == 1) {
                            $this->_copyAddress($parentId, $this->People->id);
                        }
                    }
                } else {
                    $msg['success'] = 0;
                    $msg['message'] = 'System Error, Please trye again';
                }

                break;
            default:
                $checkExistingUser = $this->People->find('all', array('fields' => array('People.id'),
                    'conditions' => array('People.id' => $_REQUEST['peopleid']))
                );


                if (count($checkExistingUser)) {
                    $this->request->data['People']['id'] = $_REQUEST['peopleid'];
                    $this->request->data['People']['modified'] = date('Y-m-d H:i:s');
                    if ($this->People->save($this->request->data)) {
                        $msg['status'] = 1;
                        if ($same == 1) {
                            $this->_copyAddress($parentId, $_REQUEST['peopleid']);
                        }
                    } else {
                        $msg['status'] = 0;
                    }
                }
                $message = 'Information updated';
                break;
        }

        if ($msg['status'] == 1) {
            $msg['success'] = 1;
            $msg['message'] = $message;
        } else {
            $msg['success'] = 0;
            $msg['message'] = 'System Error, Please try again';
        }

        $this->set(compact('msg'));
        $this->render("/Elements/json_messages");
    }

    /**
     * function to make a member as hof of new family
     * 
     */
    public function insertUser() {
        $this->layout = 'ajax';
        $this->autoRender = false;

        $type = $_REQUEST['type'];
        $idToBeUpdated = $_REQUEST['id'];
        $gid = $_REQUEST['gid'];
        $peopleId = $_REQUEST['peopleid'];
        if ('addchilld' == $type) {
            $_REQUEST['peopleid'] = $idToBeUpdated;
        }
        $getPeopleDetail = $this->People->find('all', array(
            'conditions' => array('People.id' => $_REQUEST['peopleid']))
        );
        $this->request->data = $getPeopleDetail[0];
        $updatePeople = array();

        switch ($type) {
            case 'addbrother':
                $peopleGroup = array();
                $peopleGroup['PeopleGroup']['group_id'] = $gid;
                $peopleGroup['PeopleGroup']['people_id'] = $peopleId;
                $peopleGroup['PeopleGroup']['tree_level'] = $idToBeUpdated;
                $this->PeopleGroup->save($peopleGroup);
                                
                // add brother
                $brotherData = array();
                $brotherData['Brother']['people_id'] = $idToBeUpdated;
                $brotherData['Brother']['brother_id'] = $peopleId;
                $brotherData['Brother']['created'] = date('Y-m-d H:i:s');
                $this->Brother->save($brotherData);
                $updateBrotherDetails = array();
                $updateBrotherDetails['People']['b_id'] = $peopleId;
                $updateBrotherDetails['People']['brother'] = $getPeopleDetail[0]['People']['first_name'];
                $updateBrotherDetails['People']['id'] = $idToBeUpdated;
                $updateBrotherDetails['People']['modified'] = date('Y-m-d H:i:s');
                $this->request->data['People']['created_by'] = $this->Session->read('User.user_id');
                $this->People->save($updateBrotherDetails);
                
                $updateSecondBrotherDetails = array();
                $updateSecondBrotherDetails['People']['b_id'] = $idToBeUpdated;
                $updateSecondBrotherDetails['People']['brother'] = $getParentPeopleDetail[0]['People']['first_name'];
                $updateSecondBrotherDetails['People']['id'] = $peopleId;
                $updateSecondBrotherDetails['People']['modified'] = date('Y-m-d H:i:s');
                $updateSecondBrotherDetails['People']['m_id'] = $getParentPeopleDetail[0]['People']['m_id'];
                $updateSecondBrotherDetails['People']['mother'] = $getParentPeopleDetail[0]['People']['mother'];
                $updateSecondBrotherDetails['People']['f_id'] = $getParentPeopleDetail[0]['People']['f_id'];
                $updateSecondBrotherDetails['People']['father'] = $getParentPeopleDetail[0]['People']['father'];

                $this->People->save($updateSecondBrotherDetails);
                $msg['group_id'] = $gid;
                $message = 'Brother has been added';
                break;
             case 'addsister':
                $peopleGroup = array();
                $peopleGroup['PeopleGroup']['group_id'] = $gid;
                $peopleGroup['PeopleGroup']['people_id'] = $peopleId;
                $peopleGroup['PeopleGroup']['tree_level'] = $idToBeUpdated;
                $this->PeopleGroup->save($peopleGroup);      
                $brotherData = array();
                $brotherData['Sister']['people_id'] = $idToBeUpdated;
                $brotherData['Sister']['sister_id'] = $peopleId;
                $brotherData['Sister']['created'] = date('Y-m-d H:i:s');
                $this->Sister->save($brotherData);
                
                $updateBrotherDetails = array();
                $updateBrotherDetails['People']['s_id'] = $peopleId;
                $updateBrotherDetails['People']['sister'] = $getPeopleDetail[0]['People']['first_name'];
                $updateBrotherDetails['People']['id'] = $idToBeUpdated;
                $updateBrotherDetails['People']['modified'] = date('Y-m-d H:i:s');
                $this->request->data['People']['created_by'] = $this->Session->read('User.user_id');
                $this->People->save($updateBrotherDetails);
                
                $updateSecondBrotherDetails = array();
                $updateSecondBrotherDetails['People']['s_id'] = $idToBeUpdated;
                $updateSecondBrotherDetails['People']['sister'] = $getParentPeopleDetail[0]['People']['first_name'];
                $updateSecondBrotherDetails['People']['id'] = $peopleId;
                $updateSecondBrotherDetails['People']['modified'] = date('Y-m-d H:i:s');
                $updateSecondBrotherDetails['People']['m_id'] = $getParentPeopleDetail[0]['People']['m_id'];
                $updateSecondBrotherDetails['People']['mother'] = $getParentPeopleDetail[0]['People']['mother'];
                $updateSecondBrotherDetails['People']['f_id'] = $getParentPeopleDetail[0]['People']['f_id'];
                $updateSecondBrotherDetails['People']['father'] = $getParentPeopleDetail[0]['People']['father'];

                $this->People->save($updateSecondBrotherDetails);
                $msg['group_id'] = $gid;
                $message = 'Brother has been added';
                break;                
            case 'addfather':

                $data = $this->Group->find('all', array('fields' => array('Group.id'),
                    'conditions' => array('Group.people_id' => $peopleId)));

                $peopleGroup = array();
                $peopleGroup['PeopleGroup']['group_id'] = $gid;
                $peopleGroup['PeopleGroup']['people_id'] = $peopleId;
                $peopleGroup['PeopleGroup']['tree_level'] = $idToBeUpdated;
                $this->PeopleGroup->save($peopleGroup);
                //check if father has his own family
                if (!isset($data[0]) && !count($data)) {
                    // $updatePeople = array();
                    // $updatePeople['People']['group_id'] = $gid;
                    // $updatePeople['People']['id'] = $peopleId;
                }
                //update father details
                $updateFatherDetails = array();
                $updateFatherDetails['People']['f_id'] = $peopleId;
                $updateFatherDetails['People']['father'] = $getPeopleDetail[0]['People']['first_name'];
                $updateFatherDetails['People']['id'] = $idToBeUpdated;
                $updateMotherDetails['People']['modified'] = date('Y-m-d H:i:s');
                $this->request->data['People']['created_by'] = $this->Session->read('User.user_id');
                $this->People->save($updateFatherDetails);
                $msg['group_id'] = $gid;
                $message = 'Father has been added';
                break;
            case 'addmother':
                $peopleGroup = array();
                $peopleGroup['PeopleGroup']['group_id'] = $gid;
                $peopleGroup['PeopleGroup']['people_id'] = $_REQUEST['peopleid'];
                $peopleGroup['PeopleGroup']['tree_level'] = $idToBeUpdated;
                $this->PeopleGroup->save($peopleGroup);
                //$updatePeople = array();
                //$updatePeople['People']['group_id'] = $gid;
                //$updatePeople['People']['id'] = $_REQUEST['peopleid'];
                //update mother details
                $updateMotherDetails = array();
                $updateMotherDetails['People']['m_id'] = $_REQUEST['peopleid'];
                $updateMotherDetails['People']['mother'] = $getPeopleDetail[0]['People']['first_name'];
                $updateMotherDetails['People']['id'] = $idToBeUpdated;
                $updateMotherDetails['People']['modified'] = date('Y-m-d H:i:s');
                $this->People->save($updateMotherDetails);
                $msg['group_id'] = $gid;
                $message = 'Mother has been added';
                break;
            case 'addchilld':
                $data = $this->Group->find('all', array('fields' => array('Group.id'),
                    'conditions' => array('Group.people_id' => $peopleId)));

              $childs = $this->People->find('all', array(
                    'conditions' => array('People.f_id' => $_REQUEST['peopleid']),
                    'fields' => array('People.id', 'People.gender')
                ));
                
                $getGender = $this->People->find('all', array(
                    'conditions' => array('People.id' => $peopleId),
                    'fields' => array('People.gender')
                ));
                
                $peopleGroup = array();
                $peopleGroup['PeopleGroup']['group_id'] = $gid;
                $peopleGroup['PeopleGroup']['people_id'] = $peopleId;
                $peopleGroup['PeopleGroup']['tree_level'] = $idToBeUpdated;
                $this->PeopleGroup->save($peopleGroup);
                //check if member has his own family
                if (!isset($data[0]) && !count($data)) {
                    //$updatePeople = array();
                    // $updatePeople['People']['group_id'] = $gid;
                    // $updatePeople['People']['id'] = $peopleId;
                }

                $updateFatherDetails = array();
                $updateFatherDetails['People']['f_id'] = $idToBeUpdated;
                $updateFatherDetails['People']['m_id'] = $getPeopleDetail[0]['People']['partner_id'];
                $updateFatherDetails['People']['father'] = $getPeopleDetail[0]['People']['first_name'];
                $updateFatherDetails['People']['mother'] = $getPeopleDetail[0]['People']['partner_name'];
                $updateFatherDetails['People']['id'] = $peopleId;
                $updateMotherDetails['People']['modified'] = date('Y-m-d H:i:s');
                $this->request->data['People']['created_by'] = $this->Session->read('User.user_id');
                $this->People->save($updateFatherDetails);
                
                    if ($getGender[0]['People']['gender'] == 'Male') {
                            $brotherData = array();
                            foreach ($childs as $key => $value) {
                                $brotherData[$key]['Brother']['people_id'] = $value['People']['id'];
                                $brotherData[$key]['Brother']['brother_id'] = $peopleId;
                            }

                            $this->Brother->saveAll($brotherData);
                           
                             $addBrotherForNew = array();
                            foreach ($childs as $key => $value) {
                                
                                if ($value['People']['gender'] == 'Male') {
                                    $addBrotherForNew[$key]['Brother']['people_id'] = $peopleId;
                                    $addBrotherForNew[$key]['Brother']['brother_id'] = $value['People']['id'];
                                   
                                } 
                            }
                             $this->Brother->saveAll($addBrotherForNew);
                            $addSisterForNew = array();
                              foreach ($childs as $key => $value) {
                                
                                if ($value['People']['gender'] == 'Female') {
                                    $addSisterForNew[$key]['Sister']['people_id'] = $peopleId;
                                    $addSisterForNew[$key]['Sister']['sister_id'] = $value['People']['id'];
                                   
                                } 
                            }
                             $this->Sister->saveAll($addSisterForNew);
                           
                            
                            
                        } else {
                            $sisterData = array();
                            foreach ($childs as $key => $value) {
                                $sisterData[$key]['Sister']['people_id'] = $value['People']['id'];
                                $sisterData[$key]['Sister']['sister_id'] = $peopleId;
                            }

                            $this->Sister->saveAll($sisterData);
                            $addBrotherForNew = array();
                            foreach ($childs as $key => $value) {
                                
                                if ($value['People']['gender'] == 'Male') {
                                    $addBrotherForNew[$key]['Brother']['people_id'] = $peopleId;
                                    $addBrotherForNew[$key]['Brother']['brother_id'] = $value['People']['id'];
                                   
                                } 
                            }
                             $this->Brother->saveAll($addBrotherForNew);
                            $addSisterForNew = array();
                              foreach ($childs as $key => $value) {
                                
                                if ($value['People']['gender'] == 'Female') {
                                    $addSisterForNew[$key]['Sister']['people_id'] = $peopleId;
                                    $addSisterForNew[$key]['Sister']['sister_id'] = $value['People']['id'];
                                   
                                } 
                            }
                             $this->Sister->saveAll($addSisterForNew);
                           
                        }
                $msg['group_id'] = $gid;
                $message = 'Child has been added';
                break;
            case 'addspouse':
                $data = $this->Group->find('all', array('fields' => array('Group.id'),
                    'conditions' => array('Group.people_id' => $peopleId)));

                $peopleGroup = array();
                $peopleGroup['PeopleGroup']['group_id'] = $gid;
                $peopleGroup['PeopleGroup']['people_id'] = $peopleId;
                $peopleGroup['PeopleGroup']['tree_level'] = $idToBeUpdated;
                $this->PeopleGroup->save($peopleGroup);

                //$updatePeople = array();
                //$updatePeople['People']['group_id'] = $gid;
                //$updatePeople['People']['id'] = $_REQUEST['peopleid'];
                //update spouse details
                $updateMotherDetails = array();
                $updateMotherDetails['People']['partner_id'] = $_REQUEST['peopleid'];
                $updateMotherDetails['People']['partner_name'] = $getPeopleDetail[0]['People']['first_name'];
                $updateMotherDetails['People']['id'] = $idToBeUpdated;
                $updateMotherDetails['People']['modified'] = date('Y-m-d H:i:s');
                $this->People->save($updateMotherDetails);
                $msg['group_id'] = $gid;
                $message = 'Spouse has been added';
                break;
            case 'addnew':
                $peopleData = $_REQUEST['data'];
                $data = $this->People->checkExistingOwner($peopleData);

                if (count($data) > 0) {
                    $message = $peopleData['first_name'] . ' ' . $peopleData['last_name'] . ' is already owner';
                } else {
                    $groupData = array();
                    $groupData['Group']['name'] = 'Family of ' . $getPeopleDetail[0]['People']['first_name'];
                    $groupData['Group']['created'] = date('Y-m-d H:i:s');
                    $groupData['Group']['people_id'] = $_REQUEST['peopleid'];
                    //save group as new group
                    $this->Group->save($groupData);
                    $peopleGroup = array();
                    $peopleGroup['PeopleGroup']['group_id'] = $this->Group->id;
                    $peopleGroup['PeopleGroup']['people_id'] = $_REQUEST['peopleid'];
                    // insert people ids and group ids
                    $this->PeopleGroup->save($peopleGroup);
                    // update group id for old people
                    $updatePeople = array();
                    $updatePeople['People']['group_id'] = $this->Group->id;
                    $updatePeople['People']['call_again'] = 0;
                    $updatePeople['People']['id'] = $_REQUEST['peopleid'];

                    $getAllRelationships = $this->People->getAllRelationsIds($_REQUEST['peopleid']);

                    $getAllChildren = $this->People->getChildren($_REQUEST['peopleid'], 'Male', $gid);
                    //
                    $ids = array();
                    foreach ($getAllChildren as $key => $value) {
                        $ids[] = $value['People']['id'];
                    }

                    foreach ($getAllRelationships as $k => $v) {
                        $ids[] = $v;
                    }
                    $i = 0;

                    $allData = array();
                    foreach ($ids as $peopleIds) {
                        if (!empty($peopleIds)) {
                            $allData[$i]['PeopleGroup']['group_id'] = $this->Group->id;
                            $allData[$i]['PeopleGroup']['people_id'] = $peopleIds;
                            $allData[$i]['PeopleGroup']['tree_level'] = $_REQUEST['peopleid'];
                            $i++;
                        }
                    }
                    $this->PeopleGroup->saveAll($allData);
                }
                $msg['group_id'] = $this->Group->id;
                $message = 'Family has been created';
                break;
            default:
                break;
        }
        if ($this->People->save($updatePeople)) {
            $msg['status'] = 1;
        } else {
            $msg['status'] = 0;
            $message = 'System Error';
        }

        if ($msg['status'] == 1) {
            $msg['success'] = 1;
            $msg['message'] = $message;
        } else {
            $msg['success'] = 0;
            $msg['message'] = 'System Error, Please try again';
        }
        $this->set(compact('msg'));
        $this->render("/Elements/json_messages");
    }

    private function _copyAddress($parentId, $peopleid) {
        $conditions = array('Address.people_id' => $parentId);
        $getParentAddress = $this->Address->find('all', array('conditions' => $conditions));

        unset($getParentAddress[0]['Address']['id']);
        unset($getParentAddress[0]['Address']['people_id']);
        $getParentAddress[0]['Address']['created'] = date('Y-m-d H:i:s');
        $getParentAddress[0]['Address']['people_id'] = $peopleid;

        $this->request->data = $getParentAddress[0];
        if ($this->Address->save($this->request->data)) {
            $addressId = $this->Address->id;
            $updatePeople = array();
            $updatePeople['People']['address_id'] = $addressId;
            $updatePeople['People']['id'] = $peopleid;
            $this->People->save($updatePeople);
        }
    }

    public function details() {
        if (!$this->Session->read('Auth.User')) {
            $this->Session->destroy();
            $this->Cookie->delete('Auth.User');

            $this->redirect('/user/login');
        }
        $id = $this->request->params['pass'][0];
        if ($id !== $this->Session->read('User.group_id')) {
            $this->redirect('/family/details/' . $this->Session->read('User.group_id'));
            exit;
        }

        $userID = $this->Session->read('User.user_id');
        $roleID = $this->Session->read('User.role_id');
        $getOwners = $this->Group->getOwners();

        $ownerData = array();
        foreach ($getOwners as $key => $value) {
            $ownerData[$value['Group']['id']]['name'] = $value['People']['first_name'] . ' ' . $value['People']['last_name'];
            $ownerData[$value['Group']['id']]['group_id'] = $value['Group']['id'];
            $ownerData[$value['Group']['id']]['id'] = $value['People']['id'];
            $ownerData[$value['Group']['id']]['owner'] = $value['User']['first_name'] . ' ' . $value['User']['last_name'];
        }

        $this->set('owners', $ownerData);
        $this->set('type', isset($_REQUEST['type']) ? $_REQUEST['type'] : 'english');



        if (array_key_exists($id, $ownerData)) {
            $this->set('ownername', $ownerData[$id]['owner']);
        }
        $getDetails = $this->People->getFamilyDetails($id, false, true);
        
        $names = array();
        foreach ($getDetails as $ky => $vl) {
            $names[] = $vl['People']['first_name'];
            $names[] = $vl['People']['last_name'];
            $names[] = $vl['People']['father'];
            $names[] = $vl['People']['mother'];
            $names[] = $vl['People']['partner_name'];
            $names[] = $vl[0]['grandfather'];
            $names[] = $vl[0]['grandfather_mother'];
        }
        
        $names = array_filter(array_unique($names));
        
        $selLanguage = 'english';
        $lang = 'english_text';
        if ($this->Session->check('Website.language')) {
            $selLanguage = $this->Session->read('Website.language');
            if ($selLanguage == 'hindi') {
                $lang = 'hindi_text';
            } elseif ($selLanguage == 'gujurati') {
                $lang = 'gujurathi_text';
            } else {
                $lang = 'english_text';
            }
        }        
      
        $getTranslations = $this->People->getTranslations($names, $lang);
        //echo '<pre>';print_r($getDetails);exit;
        $this->set('userId', $userID);
        $this->set('groupId', $id);
        $this->set('roleId', $roleID);
        $this->set('data', $getDetails);
        $this->set('translations', $getTranslations);
    }

    public function buildTreeJson($group_id = false) {

        $this->autoRender = false;
        $this->layout = null;
        $groupId = $this->request->query['gid'] ? $this->request->query['gid'] : $group_id;
        //echo '--token--'.$_REQUEST['token'];

        $token = md5('dsdsdss434dsds332323d34d');
        if ($token1 == $queryToken) {

            $data = $this->People->getFamilyDetails($groupId);
            //check each id exists in other group then get all gamily detials for this group also
            foreach ($data as $key => $value) {
                $groupData[] = $this->PeopleGroup->checkExistsInOtherGroup($groupId, $value['People']['id']);
            }

            foreach ($groupData as $k => $v) {
                if (count($v)) {
                    foreach ($v as $k1 => $v1) {
                        $data1 = $this->People->getFamilyDetails($v1['PeopleGroup']['group_id'], false, false, true);
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


                    $children = $this->People->getChildren($peopleData['id'], $peopleData['gender'], $groupId);
                    $childids = array();
                    foreach ($children as $k => $v) {
                        $childids[] = $v['People']['id'];
                    }
                    $originalPId = $peopleData['id'];
                    $ids[] = $peopleData['id'];
                    if ($peopleGroup['tree_level'] == "" && $treelevel == 0) {
                        $rootId = $peopleGroup['people_id'];
                        $peopleData['id'] = 'START';
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
                    if ($peopleGroup['tree_level'] != '') {
                        if ($peopleData['f_id'] == $rootId) {
                            $tree[$peopleData['id']]['f'] = 'START';
                        } else {
                            $tree[$peopleData['id']]['f'] = $peopleData['f_id'];
                        }
                    } else {
                        $tree[$peopleData['id']]['f'] = $peopleData['f_id'];
                    }

                    $tree[$peopleData['id']]['m'] = $peopleData['m_id'];
                    $peopleId = $peopleGroup['people_id'];

                    if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/people_images/' . $peopleId . '.' . $peopleData['ext']) === true) {
                        $tree[$peopleData['id']]['r'] = $peopleId . '.' . $peopleData['ext'];
                    } else {
                        $tree[$peopleData['id']]['r'] = '';
                    }
                    $tree[$peopleData['id']]['fg'] = true;
                    $tree[$peopleData['id']]['g'] = $peopleData['gender'] == 'Male' ? 'm' : 'f';
                    $tree[$peopleData['id']]['hp'] = true;
                    $tree[$peopleData['id']]['i'] = $peopleData['id'];
                    $tree[$peopleData['id']]['l'] = $peopleData['last_name'];
                    $tree[$peopleData['id']]['p'] = ucfirst($peopleData['first_name']);
                    $tree[$peopleData['id']]['dob'] = date("d/m/Y", strtotime($peopleData['date_of_birth']));
                    $tree[$peopleData['id']]['education'] = $this->PeopleEducation->getHighestQualification($peopleData['id']);
                    $tree[$peopleData['id']]['village'] = ucfirst($peopleData['village']);
                    $tree[$peopleData['id']]['father'] = ucfirst($peopleData['father']);
                    $tree[$peopleData['id']]['mother'] = ucfirst($peopleData['mother']);
                    if ($peopleData['gender'] == 'Male') {
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
                    $tree[$peopleData['id']]['date_of_marriage'] = date("d/m/Y", strtotime($peopleData['date_of_marriage']));
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
                            $tree[$peopleData['id']]['es'] = 'START';
                            $tree[$peopleData['id']]['s'] = 'START';
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
        } else {
            echo json_encode(array('message' => 'Bad Request'));
            exit;
        }
    }
    
    public function buildFamilyJson () {
        $id = $_REQUEST['id'];        
        $id = (int) str_replace('?', '',$id);
        
        $tree = array();
        $ids = array();
        
        $data = $this->People->getPeopleDetail ($id);
        
        $allIds = array();
        $childrens = array();
        $rootId = $id;
        
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
                $ids[] = $value['people']['id'];
            }
        }
        
      
        $tree['START'] = $this->formatTree($peopleRootData, $peopleRootGroup, $exSpousesRoot, $rootId, $childrens, $allIds, $addressData);      

      
        foreach ($data as $key => $value) {
            $peopleData = $value['people'];
            $peopleGroup = $value['people_groups'];
            $addressData = $value['ad'];
            $exSpouses = array_unique($value[0]);

            if (!in_array($peopleData['id'], $ids) && $peopleData['id'] != $rootId) {
                $ids[] = $peopleData['id'];
                $tree[$peopleData['id']] = $this->formatTree($peopleData, $peopleGroup, $exSpouses, $rootId, $childrens, $allIds, $addressData);
            }
        }

        $jsonData['tree'] = $tree;
        $jsonData['parent_name'] = $peopleRootData['first_name'] . ' ' . $peopleRootData['last_name'];
        $jsonData['count'] = count($tree);
        
        echo json_encode($jsonData);
        exit;
    }
    
    public function formatTree($peopleData, $peopleGroup, $exSpouses, $rootId, $childrens, $allIds, $addressData) {
        //print_r($peopleData);
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

        if ($peopleData['f_id'] == $rootId) {
            $tree['f'] = 'START';
        } else {
            $fid = $peopleData['f_id'];
            $tree['f'] = (!in_array($fid, $allIds)) ? null : $fid;
        }
        
        if ($peopleData['m_id'] == $rootId) {
            $tree['m'] = 'START';
        } else {
            $mid = ($peopleData['m_id']) ? $peopleData['m_id'] : null;
            $tree['m'] = (!in_array($mid, $allIds)) ? null : $mid;
        }

        $peopleId = $peopleData['id'];
        
        if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/people_images/' . $peopleId . '.' . $peopleData['ext']) === true) {
            $tree['r'] = $peopleData['id'];
        } else {
            $tree['r'] = '';
        }
        $tree['fg'] = true;
        $tree['g'] = $peopleData['gender'] == 'Male' ? 'm' : 'f';
        $tree['hp'] = true;
        $tree['i'] = $peopleData['id'];
        $tree['l'] = $peopleData['last_name'];
        $tree['p'] = $peopleData['first_name'];
        $tree['dob'] = $peopleData['date_of_birth'] != '' ? date("d/m/Y", strtotime($peopleData['date_of_birth'])) : '';
        $tree['education'] = $this->PeopleEducation->getHighestQualification($peopleData['id']);
        $tree['village'] = ucfirst($peopleData['village']);
        $tree['father'] = ucfirst($peopleData['father']);
        $tree['mother'] = ucfirst($peopleData['mother']);
        if ( $peopleData['gender'] == 'Male') {
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
        $tree['date_of_marriage'] = $peopleData['date_of_marriage'] != ''?  date("d/m/Y", strtotime($peopleData['date_of_marriage'])) : '';
        $tree['email'] = $peopleData['email'];
        $tree['pid'] = $iId;
        $tree['gid'] = $peopleData['group_id'];
        $tree['father'] = ucfirst($peopleData['father']);
        $tree['city'] = ucfirst($addressData['city']);

        $tree['suburb'] = $addressData['suburb'];
        $tree['suburb_zone'] = ucfirst($addressData['suburb_zone']);

        $tree['k'] = null;

        if ($peopleData['partner_id'] == $rootId) {

            if ($peopleData['partner_id'] != '') {
                $tree['pc'] = array(
                    'START' => true
                );
                $tree['es'] = 'START';
                $tree['s'] = 'START';
            }
        } else if ($peopleData['partner_id'] != '') {
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

    function getPeopleData() {
        $this->autoRender = false;
        $this->layout = null;
        $id = $this->request->query("id");
        $groupId = $this->Session->read('User.group_id');

        $data = $this->People->getFamilyDetails(false, $id, true);
        
        $data[0]['People']['education_1'] = $this->PeopleEducation->getHighestQualification($id);

        echo json_encode($data[0]);
        exit;
    }

    public function deleteMember() {
        if (!$this->Session->read('Auth.User')) {
            exit;
        }
        $this->autoRender = false;
        $this->layout = 'ajax';
        $id = $_REQUEST['id'];
        $groupId = $_REQUEST['groupid'];
        if ($this->People->delete(array('id' => $id)) &&
                $this->PeopleGroup->deleteAll(array('people_id' => $id))) {

            $this->People->updateAfterDeletion($id);
            $msg['success'] = 1;
            $msg['message'] = 'Member has been deleted';
        } else {
            $msg['success'] = 0;
            $msg['message'] = 'System Error, Please try again';
        }

        $this->set(compact('msg'));
        $this->render("/Elements/json_messages");
    }

    public function addBusiness() {
        if (!$this->Session->read('Auth.User')) {
            exit;
        }
        //get all states from master
        $states = $this->State->find('list', array('fields' => array('State.name', 'State.name')));
        $this->set(compact('states'));
        $pid = $_REQUEST['id'];
        $this->set('peopleid', $pid);
        $aid = $_REQUEST['aid'];
        $gid = $_REQUEST['gid'];
        //get all suburbs from msaters
        $suburbs = $this->Suburb->find('list', array('fields' => array('Suburb.name', 'Suburb.name')));
        $this->set(compact('suburbs'));
        
        $businessNatures = $this->BusinessNature->find('list', array('fields' => array('BusinessNature.id', 'BusinessNature.name')));
        $this->set(compact('businessNatures'));
        
        $businessTypes = $this->BusinessType->find('list', array('fields' => array('BusinessType.id', 'BusinessType.name')));
        
        $this->set(compact('businessTypes'));
        
        $array = array();
        $array['gid'] = $gid;

        $getOwnerDetails = $this->People->getParentPeopleDetails($array);
        $data = $this->People->getFamilyDetails($gid, $pid);
        $getBusniessIds = $this->People->getBusniessIds($gid, $pid);
        $this->set('busniessIds', $getBusniessIds);

        $peopleData = $data[0]['People'];
        $groupData = $data[0]['Group'];
//         echo '<pre>';
//        print_r($data);
//        exit;
        $this->set('isHOF', $peopleData['tree_level']);
        $this->set('memberName', $peopleData['first_name'] . ' ' . $peopleData['last_name']);
        $this->set('busniessID', $peopleData['business_address_id']);
        $this->set('isSetHomeAddress', $peopleData['address_id']);
        $this->set('show', $groupData['tree_level'] == "" ? false : true);
        $this->set('occupation', $peopleData['occupation'] ? $peopleData['occupation'] : '');
        $this->set('business_name', $peopleData['business_name']);
        $this->set('isSameChecked', $peopleData['address_id'] == $peopleData['business_address_id'] ? true : false);
        $this->set('specialty_business_service', $peopleData['specialty_business_service']);
        $this->set('nature_of_business', $peopleData['nature_of_business']);
        $getParentAddress = $this->Address->find('all', array(
            'conditions' => array(
                'Address.id' => $aid
            )
                )
        );

        if (isset($getParentAddress[0]) && count($getParentAddress)) {
            $data = $getParentAddress[0]['Address'];
            foreach ($data as $key => $value) {
                $this->set($key, $value);
            }
        }

        $this->set('peopleid', $pid);
        $this->set('aid', $aid ? $aid : '');
        $this->set('gid', $gid ? $gid : '');
        $this->set('name', $getOwnerDetails['first_name']);
        $this->set('parentid', $getOwnerDetails['id']);
        $this->set('parentaddressid', $getOwnerDetails['business_address_id']);
    }
    
    public function addEducation() {
        
        $pid = $_REQUEST['id'];
        $this->set('peopleId', $pid);
        $gid = $_REQUEST['gid'];
        $this->set('groupId', $gid);
        
        //process form
        if ($this->request->is('post') && $this->request->data['PeopleEducation']['name']) {
            $this->layout = 'ajax';
            $this->autoRender = false;
            
            $rdata = $this->request->data;
            if ($this->PeopleEducation->save($rdata)) {
                $msg['success'] = 1;
                $msg['message'] = 'Education has been saved';
                if ($this->request->data['PeopleEducation']['id'] != '') {
                    $msg['message'] = 'Education has been updated';
                }
            } else {
                $msg['success'] = 0;
                $msg['message'] = 'System Error, Please try again';
            }
            $this->set(compact('msg'));
            $this->render("/Elements/json_messages");
        }
        
        // get states master list
        $degrees = $this->Education->find('list', array('fields' => array('Education.name', 'Education.name')));
        $this->set(compact('degrees'));
        
        $data = $this->People->getPeopleName($pid); 
   
        $this->set('peopleName', $data['people']['first_name'].' '.$data['people']['last_name']);
    }
    
    public function deleteEducation()
    {
        $this->autoRender = false;
        $id = $_REQUEST['id'];    
        
        if ($this->PeopleEducation->delete(array('id' =>$id)) ) {
            $msg['success'] = 1;
            $msg['message'] = 'Education has been deleted';
        } else {
            $msg['success'] = 0;
            $msg['message'] = 'System Error, Please try again';
        }
        
        $this->set(compact('msg'));
        $this->render("/Elements/json_messages");
    }
    
    public function getAjaxEducationData()
    {
        $this->autoRender = false;        
   
        $data = $this->PeopleEducation->getPeopleEducations($_REQUEST['people_id']);
        $pdata = array();
        foreach ($data as $key => $val) {
            $fdata = array();
            
            $fdata[] = ($val['people_educations']['name']) ? $val['people_educations']['name'] : '';
            $fdata[] = ($val['people_educations']['institution_name']) ? $val['people_educations']['institution_name'] : '';
            $fdata[] = ($val['people_educations']['university_name']) ? $val['people_educations']['university_name'] : '';
            $fdata[] = ($val['people_educations']['area_specialization']) ? $val['people_educations']['area_specialization'] : '';
            $fdata[] = ($val['people_educations']['year_of_passing']) ? $val['people_educations']['year_of_passing'] : '';
            $fdata[] = ($val['people_educations']['percentage']) ? $val['people_educations']['percentage'] : '';
            $fdata[] = ($val['people_educations']['part_full_time']) ? $val['people_educations']['part_full_time'] : '';
            $fdata[] = $val['people_educations']['id'];
            $fdata[] = $val['people_educations']['people_id'];
            
            $pdata[] = $fdata;
        }
        
        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => count($pdata),
            "iTotalDisplayRecords" => count($pdata),
            "aaData" => $pdata
        );
        echo json_encode($output);
    }

    public function makeHOF() {
        if (!$this->Session->read('Auth.User')) {
            exit;
        }
        $this->autoRender = false;
        $this->layout = 'ajax';
        $id = $this->request->data['id'];
        $hofId = $this->request->data['hofid'];
        $gid = $this->request->data['gid'];
        $result = $this->People->makeHof($id, $hofId, $gid);
        if ($result) {
            $msg['status'] = 1;
            $message = 'New HOF has been saved';
        } else {
            $msg['status'] = 0;
            $message = 'System Error';
        }
        $msg['message'] = $message;
        $this->set(compact('msg'));
        $this->render("/Elements/json_messages");
    }

    public function doProcessAddBusiness() {
        if (!$this->Session->read('Auth.User')) {
            exit;
        }
        $this->autoRender = false;
        $this->layout = 'ajax';
        $peopleId = $_REQUEST['peopleid'];
        $aid = $_REQUEST['addressid'];
        $same = $this->request->data['Address']['is_same'];
        $updatePeopleBusniessDetails = array();
         
        if ($this->request->data['Address']['business_nature'] != '') {
            $businessNatureName = $this->BusinessNature->find('all',array('fields' => array('BusinessNature.name'),
                        'conditions' => array('BusinessNature.id' => $this->request->data['Address']['business_nature'])));
         
            $updatePeopleBusniessDetails['nature_of_business'] = $businessNatureName[0]['BusinessNature']['name'];
        }
        
        
        
        if ($this->request->data['Address']['business_name'] != '') {
            $businessTypeName = $this->BusinessType->find('all',array('fields' => array('BusinessType.name'),
                        'conditions' => array('BusinessType.id' => $this->request->data['Address']['business_name'])));
            $updatePeopleBusniessDetails['business_name'] = $businessTypeName[0]['BusinessType']['name'] ? $businessTypeName[0]['BusinessType']['name'] : 'Other' ;
        }
        $updatePeopleBusniessDetails['id'] = $peopleId;
        $updatePeopleBusniessDetails['occupation'] = $this->request->data['occupation'];
        
        $updatePeopleBusniessDetails['specialty_business_service'] = $this->request->data['Address']['specialty_business_service'];
         $updatePeopleBusniessDetails['other_business_type'] = $this->request->data['Address']['other_business_type'];
        $updatePeopleBusniessDetails['name_of_business'] = $this->request->data['Address']['name_of_business'];
        $this->People->updateBusinessDetails($updatePeopleBusniessDetails);
        $occupation = array('House Wife', 'Retired', 'Studying', 'Other');

        if (!in_array($this->request->data['occupation'], $occupation)) {
            $parentId = $_REQUEST['parentid'];
            $paddressid = $_REQUEST['paddressid'];
            if ($this->request->data['Address']['address_grp1'] == 'is_same') {
                $conditions = array('People.id' => $peopleId);
                $fields = array('People.address_id');
                $getHomeAddressid = $this->People->find('all', array('fields' => $fields, 'conditions' => $conditions));
                $msg['status'] = 1;
                $addressId = $this->Address->id;
                $updatePeople = array();
                $updatePeople['People']['business_address_id'] = $getHomeAddressid[0]['People']['address_id'];
                $updatePeople['People']['id'] = $_REQUEST['peopleid'];
                $this->People->save($updatePeople);
                $message = 'Information has been saved';
            } else if (isset($this->request->data['Address']['address_grp1']) && $this->request->data['Address']['address_grp1'] != 'other') {
                $updatePeople = array();
                $updatePeople['People']['business_address_id'] = $this->request->data['Address']['address_grp1'];
                $updatePeople['People']['id'] = $_REQUEST['peopleid'];
                $this->People->save($updatePeople);
                $message = 'Information has been saved';
                $msg['status'] = 1;
            } else if ($this->request->data['Address']['address_grp1'] == 'other') {
                $getParentAddress = $this->Address->find('all', array(
                    'conditions' => array(
                        'Address.people_id' => $peopleId,
                        'Address.id' => $aid
                    )
                        )
                );

                $getBusniessIds = $this->People->getBusniessIds($_REQUEST['gid'], $peopleId);
                $ids = array();
                foreach ($getBusniessIds as $key => $value) {
                    $ids[] = $value['People']['business_address_id'];
                }
                if ($this->request->data['Address']['address_grp1'] == 'other' && !in_array($aid, $ids)) {
                    $this->request->data['Address']['id'] = $aid;
                }

                $this->request->data['Address']['people_id'] = $_REQUEST['peopleid'];
                $this->request->data['Address']['suburb_zone'] = $this->request->data['suburb_zone'];
                if ($this->Address->save($this->request->data)) {
                    $msg['status'] = 1;
                    $addressId = $this->Address->id;
                    $updatePeople = array();
                    $updatePeople['People']['business_address_id'] = $addressId;
                    $updatePeople['People']['id'] = $peopleId;

                    $this->People->save($updatePeople);
                    $message = 'Information has been saved';
                }
            }
        } else {
            $msg['status'] = 1;
            $message = 'Information has been saved';
        }
        if ($msg['status'] == 1) {
            $msg['success'] = 1;
            $msg['message'] = $message;
        } else {
            $msg['success'] = 0;
            $msg['message'] = 'System Error, Please try again';
        }

        $this->set(compact('msg'));
        $this->render("/Elements/json_messages");
    }

    public function addAddress() {
        if (!$this->Session->read('Auth.User')) {
            exit;
        }
        $userID = $this->Session->read('User.user_id');// read session user id
        // get states master list
        $states = $this->State->find('list', array('fields' => array('State.name', 'State.name')));
        $this->set(compact('states'));

        $suburbs = $this->Suburb->find('list', array('fields' => array('Suburb.name', 'Suburb.name')));
        $this->set(compact('suburbs'));

        $pid = $_REQUEST['id'];
        $aid = $_REQUEST['aid'];
        $gid = $_REQUEST['gid'];
        $getParentAddress = $this->Address->find('all', array(
            'conditions' => array(
                'Address.id' => $aid
            )
                )
        );

        $array = array();
        $array['gid'] = $gid;
        $array['pid'] = $pid;
        // get owners details
        $getOwnerDetails = $this->People->getParentPeopleDetails($array, true);
        $data = $this->People->getFamilyDetails($gid, $pid);
        $groupData = $data[0]['Group'];
        $this->set('show', $groupData['tree_level'] == "" ? false : true);
        if (isset($getParentAddress[0]) && count($getParentAddress)) {
            $data = $getParentAddress[0]['Address'];
            foreach ($data as $key => $value) {
                $this->set($key, $value);
            }
        }
        $this->set('peopleid', $pid);
        $this->set('name', $getOwnerDetails['first_name']);
        $this->set('parentid', $getOwnerDetails['id']);
        $this->set('parentaid', $getOwnerDetails['address_id']);
        $this->set('aid', $aid ? $aid : '');
        $this->set('gid', $gid ? $gid : '');
    }

    public function doProcessAddress() {
        if (!$this->Session->read('Auth.User')) {
            exit;
        }
        $this->autoRender = false;
        $this->layout = 'ajax';
        $same = $this->request->data['Address']['is_same'];
        $parentId = $_REQUEST['parentid'];

        if ($same == 1) {
            $conditions = array('Address.people_id' => $parentId);
            $getParentAddress = $this->Address->find('all', array('conditions' => $conditions));
            $msg['status'] = 1;
            $updatePeople = array();
            $updatePeople['People']['address_id'] = $getParentAddress[0]['Address']['id'];
            $updatePeople['People']['id'] = $_REQUEST['peopleid'];
            $this->People->save($updatePeople);
            $message = 'Information has been saved';

//            unset($getParentAddress[0]['Address']['id']);
//            unset($getParentAddress[0]['Address']['people_id']);
//            $getParentAddress[0]['Address']['created'] = date('Y-m-d H:i:s');
//            $getParentAddress[0]['Address']['people_id'] = $_REQUEST['peopleid'];
//            
//            $this->request->data = $getParentAddress[0];
//            if ($this->Address->save($this->request->data)) {
//                $msg['status'] = 1;
//                $addressId = $this->Address->id;
//                $updatePeople = array();
//                $updatePeople['People']['address_id'] = $addressId;
//                $updatePeople['People']['id'] = $getParentAddress[0]['Address']['id'];
//                $this->People->save($updatePeople);
//                $message = 'Information has been saved';
//            }            
        } else {

            $peopleId = $_REQUEST['peopleid'];
            $getParentAddress = $this->Address->find('all', array(
                'conditions' => array(
                    'Address.people_id' => $peopleId)
                    )
            );
            $this->request->data['Address']['user_id'] = $this->Session->read('User.user_id');
            $this->request->data['Address']['ownership_type'] = $_REQUEST['ownership_type'];
            $this->request->data['Address']['people_id'] = $_REQUEST['peopleid'];
            $this->request->data['Address']['created'] = date('Y-m-d H:i:s');
            $this->request->data['Address']['suburb_zone'] = $_REQUEST['suburb_zone'];

            if (isset($getParentAddress[0]) && count($getParentAddress)) {
                $this->request->data['Address']['id'] = $getParentAddress[0]['Address']['id'];
            }

            $this->request->data['Address']['user_id'] = $this->Session->read('User.user_id');
            $this->request->data['Address']['ownership_type'] = $_REQUEST['ownership_type'];

            $this->request->data['Address']['created'] = date('Y-m-d H:i:s');


            if ($this->Address->save($this->request->data)) {
                $msg['status'] = 1;
                $addressId = $this->Address->id;
                $updatePeople = array();
                $updatePeople['People']['address_id'] = $addressId;
                $updatePeople['People']['id'] = $peopleId;
                $this->People->save($updatePeople);
                $message = 'Information has been saved';
            }
        }

        if ($msg['status'] == 1) {
            $msg['success'] = 1;
            $msg['message'] = $message;
        } else {
            $msg['success'] = 0;
            $msg['message'] = 'System Error, Please try again';
        }

        $this->set(compact('msg'));
        $this->render("/Elements/json_messages");
    }

    public function getZipCodesData() {
        $this->autoRender = false;
        $this->layout = 'ajax';
        $term = $_GET["term"];
        $list = $this->ZipCode->getZipCodesData($term);
        // echo '<pre>';
        //    print_r($list);
        $lists = array();
        foreach ($list as $key => $value) {
            $row['value'] = $value['ZipCode']['zip_code'];
            $row['id'] = (int) $value['ZipCode']['id'];
            ;
            $row_set[] = $row; //build an array
        }
        echo json_encode($row_set);
        exit;
    }

    public function populateZipCodeData() {
        $this->autoRender = false;
        $this->layout = 'ajax';
        $zipcode = $_REQUEST["zipcode"];
        $data = $this->ZipCode->getZipCodesData($zipcode, true);
        $array = array();
        $array['city'] = $data[0]['ZipCode']['city'];
        $array['state'] = $data[0]['ZipCode']['state'];
        $array['suburb'] = $data[0]['ZipCode']['suburb'];
        $array['zone'] = strtolower($data[0]['ZipCode']['zone']);
        $array['std'] = $data[0]['ZipCode']['std'];
        echo json_encode($array);
        exit;
    }
    
    public function searchPeople() {
        $userID = $this->Session->read('User.user_id');

        $this->set('type', $_REQUEST['type']);
        $this->set('fid', $_REQUEST['fid']);
        $this->set('gid', $_REQUEST['gid']);
        $villages = $this->Village->find('list', array('fields' => array('Village.name', 'Village.name')));
        $this->set(compact('villages'));

        
         $main_surnames = $this->Surname->find('list', array('fields' => array('Surname.name', 'Surname.name')));
        $this->set(compact('main_surnames'));
        $this->set('name_parent', $_REQUEST['name_parent']);
    }
    
    public function getBusinessTypes()
    {
        $this->autoRender = false;
        $this->layout = 'ajax';
        $data = $this->BusinessType->find('list',array('fields' => 
                    array('BusinessType.id','BusinessType.name'),
            'conditions' => array('BusinessType.business_nature_id' => $_REQUEST['id'])));
        $data['other'] = 'Other';
        echo json_encode($data);
        exit;
        
        
    }
    
    public function getPeople()
    {
        $this->autoRender = false;
        $this->layout = 'ajax';
        $term = $_GET["term"];
        $list = $this->People->searchUser($term);
       
        $lists = array();
        foreach ($list as $key => $value) {
            if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/people_images/' . $value['People']['id'] . '.' . $value['People']['ext']) === true) {
                $pic = '<img  src="' . $this->base . '/people_images/' . $value['People']['id'] . '.' . $value['People']['ext'] . '" width="35" height="35">';
            } else {
                $pic = '<img  src="http://placehold.it/35x35">';
            }
            $row['label'] = $pic.'&nbsp;'.$value[0]['name'];
            $row['value'] = $value[0]['name'];
            $row['id'] = (int) $value['People']['id'];
            
            $row_set[] = $row; //build an array
        }
        echo json_encode($row_set);
        exit;
    }
    
    public function getPeopleName()
    {
        $this->autoRender = false;
        $this->layout = null;
        $userId = $this->request->query['user_id'] ? $this->request->query['user_id'] : md5(1);
        
        $data = $this->People->getPeopleName($userId, true);
   
        echo $data['people']['first_name'].' '.$data['people']['last_name'];
        exit;
    }
    
    public function insertBrotherData()
    {
        $this->autoRender = false;
        $ids = $this->People->find('list',array('fields' => array('People.id'),'order' => array('People.id asc')));
        foreach( $ids as $v) {
        $options['fields'] = array('People.id', 'p.id', 'p.first_name');
        $options['conditions'] = array('People.id' => $v,'p.gender' => 'Male','People.merged' => 0);
        $options['joins'] = array(
            array('table' => 'people',
                'alias' => 'p',
                'type' => 'left',
                'conditions' => array(
                    'People.f_id = p.f_id'
                )
            ),
        );
         $getData = $this->People->find('all', $options)
                                    ;
         $brotherData = array();
         foreach( $getData as $key => $value) {
             $brotherData[$key]['Brother']['people_id'] = $v;
             $brotherData[$key]['Brother']['brother_id'] = $value['p']['id'];
         }
         
         $this->Brother->saveAll($brotherData);
        }
    }

    public function insertSisterData()
    {
        $this->autoRender = false;
        $ids = $this->People->find('list',array('fields' => array('People.id'),'order' => array('People.id asc')));
        foreach( $ids as $v) {
        $options['fields'] = array('People.id', 'p.id', 'p.first_name');
        $options['conditions'] = array('People.id' => $v,'p.gender' => 'Female','People.merged' => 0);
        $options['joins'] = array(
            array('table' => 'people',
                'alias' => 'p',
                'type' => 'left',
                'conditions' => array(
                    'People.f_id = p.f_id'
                )
            ),
        );
         $getData = $this->People->find('all', $options)
                                    ;
         $brotherData = array();
         foreach( $getData as $key => $value) {
             $brotherData[$key]['Sister']['people_id'] = $v;
             $brotherData[$key]['Sister']['sister_id'] = $value['p']['id'];
         }
         
         $this->Sister->saveAll($brotherData);
        }
    }

}
