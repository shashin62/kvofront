<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

Class UserController extends AppController {

    public $name = 'User';
    public $uses = array('User', 'Aro', 'Role', 'People', 'Group', 'PeopleGroup');
    public $helpers = array('Session');
    public $components = array('Session');

    public function beforeFilter() {
        parent::beforeFilter();
        // $this->Auth->allow(array('add','logout','rebuildARO'));
    }

    public function rebuildARO() {
        // Build the groups.
        $roles = $this->Role->find('all');
        $aro = new Aro();
        foreach ($roles as $role) {
            $aro->create();
            $aro->save(array(
                // 'alias'=>$group['Group']['name'],
                'foreign_key' => $role['Role']['id'],
                'model' => 'Role',
                'parent_id' => null
            ));
        }

        // Build the users.
        $this->User->recursive = -1;
        $users = $this->User->find('all');

        $i = 0;
        foreach ($users as $user) {
            $aroList[$i++] = array(
                // 'alias' => $user['User']['email'],
                'foreign_key' => $user['User']['id'],
                'model' => 'User',
                'parent_id' => $user['User']['role_id']
            );
        }
        foreach ($aroList as $data) {
            $aro->create();
            $aro->save($data);
        }

        echo "AROs rebuilt!";
        exit;
    }

    public function add() {

        $data = array();
        $data['User']['email'] = 'superadmin@kvomahajan.com';
        $data['User']['password'] = $this->generatePassword();
        $data['User']['created'] = gmdate("Y-m-d H:i:s");
        $data['User']['modified'] = gmdate("Y-m-d H:i:s");
        $data['User']['role_id'] = 1;
        echo '<pre>';
        print_r($data);
        $this->User->recursive = -1;
        $this->User->save($data);
        var_dump($this->User->save($data['User']));
        echo "User Created";
        exit;
    }

    private function generatePassword($password_length = "8") {
        srand($this->make_seed());
        // get proper alfa from confiugre
        $alfa = Configure::read("passwordAlfa");
        $token = "";
        for ($i = 0; $i < $password_length; $i++) {
            $token .= $alfa[rand(0, strlen($alfa) - 1)];
        }
        return $token;
    }

    /**
     * generate secret string
     * 
     * @return type 
     */
    private function make_seed() {
        list($usec, $sec) = explode(' ', microtime());
        return (float) $sec + ((float) $usec * 100000);
    }

    public function welcome() {        
        $this->redirect($this->Auth->redirect('/family/details/' . $this->Session->read('User.group_id')));
    }

    public function register() {
        if ($this->request->is('post')) {
        }
    }
    
    public function getUsers() {
    }

    public function getUserAjaxData() {
        $this->autoRender = false;


        $data = $this->User->getAllUsers();
        echo json_encode($data);
    }
    
    public function signup() {
        $this->set('signup', 1);
        $this->render('login');
    }

    public function doRegisterUser() {
        $this->layout = 'ajax';
        $this->autoRender = false;

        $data = $this->request->data;
        $msg['status'] = 1;

        if (isset($this->request->data['mobile_number'])) {
            $phoneData = $this->People->checkPhoneExists($this->request->data['mobile_number']);
        }

        if (!empty($phoneData)) {
            $msg['success'] = 1;
            $msg['message'] = 'Already Registered. Please login to continue editing your family';
        } else {
            $groupData = array();
            $groupData['Group']['name'] = 'Family of ' . $this->request->data['first_name'];
            $groupData['Group']['created'] = date('Y-m-d H:i:s');
            $this->Group->save($groupData);

            $data = array();
            $data['People']['group_id'] = $this->Group->id;
            $data['People']['created_by'] = $this->Session->read('User.user_id');
            $data['People']['created'] = date('Y-m-d H:i:s');
            $data['People']['mobile_number'] = $this->request->data['mobile_number'];
            $data['People']['first_name'] = $this->request->data['first_name'];
            $data['People']['last_name'] = $this->request->data['last_name'];
            $data['People']['village'] = $this->request->data['village'];
            $data['People']['date_of_birth'] = $this->request->data['date_of_birth'];
            $data['People']['email'] = $this->request->data['email'];
            $data['People']['gender'] = 'Male';
            $data['People']['sect'] = 'Deravasi';
            $data['People']['created_by'] = Configure::read('SELF_ID');
            $random_number = mt_rand(10000, 99999);
            $data['People']['pin'] = $random_number;
            if ($this->People->save($data)) {

                $peopleGroup = array();
                $peopleGroup['PeopleGroup']['group_id'] = $this->Group->id;
                $peopleGroup['PeopleGroup']['people_id'] = $this->People->id;
                $this->PeopleGroup->save($peopleGroup);
                $groupData = array();
                $groupData['Group']['people_id'] = $this->People->id;
                $groupData['Group']['id'] = $this->Group->id;

                $this->Group->save($groupData);
                $smsURI = Configure::read('SMS_URI');
                $smsURI .= '?user=' . Configure::read('USERNAME') . '&apikey=' . Configure::read('PASSWORD');
                $smsURI .= '&mobile=' . $this->request->data['mobile_number'] . '&message=' . $random_number. '&type=txt' . '&senderid=Default';
                   
                if (Configure::read('SEND_SMS')) {
                    $curlInt = curl_init($smsURI);
                    curl_setopt($curlInt, CURLOPT_FOLLOWLOCATION, 1);
                    curl_setopt($curlInt, CURLOPT_RETURNTRANSFER, 1);
                    $result = curl_exec($curlInt);
                }
                
                $messageBody = "Dear ".$this->request->data['first_name'].",\n
                        Your password : ".$random_number."\n
                        Regards,\n
                        KVOMahajan Team";
                        
                $Email = new CakeEmail('gmail');
                $Email->to($this->request->data['email']);
                $Email->from('admin@kvomahajan.com');
                $Email->subject('Account Creation for kvomahajan');
                
                $Email->send($messageBody);

                $msg['success'] = 1;
                $msg['message'] = 'Registered succussfully';
            } else {
                $msg['success'] = 0;
                $msg['message'] = 'System Error, Please trye again';
            }
        }

        $this->set(compact('msg'));
        $this->render("/Elements/json_messages");
    }

    public function doResendPin() {
        $this->layout = 'ajax';
        $this->autoRender = false;

        $data = $this->request->data;
        $msg['status'] = 1;

        if (isset($this->request->data['mobile_number']) && $this->request->data['mobile_number'] != '') {
            $phoneData = $this->People->checkPhoneExists($this->request->data['mobile_number']);

            if (empty($phoneData)) {
                $msg['status'] = 0;
                $msg['error']['name'][] = "mobile_number";
                $msg['error']['errormsg'][] = __('This number does not exists in the system');
                $msg['success'] = 1;
            } else {

                if ($msg['status'] == 1) {
                    $random_number = mt_rand(10000, 99999);
                    $data = array();
                    $data['People']['id'] = $phoneData['id'];
                    $data['People']['pin'] = $random_number;
                    if ($this->People->save($data)) {
                        $smsURI = Configure::read('SMS_URI');
                        $smsURI .= '?user=' . Configure::read('USERNAME') . '&apikey=' . Configure::read('PASSWORD');
                        $smsURI .= '&mobile=' . $this->request->data['mobile_number'] . '&message=' . $random_number . '&type=txt' . '&senderid=Default';

                        //if (Configure::read('SEND_SMS')) {
                        $curlInt = curl_init($smsURI);
                        curl_setopt($curlInt, CURLOPT_FOLLOWLOCATION, 1);
                        curl_setopt($curlInt, CURLOPT_RETURNTRANSFER, 1);
                        $result = curl_exec($curlInt);
                        // }

                        $msg['success'] = 1;
                        $msg['message'] = 'Password has been send to your mobile number';
                    }
                }
            }
        } elseif (isset($this->request->data['email_address']) && $this->request->data['email_address'] != '') {
            $emailData = $this->People->checkEmailExists($this->request->data['email_address']);

            if (empty($emailData)) {
                $msg['status'] = 0;
                $msg['error']['name'][] = "email_address";
                $msg['error']['errormsg'][] = __('This email does not exists in the system');
                $msg['success'] = 1;
            } else {

                if ($msg['status'] == 1) {
                    $random_number = mt_rand(10000, 99999);
                    $data = array();
                    $data['People']['id'] = $emailData['id'];
                    $data['People']['pin'] = $random_number;
                    if ($this->People->save($data)) {
                        
                        $messageBody = "Dear ".$emailData['first_name'].",\n
                        Your new password : ".$random_number."\n
                        Regards,\n
                        KVOMahajan Team";
                        
                        $Email = new CakeEmail('gmail');
                        $Email->to($this->request->data['email_address']);
                        $Email->from('admin@kvomahajan.com');
                        $Email->subject('Password reset for kvomahajan');
                        //$Email->message ($messageBody);
                        $Email->send($messageBody);

                        $msg['success'] = 1;
                        $msg['message'] = 'Password has been send to your email address';
                    }
                }
            }
        }

        $this->set(compact('msg'));
        $this->render("/Elements/json_messages");
    }

    public function login() {
        // Disabling the browser cache for this page so that user cannot go back to login page by clicking the back button.
        $this->response->disableCache();

        if ($this->Session->read('User.user_id')) {
            $this->redirect('/');
            exit;
        }
        if ($this->request->is('post')) {
            if ($this->People->validates()) {
                $userAllData = $this->People->getLoginPeopleData($this->request->data['People']['mobile_number'], $this->request->data['People']['password']);

                if ($this->Auth->login($userAllData['People'])) {
                    $cookie['email'] = $userAllData['People']['mobile_number'];
                    //$cookie['password'] = $userAllData['User']['password'];
                    $this->setCakeSession($userAllData);
                    $this->Cookie->write('Auth.User', $cookie, true, '+2 weeks');
                    $this->redirect($this->Auth->redirect('/family/details/' . $userAllData['People']['group_id']));
                }
                $this->Session->setFlash(__('Invalid username or password, try again'), 'default', array(), 'authlogin');
            }
        }
    }

    public function logout() {
        $this->Session->destroy();
        $this->Cookie->delete('Auth.User');
        $this->redirect('/user/login');
    }
    
    public function changepassword() {
        if ($this->request->is('post')) {
            $this->layout = 'ajax';
            $this->autoRender = false;
            
            $msg['status'] = 1;
            
            if ($this->People->checkPin($this->request->data['People']['old_pin'],$this->Session->read('User.user_id'))) {                
                $data['People']['id'] = $this->Session->read('User.user_id');
                $data['People']['pin'] = $this->request->data['People']['pin'];
                if ($this->People->save($data)) {
                    $msg['success'] = 1;
                    $msg['message'] = 'Password has been changed succussfully';
                }
                
            } else {
                $msg['status'] = 0;
                $msg['success'] = 0;
                $msg['message'] = 'Old Password doesn\'t match, try again';
            }
            $this->set(compact('msg'));
            $this->render("/Elements/json_messages");
        }
    }

    public function delete() {
        $this->autoRender = false;
        $id = $_REQUEST['id'];
        $this->User->recursive = -1;
        if ($this->User->delete(array('id' => $id))) {
            $msg['success'] = 1;
            $msg['message'] = 'User has been deleted';
        } else {
            $msg['success'] = 0;
            $msg['message'] = 'System Error, Please try again';
        }
        $this->set(compact('msg'));
        $this->render("/Elements/json_messages");
    }

    /**
     * function to set session data
     * 
     * @param type $userAllData 
     * 
     * @return null
     */
    private function setCakeSession($userAllData = array()) {
        $this->Session->write('User.user_id', $userAllData['People']['id']);
        $this->Session->write('User.first_name', $userAllData['People']['first_name']);
        $this->Session->write('User.last_name', $userAllData['People']['last_name']);
        $this->Session->write('User.group_id', $userAllData['People']['group_id']);
        $this->Session->write('User.email', !empty($userAllData['People']['email']) ? $userAllData['People']['email'] : '');
        $this->Session->write('User.gender', !empty($userAllData['People']['gender']) ? $userAllData['People']['gender'] : '');
        $this->Session->write('User.phone_number', !empty($userAllData['People']['mobile_number']) ? $userAllData['People']['mobile_number'] : '');
        $this->Session->write('User.martial_status', !empty($userAllData['People']['martial_status']) ? $userAllData['People']['martial_status'] : '');
        $this->Session->write('User.surname_now', !empty($userAllData['People']['surname_now']) ? $userAllData['People']['surname_now'] : '');
        $this->Session->write('User.surname_dob', !empty($userAllData['People']['maiden_surname']) ? $userAllData['People']['maiden_surname'] : '');
        $this->Session->write('User.state', !empty($userAllData['People']['state']) ? $userAllData['People']['state'] : '');
        $this->Session->write('User.village', !empty($userAllData['People']['village']) ? $userAllData['People']['village'] : '');
        $this->Session->write('User.education', !empty($userAllData['People']['education']) ? $userAllData['People']['education'] : '');
        $this->Session->write('User.blood_group', !empty($userAllData['People']['blood_group']) ? $userAllData['People']['blood_group'] : '');
    }
}
