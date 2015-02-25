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

    public function uploadimage() {
        $this->autoRender = false;
        $this->layout = 'ajax';
    }

    public function upload() {

        $id = $this->Session->read('User.group_id');
        $getDetails = $this->People->getFamilyDetails($id, false, true);
        $this->set('data', $getDetails);
        if ($this->request->is('post')) {
            $peopleId = $_REQUEST['data']['people_id'];

            $updateExtensions = array();
            $updateExtensions['ext'] = pathinfo($_FILES['data']['name']['photo_id'], PATHINFO_EXTENSION);
            $updateExtensions['id'] = $peopleId;
            $this->People->updateExt($updateExtensions);

            if (!is_uploaded_file($_FILES['data']['tmp_name']['photo_id'])) {
                return FALSE;
            }

            $photo = WWW_ROOT . $this->uploadDir . DS .
                    $peopleId . '.' . pathinfo($_FILES['data']['name']['photo_id'], PATHINFO_EXTENSION);
            //exit;
            if (!move_uploaded_file($_FILES['data']['tmp_name']['photo_id'], $photo)) {
                return FALSE;
                // file successfully uploaded
            } else {
                $this->redirect('family/details/' . $id);
            }
        }
    }

    public function deleteImage() {

        $this->autoRender = false;
        $this->layout = 'ajax';
        if ($this->Session->read('Auth.User')) {
            $id = $this->request->data['id'];
            $getExt = $this->People->getImageExtension($id);
           
            if (unlink(WWW_ROOT . $this->uploadDir . DS . $id . '.' . $getExt['People']['ext'])) {

                $msg['success'] = 1;
                $msg['message'] = 'Photo has been deleted';
            } else {
                $msg['success'] = 0;
                $msg['message'] = 'System Error';
            }
        } else {
            $msg['success'] = 0;
            $msg['message'] = 'Bad Request';
        }
        $this->set(compact('msg'));
        $this->render("/Elements/json_messages");
    }

    //put your code here
}
