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
                        'User', 'Aro', 'Role','Note',
                        'People', 'Village', 'Education', 'State', 'BloodGroup', 
                        'Group','Address','PeopleGroup','Suburb','Surname','Translation',
                        'ZipCode','Spouse'
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
    /**
     * index function - page landing
     */
    public function index() 
    {
        $requestData = $this->request->data;
      $this->set('first_name',isset($this->request->data['first_name']) ? 
                        $this->request->data['first_name'] : '');
                $this->set('last_name',isset($this->request->data['last_name']) ? 
                        $this->request->data['last_name'] : '');
                $this->set('date_of_birth',isset($this->request->data['date_of_birth']) 
                        ? $this->request->data['date_of_birth'] : '');
                $this->set('mobile_number',isset($this->request->data['mobile_number'])  ?
                        $this->request->data['mobile_number'] : '');
                 $this->set('village',isset($this->request->data['village'])  ?
                        $this->request->data['village'] : '');
        
        if ($requestData['type'] == 'self') {
           $userId = $requestData['fid'];//$this->Session->read('User.user_id');
            $toFetchData = true;
            $peopleId = $requestData['fid'];
        } else {
            $userId = '';
            $toFetchData = false;
            $peopleId = $requestData['fid'];
        }
        
        $getPeopleData = $this->People->getPeopleData($peopleId, true ,$_REQUEST['gid']);   
        $array = array();
        $array['gid'] = $_REQUEST['gid'];
        $this->set('main_surname', $getPeopleData['People']['main_surname']);
        $getOwnerDetails = $this->People->getParentPeopleDetails($array);
       
        $this->set('name',$getOwnerDetails['first_name']);
        $this->set('address_id',$getOwnerDetails['address_id']);
        
        // add primary relationships to user- spouse, father, mother and childrens
        switch ($requestData['type']) 
        {   
            case 'addspouse':
                $pageTitle = 'Add Spouse of ' . $_REQUEST['name_parent'];
                // by default set gender, martial status
                //  as spouse is always female and married
                $this->set('gender', 'female');
                $this->set('martial_status', 'Married');
                $this->set('sect','deravasi');
                $this->set('parent_name',$_REQUEST['first_name']);
                $this->set('last_name',$getPeopleData['People']['last_name']);
                // set surname and village to read only mode
                $this->set('village',$getPeopleData['People']['village']);
                $this->set('readonly',true);
                $this->set('main_surname', $getPeopleData['People']['main_surname']);
                $this->set('sect', $getPeopleData['People']['sect']);
                $this->set('date_of_marriage', $getPeopleData['People']['date_of_marriage'] ? date("d/m/Y", strtotime($getPeopleData['People']['date_of_marriage'])): ''  );
                break;
		 case 'addexspouse':
		 $this->set('gender', 'female');
                $this->set('martial_status', 'Married');
                $this->set('sect','deravasi');
                $this->set('parent_name',$_REQUEST['first_name']);
                $this->set('last_name',$getPeopleData['People']['last_name']);
                // set surname and village to read only mode
                $this->set('village',$getPeopleData['People']['village']);
                $this->set('readonly',true);
                $this->set('main_surname', $getPeopleData['People']['main_surname']);
                $this->set('sect', $getPeopleData['People']['sect']);
		break;
            case 'addfather':
                $pageTitle = 'Add Father of ' . $_REQUEST['name_parent'];
                $this->set('gender', 'male');
                $this->set('sect','sthanakvasi');
                $this->set('martial_status', 'Married');
                if ($getPeopleData['People']['tree_level'] == '') {
                    $this->set('readonly',true);
                } else {
                    $this->set('readonly',false);
                }
                $this->set('village',$getPeopleData['People']['village']);
                $this->set('last_name',$getPeopleData['People']['last_name']);
                break;
            case 'addmother':
                $pageTitle = 'Add Mother of ' . $_REQUEST['name_parent'];
                $this->set('sect','deravasi');
                $this->set('gender', 'female');
                $this->set('martial_status', 'Married');
                if ($getPeopleData['People']['tree_level'] == '') {
                    $this->set('readonly',true);
                } else {
                    $this->set('readonly',false);
                }
                
                $this->set('last_name',$getPeopleData['People']['last_name']);
                 $this->set('village',$getPeopleData['People']['village']);
                break;
            case 'addchilld':
                $pageTitle = 'Add Child of ' . $_REQUEST['name_parent'];
                $this->set('readonly',true);
                $this->set('last_name',$getPeopleData['People']['last_name']);
                $this->set('village',$getPeopleData['People']['village']);
				$mothers = $this->People->getAllSpouses($peopleId);
				 $this->set('countm',count($mothers));
				//echo '<pre>';print_r($mothers);exit;
				
				 $this->set(compact('mothers'));
                break;
            case 'addnew':
                $pageTitle = 'Add New Family';
//                $this->set('gender', 'male');
//                $this->set('sect','sthanakvasi');
//                $this->set('martial_status', 'Married');
                
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
            $this->set('readonly',false);
            $this->set('first_name', $getPeopleData['People']['first_name']);
            $this->set('date_of_birth',$getPeopleData['People']['date_of_birth'] ?  date("d/m/Y", strtotime($getPeopleData['People']['date_of_birth'])): '' );
            $this->set('date_of_marriage',$getPeopleData['People']['date_of_marriage'] ?  date("d/m/Y", strtotime($getPeopleData['People']['date_of_marriage'])): '');
            $this->set('date_of_death', $getPeopleData['People']['date_of_death'] ? date("d/m/Y", strtotime($getPeopleData['People']['date_of_death'])): '');
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
            $this->set('education_1', $getPeopleData['People']['education_1']);
            $this->set('education_2', $getPeopleData['People']['education_2']);
            $this->set('education_3', $getPeopleData['People']['education_3']);
            $this->set('education_4', $getPeopleData['People']['education_4']);
            $this->set('education_5', $getPeopleData['People']['education_5']);
            $this->set('year_of_passing_1', $getPeopleData['People']['year_of_passing_1']);
            $this->set('year_of_passing_2', $getPeopleData['People']['year_of_passing_2']);
            $this->set('year_of_passing_3', $getPeopleData['People']['year_of_passing_3']);
            $this->set('year_of_passing_4', $getPeopleData['People']['year_of_passing_4']);
            $this->set('year_of_passing_5', $getPeopleData['People']['year_of_passing_5']);
            $this->set('village', $getPeopleData['People']['village']);
            $this->set('maiden_village', $getPeopleData['People']['maiden_village']);
            $this->set('blood_group', $getPeopleData['People']['blood_group']);
            $this->set('tree_level',$getPeopleData['Group']['tree_level']);
            $this->set('call_again',$getPeopleData['People']['call_again']);
            $this->set('village',$getPeopleData['People']['village']);
            $this->set('mahajan_membership_number', $getPeopleData['People']['mahajan_membership_number']);
             $this->set('same',$getPeopleData['People']['address_id'] == $getOwnerDetails['address_id'] 
                     ? true : false);
           // $getOwnerDetails
        }
    }
    
    

    /**
     *  AJAX Callback - function to edit own details for creating tree
     */
    public function editOwnDetails() 
    {
        $this->layout = 'ajax';
        $this->autoRender = false;
        $userID = $this->Session->read('User.user_id');
        
        $data = $this->request->data['People'];
        
        if ($_REQUEST['peopleid'] != '') {
            $getPeopleDetail = $this->People->find('all', array('fields' => array('People.first_name',
                    'People.last_name', 'People.maiden_surname', 'People.group_id',
                'People.f_id','People.partner_id','People.m_id','People.partner_name','People.village'),
                'conditions' => array('People.id' => $_REQUEST['peopleid']))
            );
        }
      
        $this->request->data['People']['sect'] = $this->request->data['sect'];
        $this->request->data['People']['gender'] = $this->request->data['gender'];
        $this->request->data['People']['martial_status'] = $this->request->data['martial_status'];
       
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
		}  else {
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
				$mothers = $this->People->getAllSpouses($_REQUEST['peopleid']);
				//echo '<pre>';print_r($mothers);exit;
				if ( count ($mothers) > 1) {
					$this->request->data['People']['m_id'] = $_REQUEST['data']['People']['mothers'];
					$this->request->data['People']['mother']  = $mothers[$_REQUEST['data']['People']['mothers']];
				 } else {
					$this->request->data['People']['m_id'] = $getPeopleDetail[0]['People']['partner_id'];
					 $this->request->data['People']['mother']  = $getPeopleDetail[0]['People']['partner_name'];
				 }
                $this->request->data['People']['tree_level'] = $userID == $_REQUEST['peopleid'] ? 'START' : $_REQUEST['peopleid'];
                $this->request->data['People']['group_id'] = $getPeopleDetail[0]['People']['group_id'];
                $this->request->data['People']['f_id'] = $_REQUEST['peopleid'];

                $this->request->data['People']['father']  = $getPeopleDetail[0]['People']['first_name'];
               
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

                    if (!empty($phoneData) && !empty($this->request->data['People']['mobile_number']) && $this->request->data['People']['id'] == '' ) {
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
                 }else {
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

    public function details() 
    {
        $userID = $this->Session->read('User.user_id');        
        $roleID = $this->Session->read('User.role_id');        
        $getOwners = $this->Group->getOwners();
      
        $ownerData = array();
        foreach ( $getOwners as $key => $value ) {
            $ownerData[$value['Group']['id']]['name'] = $value['People']['first_name'] . ' ' . $value['People']['last_name'];
            $ownerData[$value['Group']['id']]['group_id'] = $value['Group']['id'];
            $ownerData[$value['Group']['id']]['id'] = $value['People']['id'];
            $ownerData[$value['Group']['id']]['owner'] = $value['User']['first_name']. ' ' . $value['User']['last_name'];
        }
        
        $this->set('owners',$ownerData);
        $this->set('type',isset($_REQUEST['type']) ? $_REQUEST['type'] : 'english');
        $id = $this->request->params['pass'][0];
        
        if (array_key_exists($id, $ownerData))  {
             $this->set('ownername', $ownerData[$id]['owner']);
        }
        $getDetails = $this->People->getFamilyDetails($id, false, true);
	//echo '<pre>';print_r($getDetails);exit;
        $this->set('userId', $userID);
        $this->set('groupId', $id);
        $this->set('roleId', $roleID);
        $this->set('data', $getDetails);       
    }
   

    public function buildTreeJson() {
        $this->autoRender = false;
        $this->layout = null;
        $groupId = $_REQUEST['gid'];
        $uid = $_REQUEST['uid'];
        $data = $this->People->getFamilyDetails($groupId);
//echo '<pre>';
//print_r($data);exit;
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
	    $exSpouses = $value[0];
            if (!in_array($peopleData['id'],$ids)) {
                
            
            $children = $this->People->getChildren($peopleData['id'], $peopleData['gender'], $groupId);
            $childids = array();
            foreach ($children as $k => $v) {
                $childids[] = $v['People']['id'];
            }
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

            $tree[$peopleData['id']]['fg'] = true;
            $tree[$peopleData['id']]['g'] = $peopleData['gender'] == 'male' ? 'm' : 'f';
            $tree[$peopleData['id']]['hp'] = true;
            $tree[$peopleData['id']]['i'] = $peopleData['id'];
            $tree[$peopleData['id']]['l'] = $peopleData['last_name'];
            $tree[$peopleData['id']]['p'] = $peopleData['first_name'];

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
            if( $exSpouses['exspouses'] != '') {
                    foreach ( explode(',', $exSpouses['exspouses']) as $eKey => $eValue) {
                        $tree[$peopleData['id']]['ep'][$eValue] = "1";
                        $tree[$peopleData['id']]['pc'][$eValue] = true;
                    }
                }
                $tree[$peopleData['id']]['q'] = $peopleData['maiden_surname'];
            }
              }
        //     echo '<pre>';
        //print_r($tree);exit;
        $jsonData['tree'] = $tree;
        $jsonData['parent_name'] = $parentName;
 
        echo json_encode($jsonData);
        exit;
    }

}