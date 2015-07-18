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
            //echo "<pre>"; print_r($imageFile['tmp_name']); exit;
            $d = $image->getImageGeometry();
            $w = $d['width'];
            $h = $d['height'];
            
            $filename = basename($imageFile['name']);
            $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            $destination = WWW_ROOT . $this->uploadDir . DS . $peopleId . "." . $file_ext;
           //echo $destination; exit;
            if( $h > 500 && $w > 500) {
                $image->scaleImage(500, 500);   
            }
            else if( $h > 500 ) {
             $image->scaleImage(0, 500);   
            } else if( $w > 500) {
                $image->scaleImage(500, 0);   
            } 
           
            $image->writeImage($destination);
            $image2 = new Imagick($destination);
            
            
            $msg = $image2->getImageGeometry();
            
            $msg['scaleWidth'] = $scaleWidth;
            $msg['thumb_width'] = $thumb_width;
            $msg['thumb_height'] = $thumb_height;
            $msg['userImagePath'] = $this->base . '/'. $this->uploadDir . DS . $peopleId . "." . $file_ext;
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
        define('UPLOAD_DIR', WWW_ROOT . "people_images". DS);
        $this->autoRender = false;
        $this->layout = 'ajax';
        if ($this->Session->read('Auth.User')) {
            $id = $this->request->data['id'];
            $getExt = $this->People->getImageExtension($id);
            //unlink($_SERVER["DOCUMENT_ROOT"] . '/people_images/'. $id . '.' . $getExt[0]['People']['ext'])
            if (unlink(UPLOAD_DIR . '\\'. $id . '.' . $getExt[0]['People']['ext'])) {

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

     public function imageUpload() {
        $peopleId = $this->request->query('pid');
        define('UPLOAD_DIR', WWW_ROOT . "people_images". DS);
		
        require WWW_ROOT."js/scripts/fineuploader/fineuploader.php";

        $allowedExtensions = array('jpeg','jpg','gif','png');
        $sizeLimit = 2 * 1024 * 1024; // max file size in bytes
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);

        //$result = $uploader->handleUpload(UPLOAD_DIR, false, md5(uniqid())); //handleUpload($uploadDirectory, $replaceOldFile=FALSE, $filename='')
        $result = $uploader->handleUpload(UPLOAD_DIR, false, $peopleId);

        require ROOT . DS . 'lib'. DS ."gd_image.php";
        $gd = new GdImage();

        // step 1: make a copy of the original
        $filePath = UPLOAD_DIR . $result['filename'];
        $copyName = $gd->createName($result['filename'], '_FULLSIZE');
        $gd->copy($filePath, UPLOAD_DIR.$copyName);

        // step 2: Scale down or up this image so it fits in the browser nicely, lets say 500px is safe
        $oldSize = $gd->getProperties($filePath);
        $newSize = $gd->getAspectRatio($oldSize['w'], $oldSize['h'], 500, 0);
        $gd->resize($filePath, $newSize['w'], $newSize['h']);

        // step 3: handled in crop.php!

        // to pass data through iframe you will need to encode all html tags
        echo json_encode($result);exit();
    }
    public function cropUploadedImage() { 

        define('UPLOAD_DIR', WWW_ROOT . "people_images". DS);

        require ROOT . DS . 'lib'. DS ."gd_image.php";
        $gd = new GdImage();
        
       foreach($_POST['imgcrop'] as $k => $v) {
            
            
            // 1) delete resized, move to full size
            $fname = $v['filename'];
            $filePath = UPLOAD_DIR . $v['filename'];
           // $file_ext = pathinfo($filePath, PATHINFO_EXTENSION); 
            $fullSizeFilePath = UPLOAD_DIR . $gd->createName($v['filename'], '_FULLSIZE');
            
            unlink($filePath);
            rename($fullSizeFilePath, $filePath);
    
            // 2) compute the new coordinates
            $scaledSize = $gd->getProperties($filePath);
            $percentChange = $scaledSize['w'] / 500; // we know we scaled by width of 500 in upload
            
            $newCoords = array(
                'x' => $v['x'] * $percentChange,
                'y' => $v['y'] * $percentChange,
                'w' => $v['w'] * $percentChange,
                'h' => $v['h'] * $percentChange
            );
            
            // 3) crop the full size image
            $gd->crop($filePath, $newCoords['x'], $newCoords['y'], $newCoords['w'], $newCoords['h']);

            // 4) resize the cropped image to whatever size we need (lets go with 200 wide)
            $ar = $gd->getAspectRatio($newCoords['w'], $newCoords['h'], 200, 0);

            $gd->resize($filePath, $ar['w'], $ar['h']);
            $file_name = explode('.',$fname);
            $updateExtensions = array();
            $updateExtensions['ext'] = $file_name[1];
            $updateExtensions['id'] = $file_name[0];
            $this->People->updateExt($updateExtensions);
            
        }
        exit;
        //echo "1";
    }
}
