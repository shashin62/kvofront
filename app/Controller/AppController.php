<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $components = array(
        'Acl',
        'Auth' => array(
            'userModel' => 'User',
            'authenticate' => array('Form' => array( 'userModel' => 'User',
                                    'fields' => array(
                                                        'username' => 'email',
                                                        'password' => 'password'
                                                        )
                                                )
                            ),
            'authorize' => array('Actions' => array('actionPath' => 'controllers')),
            'loginAction' => array('controller' => 'user', 'action' => 'login'),
            'logoutRedirect' => array('controller' => 'user', 'action' => 'logout'), //logout
            'loginRedirect' => array('controller' => 'user', 'action' => 'welcome'),
            'authError' => 'You are not authorized to view this page',
            'allowedActions' => array('logout','register','doRegisterUser','buildTreeJson',
                'rebuildARO','callAgain','addNote','viewNote'),
//            'authenticate' => array(
//                'all' => array('userModel' => 'User'),
//                'Form' => array(),
//                'Api' => array(),
//            )
        ),
        'Session',
        'Cookie',
        'RequestHandler',
        'Paginator'
    );
    public $helpers = array('Html', 'Form', 'Session');

    public function beforeFilter() {
     // $this->Auth->allow('permissions','update_acos');
    }
}
