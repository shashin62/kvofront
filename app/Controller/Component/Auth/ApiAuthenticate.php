<?php
App::uses('BaseAuthenticate', 'Controller/Component/Auth');

class ApiAuthenticate extends BaseAuthenticate {
    public function authenticate(CakeRequest $request, CakeResponse $response) {
        // Do things for openid here.
        //CakeLog::write('auth', "In API Authenticate");
    }

    public function getUser($request) {        
        $imei = env('HTTP_X_IMEI');
        CakeLog::write('auth', $imei);

        if(empty ($imei)) {
            return false;
        }
        
        return $this->__buildUserData($imei);
    }

    private function __buildUserData($imei) {
        if (Configure::read('project_folder')) {
            $base = '/' . Configure::read('project_folder');
        } else {
            $base = '';
        }

        $userAllData = ClassRegistry::init('UserDevice')->getUserDataUsingIMEI($imei);
        
        /*if($userAllData['CompanyUser']['company_id'] != '' || !empty($userAllData['CompanyUser']['company_id'])) {
            $companyData = ClassRegistry::init('Company')->getCompanyDetails($userAllData['CompanyUser']['company_id']);
            if(!empty ($companyData))
                $userAllData['Company'] = $companyData['Company'];
        }*/
       
        if($userAllData && $userAllData['User']['role_id'] == 1) {

            if(isset($userAllData['UserAccess']['social_id']) && 
                    ($userAllData['UserAccess']['social_id'] == '0' || $userAllData['UserAccess']['access_flag'] != 1)
          ) { 
                ////check if access flag is 0 than dont allow user to login from device (signin error)   
                return false;//Configure::read('signup.resync');
            }
            
            $user['id'] = $userAllData['User']['id'];
            $user['imei'] = $imei;
            
//          $firstName = $userAllData['UserDetail']['first_name'] != '' ? $userAllData['UserDetail']['first_name'] : $userAllData['User']['first_name'];
//          $lastName = $userAllData['UserDetail']['last_name'] != '' ? $userAllData['UserDetail']['last_name'] : $userAllData['User']['last_name'];
//          $userName = $userAllData['UserDetail']['username'] != '' ? $userAllData['UserDetail']['username'] : $userAllData['User']['username'];
             
            $firstName = $userAllData['User']['first_name'];
            $lastName = $userAllData['User']['last_name'];
            $userName = $userAllData['User']['username'];
            
            $user['username'] = $userName;
            $user['first_name'] = $firstName;
            $user['last_name'] = $lastName;
            //$user['department_id'] = !empty($userAllData['User']['department_id']) ? $userAllData['User']['department_id'] : '';
            //$user['company_id'] = !empty($userAllData['Company']['id']) ? $userAllData['Company']['id'] : '';
            $user['role_id'] = !empty($userAllData['User']['role_id']) ? $userAllData['User']['role_id'] : '';
            //$user['role_name'] = !empty($userAllData['Roles']['name'])?$userAllData['Roles']['name']:'';

            $user['user_access_id'] = !empty($userAllData['UserAccess']['social_id']) ? $userAllData['UserAccess']['social_id'] : '';

            $user['user_token'] = !empty($userAllData['UserAccess']['token']) ? $userAllData['UserAccess']['token'] : '';
            $user['device_token'] = !empty($userAllData['UserDevice']['device_token']) ? $userAllData['UserDevice']['device_token'] : '';
            $user['device_type'] = !empty($userAllData['UserDevice']['type']) ? $userAllData['UserDevice']['type'] : '';
            $user['device_density'] = !empty($userAllData['UserDevice']['density']) ? $userAllData['UserDevice']['density'] : '';
            $user['messages_last_seen'] =$userAllData['User']['messages_last_seen'];
            $user['activities_last_seen']=$userAllData['User']['activities_last_seen'];
            $user['brands_last_seen']=$userAllData['User']['brands_last_seen'];
            $user['invited_by']=$userAllData['User']['invited_by'];
            $user['user_provided_city']=$userAllData['UserDetail']['user_provided_city'];
            $user['current_city']=$userAllData['UserDetail']['current_city'];
            $user['hometown_city']=$userAllData['UserDetail']['hometown_city'];
            $user['user_provided_state_code']=$userAllData['UserDetail']['user_provided_state_code'];
            $user['current_state_code']=$userAllData['UserDetail']['current_state_code'];
            $user['hometown_state_code']=$userAllData['UserDetail']['hometown_state_code'];
            $user['hometown_country']=$userAllData['UserDetail']['hometown_country'];
            $user['current_country']=$userAllData['UserDetail']['current_country'];
            $user['user_provided_country']=$userAllData['UserDetail']['user_provided_country'];

            return $user;
        } else {
            return false;
        }
    }
}