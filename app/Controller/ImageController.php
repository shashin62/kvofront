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

    public $thumb_width = 346;

    /**
     * default thumb width ( company logo crop)
     * @var type 
     */
    public $thumb_height = 346;
    public $name = 'Image';
    public $uses = array('User', 'People');
    public $helpers = array('Session');
    public $components = array('Session');
    public $uploadDir = 'people_images';

    public function uploadimage() {

        $this->layout = 'ajax';
        $this->autoRender = false;
        $thumb_width = $this->thumb_width;
        $thumb_height = $this->thumb_height;
        $scaleWidth = 720;
        
        $peopleId = $this->request->query('pid');//$_REQUEST['data']['people_id'];
        
        if (isset($this->request->params['form'])) {
            $imageFile = $this->request->params['form']['image'];
            $image = new Imagick($imageFile['tmp_name']);
            $d = $image->getImageGeometry();
            $w = $d['width'];
            $h = $d['height'];
            
            $filename = basename($imageFile['name']);
            $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            $destination = WWW_ROOT . $this->uploadDir . DS . $peopleId . "." . $file_ext;
            
            if( $h > 500 ) {
             $image->scaleImage(0, 500);   
            } else if( $w > 500) {
                $image->scaleImage(500, 0);   
            } else if( $h > 500 && $w > 500) {
                $image->scaleImage(500, 500);   
            }
           
            $image->writeImage($destination);
            $image2 = new Imagick($destination);
            
            
            $msg = $image2->getImageGeometry();
            
            $msg['scaleWidth'] = $scaleWidth;
            $msg['thumb_width'] = $thumb_width;
            $msg['thumb_height'] = $thumb_height;
            $msg['userImagePath'] = 'app/webroot/' . '/'. $this->uploadDir . DS . $peopleId . "." . $file_ext;
            $msg['success'] = 1;
           $this->set(compact('msg'));
            $this->render("/Elements/json_messages");
        } else {
            $this->set('thumb_width', $thumb_width);
            $this->set('thumb_height', $thumb_height);
            $this->render('/Elements/upload');
        }
    }
     public function cropImage()
    {
         $peopleId = $this->request->query('pid');
         $this->set('pid',$peopleId);
         $this->render('/Elements/add_media');
    }
    
    public function resizeImage()
    {
         $this->layout = 'ajax';
        $this->autoRender = false;
       
        $x1 = $this->request->data["x1"];
        $y1 = $this->request->data["y1"];
        $w = $this->request->data["w"];
        $h = $this->request->data["h"];
        $large_image_location = $this->base. '/'.  $_REQUEST['userImagePath'];
        $fileExt = explode('.', basename($large_image_location));
        $peopleId =  $this->request->data['id'];
        
        $croppedImage = WWW_ROOT . $this->uploadDir . DS .$peopleId . '.'. $fileExt[1];
        // collect file extension from image path
        // for main image
        $resizeimage1 = new Imagick(WWW_ROOT . $this->uploadDir . DS .$peopleId . '.'.$fileExt[1]);
        $resizeimage1->cropImage($w, $h, $x1, $y1);
        $resizeimage1->scaleImage(120, 120);
        $resizeimage1->writeImage($croppedImage);
        if($resizeimage1->writeImage($croppedImage) ) {
            $msg['status'] = 1;
            $updateExtensions = array();
            $updateExtensions['ext'] = $fileExt[1];
            $updateExtensions['id'] = $peopleId;
            $this->People->updateExt($updateExtensions);
        } else {
            $msg['status'] = 0;
        }
        $this->set(compact('msg'));
        $this->render("/Elements/json_messages");
        

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

                $this->redirect('/family/details/' . $id);

            }
        }
    }

    public function deleteImage() {

        $this->autoRender = false;
        $this->layout = 'ajax';
        if ($this->Session->read('Auth.User')) {
            $id = $this->request->data['id'];
            $getExt = $this->People->getImageExtension($id);
            
            if (unlink($_SERVER["DOCUMENT_ROOT"] . '/people_images/'. $id . '.' . $getExt[0]['People']['ext'])) {

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
}
