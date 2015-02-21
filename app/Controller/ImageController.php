<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ImageController
 *
 * @author sanil
 */
class ImageController extends Controller {

    public $name = 'Image';
    public $uses = array('User', 'People');
    public $helpers = array('Session');
    public $components = array('Session');
    public $uploadDir = 'people_images';

    public function uploadimage()
    {
         $this->autoRender = false;
        $this->layout = 'ajax';
       
        
    }


    public function upload() {
        
        $id = $this->Session->read('User.group_id');
        $getDetails = $this->People->getFamilyDetails($id, false, true);
        $this->set('data', $getDetails);
        if ($this->request->is('post')) {

            $peopleId = $this->request->data['Image']['people_id'];
            
            $updateExtensions = array();
            $updateExtensions['ext'] = pathinfo($this->request->data['Image']['photo_id']['name'], PATHINFO_EXTENSION);
            $updateExtensions['id'] = $peopleId;
            $this->People->updateExt($updateExtensions);
            
            if (!is_uploaded_file($this->request->data['Image']['photo_id']['tmp_name'])) {
                return FALSE;
            }
           
            $photo = WWW_ROOT . $this->uploadDir . DS .
                    $peopleId . '.' . pathinfo($this->request->data['Image']['photo_id']['name'], PATHINFO_EXTENSION);
            //exit;
            if (!move_uploaded_file($this->request->data['Image']['photo_id']['tmp_name'], $photo)) {
                return FALSE;
                // file successfully uploaded
            }
        }
    }

    //put your code here
}
