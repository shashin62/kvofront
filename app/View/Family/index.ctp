<link href="/js/scripts/jQuery-Impromptu/jquery-impromptu.css" rel="stylesheet" type="text/css" />
<link href="/js/scripts/fineuploader/fineuploader.css" rel="stylesheet" type="text/css" />
<link href="/js/scripts/Jcrop/jquery.Jcrop.min.css" rel="stylesheet" type="text/css" />

<!-- <script type="text/javascript" src="/js/scripts/jquery-1.9.1.min.js"></script> -->
<script type="text/javascript" src="/js/scripts/jQuery-Impromptu/jquery-impromptu.js"></script>
<script type="text/javascript" src="/js/scripts/fineuploader/jquery.fineuploader-3.0.min.js"></script>
<script type="text/javascript" src="/js/scripts/Jcrop/jquery.Jcrop.min.js"></script>
<script type="text/javascript" src="/js/scripts/jquery-uberuploadcropper.js"></script>
<style type="text/css">
   /* .qq-upload-list{display:none};*/
   .jqi{width: 538px !important;}
   .qq-upload-button{background: #969292 !important;border-radius: 5px;}
</style>
<?php
    //echo "<pre>"; print_r($_SERVER); exit;
?>
<div class="container-fluid">
    <div class="panel panel-info">
         <div class="panel-heading"><?php echo $pageTitle;?></div>
         <div class="panel-body">
                <?php echo $this->Form->create('People', array('class' => 'form-horizontal peopleForm', 'id' => 'createFamily', 'name' => 'register')); ?>

                <div class="row">
                        <div class="col-lg-6 col-md-6 col-xs-12">
                                <?php if( $userType == 'addnew' || ($call_again === false || $call_again === true)) { ?>


                                <?php } else { ?>
                    <?php } ?>
                                <?php if(  $userType == 'addchilld'  &&  $countm > 1 ) { ?>
                                <div class="form-group required motherdiv">
                                        <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="mothers">Select Mother</label>
                                        <div class="col-lg-8 col-md-8 col-xs-8">

                                        <?php

                                        echo $this->Form->input('mothers', array('id' => 'mothers',
                                        'label' => false,
                                        'div' => false,
                                        'legend' => false,
                                        'empty' => __d('label', '--Select--'),
                                        'class' => 'mothers',
                                        'style' => '',
                                        //'disabled' => $readonly,
                                        'options' => $mothers

                                        ));
                                        ?>
                                        </div>
                                </div>
                                <?php } ?>
                                <div class="form-group required">
                                        <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="sect">Sect</label>   
                                        <div class="col-lg-8 col-md-8 col-xs-8">
                                                <div class="btn-group " data-toggle="buttons">
                                                        <label class="btn btn-default <?php echo $sect == 'Deravasi' ? 'active' : '';?>">
                                                                <input type="radio" name="sect" <?php echo $sect == 'Deravasi' ? 'checked=checked' : '';?> value="Deravasi">Deravasi
                                                        </label>
                                                        <label class="btn btn-default <?php echo $sect == 'Sthanakvasi' ? 'active' : '';?>">
                                                                <input type="radio" name="sect" <?php echo $sect == 'Sthanakvasi' ? 'checked=checked' : '';?> value="Sthanakvasi">Sthanakvasi
                                                        </label>
                                                        <label class="btn btn-default <?php echo $sect == 'Other' ? 'active' : '';?>">
                                                                <input type="radio" name="sect" <?php echo $sect == 'Other' ? 'checked=checked' : '';?> value="Other">Other
                                                        </label>
                                                </div>
                                        </div>
                                </div>


                                <div class="form-group required">
                                        <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="gender">Gender</label>   
                                        <div class="col-lg-8 col-md-8 col-xs-8">
                                                <div class="btn-group genders" data-toggle="buttons">
                                                        <label class="btn btn-default <?php echo $gender == 'Male' ? 'active' : '';?>">
                                                                <input type="radio" name="gender" class="gender" <?php echo $gender == 'Male' ? 'checked=checked' : '';?> value="Male">Male
                                                        </label>
                                                        <label class="btn btn-default <?php echo $gender == 'Female' ? 'active' : '';?>">
                                                                <input type="radio" name="gender" class="gender" <?php echo $gender == 'Female' ? 'checked=checked' : '';?> value="Female">Female
                                                        </label>
                                                </div>
                                        </div>
                                </div>

                                <div class="form-group required">
                                        <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="first_name">First Name</label>
                                        <div class="col-lg-8 col-md-8 col-xs-8">
                                                <?php echo $this->Form->input('first_name', array('id' => 'first_name', 'value'=> $first_name,'placeholder' => 'Enter First Name' ,'title' => '','div' => false, 'label' => false, 'class' => 'form-control')); ?>
                                        </div>
                                </div>

                                <div class="form-group required">
                                        <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="last_name">Used Surname</label>
                                        <div class="col-lg-8 col-md-8 col-xs-8">
                                        <?php echo $this->Form->input('last_name', array('id' => 'last_name', 'value'=> $last_name,'placeholder' => 'Enter Last Name' ,'title' => '','div' => false, 'label' => false, 'class' => 'form-control')); ?>
                                        </div>
                                </div>

                                <div class="form-group required main_surnamediv">
                                        <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="main_surname">Main Surname</label>
                                        <div class="col-lg-8 col-md-8 col-xs-8">

                                        <?php

                                        echo $this->Form->input('main_surname', array('id' => 'main_surname',
                                        'label' => false,
                                        'div' => false,
                                        'legend' => false,
                                        'empty' => __d('label', '--Select--'),
                                        'class' => 'main_surname combobox',
                                        'style' => '',
                                        //'disabled' => $readonly,
                                        'options' => $main_surnames,
                                        'value' => $main_surname

                                        ));
                                        ?>
                                        </div>
                                </div>

                                <div class="form-group villagediv">
                                        <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="vsillage">Village</label>
                                        <div class="col-lg-8 col-md-8 col-xs-8">

                                        <?php

                                        echo $this->Form->input('village', array('id' => 'village',
                                        'label' => false,
                                        'div' => false,
                                        'legend' => false,
                                        'empty' => __d('label', '--Select--'),
                                        'class' => 'village combobox',
                                        'style' => '',
                                        'disabled' => $readonly,
                                        'options' => $villages,
                                        'value' => $village
                                        ));
                                        ?>
                                        </div>
                                </div>

                                <div class="form-group">
                                        <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="email">Email ID</label>
                                        <div class="col-lg-8 col-md-8 col-xs-8">
                                                <?php echo $this->Form->input('email', array('id' => 'email', 'value'=> $email,'placeholder' => 'Enter Email ID' ,'title' => '','div' => false, 'label' => false, 'class' => 'form-control')); ?>
                                        </div>
                                </div>



                                <div class="form-group required">
                                        <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="martial_status">Marital status</label>   
                                        <div class="col-lg-8 col-md-8 col-xs-8">
                                                <div class="btn-group" data-toggle="buttons">                    
                                                        <label class="btn btn-default <?php echo $martial_status == 'Married' ? 'active' : '';?>">
                                                        <input class="martial_status" type="radio" name="martial_status" <?php echo $martial_status == 'Married' ? 'checked=checked' : '';?> value="Married">Married
                                                        </label>
                                                        <label class="btn btn-default <?php echo $martial_status == 'Divorced' ? 'active' : '';?>">
                                                        <input class="martial_status" type="radio" name="martial_status" <?php echo $martial_status == 'Divorced' ? 'checked=checked' : '';?> value="Divorced">Divorced
                                                        </label>
                                                        <label class="btn btn-default <?php echo $martial_status == 'Separated' ? 'active' : '';?>">
                                                        <input class="martial_status" type="radio" name="martial_status" <?php echo $martial_status == 'Separated' ? 'checked=checked' : '';?> value="Separated">Separated
                                                        </label>
                                                        <label class="btn btn-default <?php echo $martial_status == 'Widow' ? 'active' : '';?>">
                                                        <input class="martial_status" type="radio" name="martial_status" <?php echo $martial_status == 'Widow' ? 'checked=checked' : '';?> value="Widow">Widow
                                                        </label>
                                                        <label class="btn btn-default <?php echo $martial_status == 'Single' ? 'active' : '';?>">
                                                        <input class="martial_status" type="radio" name="martial_status" <?php echo $martial_status == 'Single' ? 'checked=checked' : '';?> value="Single">Single
                                                        </label>
                                                </div>
                                        </div>
                                </div>

                                <div class="form-group"><label class="col-lg-4 col-md-4 col-xs-4 control-label" for="gender">Marraige Date</label>   
                        <div class="col-lg-8 col-md-8 col-xs-8">
                       <?php echo $this->Form->input('date_of_marriage', 
                               array('id' => 'date_of_marriage', 'type' => 'text','value'=> $date_of_marriage,'placeholder' => 'enter in dd/mm/yyyy format' ,'title' => '','div' => false, 'label' => false, 'class' => 'dp form-control')); ?>
                        </div>
                    </div>
                    <?php if ($userType != 'self') { 
                        $family_flag = 'same';
                    ?>
                    <div class="form-group">
                            <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="family_flag">Family</label>
                            <div class="col-lg-8 col-md-8 col-xs-8">
                                    <label>
                                    <input class="family_flag" type="radio" name="family_flag" <?php echo $family_flag == 'same' ? 'checked=checked' : '';?> value="same">Same Family (same as <?php echo $hof;?>)
                                    </label>
                                    <label>
                                    <input class="family_flag" type="radio" name="family_flag" <?php echo $family_flag == 'new' ? 'checked=checked' : '';?> value="new">New Family
                                    </label>
                            </div>
                    </div>
                    <?php } ?>
                </div>

                <div class="col-lg-6 col-md-6 col-xs-12">
                        <div id="forMob" style="position:absolute;width:350px;height:35px;z-index:1;display:none"></div>
                        <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="photo">Photo</label>
                        <div id="UploadImages">
                            <noscript>Please enable javascript to upload and crop images.</noscript>
                        </div>

                        <div id="PhotoPrevs" style="text-align: center;">
                            <?php  if (file_exists($uploadFilePath . '\\' . $pid . '.' . $ext) === true) {?>
                                <img style="" src="<?php echo $this->base . '/people_images/' . $pid . '.' . $ext;?>"/>
                            <?php } ?>
                        </div>
                </div>

                        <div class="col-lg-6 col-md-6 col-xs-12">

                                <div style="display: none;" class="form-group dd">
                                        <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="date_of_death">Death Date</label>   
                                        <div class="col-lg-8 col-md-8 col-xs-8">
                                                <?php echo $this->Form->input('date_of_death', array('id' => 'date_of_death', 'placeholder' => 'enter in dd/mm/yyyy format' ,'type' => 'text','value'=> $date_of_death,'title' => '','div' => false, 'label' => false, 'class' => 'dp form-control date_of_death')); ?>
                                        </div>
                                </div>
                            <div class="form-group">
                                        <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="is_late">Late</label>
                                        <div class="col-lg-8 col-md-8 col-xs-8">
                                                <?php echo $this->Form->input("is_late", array('type' => "checkbox", 'checked' => $is_late == 1 ? 'checked' : '','div' => false, 'label' => false,)); ?>
                                        </div>
                                </div>
                                <div class="form-group maidensurname">
                                        <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="maiden_surname">Maiden Surname</label>
                                        <div class="col-lg-8 col-md-8 col-xs-8">

                                        <?php

                                        echo $this->Form->input('maiden_surname', array('id' => 'maiden_surname',
                                        'label' => false,
                                        'div' => false,
                                        'legend' => false,
                                        'empty' => __d('label', '--Select--'),
                                        'class' => 'maiden_surname combobox',
                                        'style' => '',
                                        // 'disabled' => $readonly,
                                        'options' => $main_surnames,
                                        'value' => $maiden_surname

                                        ));

                                        ?>
                                        </div>
                                </div>


                                <div class="form-group maidenvillage">
                                        <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="maiden_village">Maiden Village</label>
                                        <div class="col-lg-8 col-md-8 col-xs-8">

                                        <?php

                                        echo $this->Form->input('maiden_village', array('id' => 'maiden_village',
                                        'label' => false,
                                        'div' => false,
                                        'legend' => false,
                                        'empty' => __d('label', '--Select--'),
                                        'class' => 'maiden_village combobox',
                                        'style' => '',
                                        'disabled' => $readonly,
                                        'options' => $villages,
                                        'value' => $maiden_village
                                        ));
                                        ?>
                                        </div>
                                </div>                        
                                <div class="form-group">
                                        <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="mahajan_membership_number">Mahajan Membership Number</label>   
                                        <div class="col-lg-8 col-md-8 col-xs-8">
                                                <?php echo $this->Form->input('mahajan_membership_number', 
                                                        array('id' => 'mahajan_membership_number', 'value'=> $mahajan_membership_number,'type' => 'text','title' => '','div' => false, 'label' => false, 'class' => 'dp form-control')); ?>
                                        </div>
                                </div>


                                <div class="form-group blood_groupdiv">
                                        <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="blood_group">Blood Group</label>
                                        <div class="col-lg-8 col-md-8 col-xs-8">

                                        <?php

                                        $array = array('' => '--select--');
                                        $bloodgroups = array_merge($array, $bloodgroups);
                                        echo $this->Form->input('blood_group', array('id' => 'blood_group',
                                        'label' => false,
                                        'div' => false,
                                        'legend' => false,
                                        'class' => 'combobox',
                                        'style' => 'width:50px;',
                                        'width' => '50%',
                                        'empty' => __d('label', '--Select--'),
                                        'options' => $bloodgroups,
                                        'value' => $blood_group
                                        ));

                                        ?>
                                        </div>
                                </div>

                                <?php if( $userType != 'addnew' && $is_late != 1 && $address_id != 0) { ?>
                                <div class="form-group sameaddress">
                                        <div class="form-group">
                                                <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="is_late">Home Address</label>
                                                <div class="checkbox col-lg-8 col-md-8 col-xs-8">
                                                <?php echo $this->Form->input("is_same", array('type' => "checkbox",'class' => 'same_as', 'checked' => $same == true ? 'checked' : '','div' => false, "label" => array('class' => 'checkboxLabel', 'text' => __('Same as ' . $name)))); ?>
                                                </div>
                                        </div>
                                </div>
                                <?php } ?>

                                <div class="form-group">
                                        <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="gender">DOB</label>   
                                        <div class="col-lg-8 col-md-8 col-xs-8">
                                                <?php echo $this->Form->input('date_of_birth', 
                                                        array('id' => 'date_of_birth', 'value'=> $date_of_birth,'type' => 'text','title' => '','placeholder' => 'enter in dd/mm/yyyy format' ,'div' => false, 'label' => false, 'class' => 'dp form-control')); ?>
                                        </div>
                                </div>

                                <div class="form-group">
                                        <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="mobile_number">Mobile Number</label>
                                        <div class="col-lg-8 col-md-8 col-xs-8">
                                                <?php echo $this->Form->input('mobile_number', array('id' => 'mobile_number', 'value'=> $mobile_number,'placeholder' => 'Enter Mobile Number' ,'title' => '','div' => false, 'label' => false, 'class' => 'phone_number form-control')); ?>
                                        </div>
                                </div>
                        </div>
                </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="form-actions">
                        <div class="col-lg-4 col-md-4 col-xs-4">&nbsp;</div>
                        <div class="col-lg-8 col-md-8 col-xs-8">
                            <button type="button" class="btn btn-primary editOwnButton">Save and Continue</button>
                            <button type="button" style="color: red" class="btn btn-link cancel">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
         </div>
    </div>
</div>
<?php
 $selLanguage = 'english';
    if ($this->Session->check('Website.language')) {
        $selLanguage = $this->Session->read('Website.language');
    }
    ?>
<div id="treeredirect" data-userid="<?php echo $this->Session->read('User.user_id'); ?>" data-lang="<?php echo md5($selLanguage); ?>" data-user="<?php echo md5($this->Session->read('User.user_id')); ?>" style="display:none;"></div>
<?php
   $token = urlencode('t='.md5('dsdsdss434dsds332323d34d').'&u='.md5($this->Session->read('User.user_id')).'&l='.md5($selLanguage));
?>
<script type="text/javascript">
    var pid = '<?php echo $pid; ?>';
    var userType = '<?php echo $userType; ?>';
    var grpid = '<?php echo $gid; ?>';
    var is_late = '<?php echo $is_late; ?>';
    var gender = '<?php echo $gender;?>';
    var module = "<?php echo $module; ?>";
    var token = "<?php echo $token; ?>";
</script>
<script>
    $(function () { 
            $( "#first_name" ).autocomplete({
               source: baseUrl + "/family/getAutoCompleteFirstName"
            });
             $( "#last_name" ).autocomplete({
               source: baseUrl + "/family/getAutoCompleteLastName"
            });
//        $("#date_of_birth").datepicker({
//            format: "mm/dd/yyyy",
//        });
//        $('.dp').on('change', function () {
//            $('.datepicker').hide();
//        });
//        $("#date_of_marriage").datepicker({
//            format: "mm/dd/yyyy"
//        });
//        
//        $("#date_of_death").datepicker({
//            format: "mm/dd/yyyy"
//        });
    });
    
     $('.cancel').click(function(){
           
       if(module==''){
            if(  userType == 'addnew') {
                  window.location.href = baseUrl +"/family/familiyGroups";
            } else {
                 window.location.href = baseUrl +"/family/details/"+ grpid;
            }
        }else if(module=='tree'){
            window.location.href = baseUrl +"/tree?gid="+grpid+"&token="+token;
        }
       
    });
</script>
<script type="text/javascript">
 var image_format = "<?php echo 'jpeg|png|jpg'; ?>";
 //var module = "<?php echo $module; ?>";
 var fid = "<?php echo $fid; ?>";
/*$('.imagesubmit').click(function(){
     $("#imagepic").submit();
     return false;
})*/
</script>

<script type="text/javascript">
    $(function() {
       $('#UploadImages').uberuploadcropper({
            //---------------------------------------------------
            // uploadify options..
            //---------------------------------------------------
            fineuploader: {
                //debug : true,
                request : { 
                    // params: {}
                    endpoint: '/image/imageUpload?pid=' + pid 
                },                      
                validation: {
                    //sizeLimit : 0,
                    allowedExtensions: ['jpg','jpeg','png','gif']
                }
            },
            //---------------------------------------------------
            //now the cropper options..
            //---------------------------------------------------
            jcrop: {
                aspectRatio  : 1, 
                allowSelect  : false, //can reselect
                allowResize  : true,  //can resize selection
                setSelect    : [ 0, 0, 200, 200 ], //these are the dimensions of the crop box x1,y1,x2,y2
                minSize      : [ 200, 200 ], //if you want to be able to resize, use these
                maxSize      : [ 500, 500 ]
            },
            //---------------------------------------------------
            //now the uber options..
            //---------------------------------------------------
            folder           : '/people_images/', // only used in uber, not passed to server
            cropAction       : '/image/cropUploadedImage', // server side request to crop image
            onComplete       : function(e,imgs,data){ 
                if(module=='tree'){
                    window.location.href = baseUrl +"/tree?gid="+grpid+"&token="+token;
                }
                var $PhotoPrevs = $('#PhotoPrevs');

                for(var i=0,l=imgs.length; i<l; i++){
                    $PhotoPrevs.html('<img src="/people_images/'+ imgs[i].filename +'?d='+ (new Date()).getTime() +'" />');
                    $(".qq-upload-list").hide();
                }
            }
        });
    });
    var ua = navigator.userAgent;
    var device_type = (ua.match(/Android|webOS|iPhone|iPad|iPod|BlackBerry|BB|PlayBook|IEMobile|Windows Phone|Kindle|Silk|Opera Mini/i)) ? "mobile" : "desktop";
    if(device_type == "mobile"){
        $("#forMob").show();
    }
</script>
<?php //echo $this->Html->script(array('ajaxupload')); ?>

<?php echo $this->Html->script(array('Family/family_self_edit')); ?>
