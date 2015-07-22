<style>
ul.ui-menu {z-index:9999 ; /* The default is 100. !important overrides the default. */}
.ui-dialog{z-index: 0 !important}
#dialog-form{display:none;}
</style>
<div class="container-fluid">
    <div class="panel panel-info">
	<div class="panel-heading">Family details (<?php echo $data[0]['People']['first_name'] . ' ' . $data[0]['People']['last_name'];?>)</div>
        <div class="panel-body">
        <?php
            App::import('Model', 'People');
             $People = new People();
             $hofId ;

            App::import('Model', 'PeopleEducation');
             $PeopleEducation = new PeopleEducation();
        ?>
                        
	<?php foreach( $data as $key => $value ) {
                    if( $value['Group']['tree_level'] == '') {
                        $hofId = $value['People']['id'];
                        $hofAddressId = $value['People']['address_id'];
                        $hofName = $value['People']['first_name'];
                    }
                    $missingData = array();
        ?>
        <?php   
                    if( $groupId == $value['People']['group_id']) { 
                            switch( $type) {
                            case 'english':
                            $firstName = $value['People']['first_name'];
                            $lastName = $value['People']['last_name'];
                            break;
                            case 'gujurathi':
                            $firstName = $value['t1']['gujurathi_text'] ? $value['t1']['gujurathi_text'] : $value['People']['first_name'];
                            $lastName = $value['t']['gujurathi_text'] ? $value['t']['gujurathi_text'] : $value['People']['last_name'];
                            break;
                    case 'hindi':
                            $firstName = $value['t1']['hindi_text'] ? $value['t1']['hindi_text'] :$value['People']['first_name'];
                            $lastName = $value['t']['hindi_text'] ? $value['t']['hindi_text'] :  $value['People']['last_name'];
                            break;
                            default :
                    $firstName = $value['People']['first_name'];
                            $lastName = $value['People']['last_name'];
                            break;
                    }

        ?>
    <div class="row">
        <div class="col-md-2 col-xs-4">
				<a class="self" <?php echo $value['People']['is_late'] == '1' ? "style='color:red';" : ''?> data-gid="<?php echo $value['People']['group_id'];?>" data-id="<?php echo $value['People']['id'];?>" href="javascript: profileOf(<?php echo $value['People']['id'];?>);"><?php echo (isset($translations[$value['People']['first_name']]) ? $translations[$value['People']['first_name']] :  $value['People']['first_name']) . ' ' . (isset($translations[$value['People']['last_name']]) ? $translations[$value['People']['last_name']] :  $value['People']['last_name']);?></a>

				<br />

                <?php if (file_exists($uploadFilePath . $value['People']['id'] .'.' . $value['People']['ext']) ===  true) { ?>
                        <img style="width:60px;height:60px;" src="<?php echo $this->base;?>/people_images/<?php echo $value['People']['id'] .'.' . $value['People']['ext']; ?>"/><br />
<?php if ( $this->Session->read('User.user_id') == $value['People']['id'] || $this->Session->read('User.user_id') == $hofId) { ?>
                        <a href="javascript:void(0);" class="deletephoto" data-id="<?php echo $value['People']['id'];?>">Delete</a>
<?php } ?>
                <?php } else {?>
<?php if ( $this->Session->read('User.user_id') == $value['People']['id'] || $this->Session->read('User.user_id') == $hofId) { ?>
                        <a class="selfPhoto" data-gid="<?php echo $value['People']['group_id'];?>" data-id="<?php echo $value['People']['id'];?>" href="javascript:void(0);">Add Photo</a>
<?php } ?>
                <?php } ?>
        </div>

        <div class="col-md-2 col-xs-4">

                <?php if (strtolower($value['People']['martial_status']) == 'married' && empty($value['People']['partner_id'])) { ?>
                    <?php if ($this->Session->read('User.user_id') == $hofId) { ?>
                        <a class="addspouse" data-gid="<?php echo $value['People']['group_id']; ?>" data-id="<?php echo $value['People']['id']; ?>" data-first_name="<?php echo $value['People']['first_name']; ?>" href="javascript:void(0);">Add Spouse</a><br>
                    <?php } ?>
                <?php } else { ?> 
                <?php  ?>
                    <div><strong>Spouse</strong>: <a title="edit" class="self" data-gid="<?php echo $value['People']['group_id']; ?>" data-id="<?php echo $value['People']['partner_id']; ?>" href="javascript:profileOf(<?php echo $value['People']['partner_id']; ?>);"><?php echo isset($translations[$value['parent3']['partner_name']]) ? $translations[$value['parent3']['partner_name']] : $value['parent3']['partner_name']; ?> <?php echo isset($translations[$value['parent3']['partner_lastname']]) ? $translations[$value['parent3']['partner_lastname']] : $value['parent3']['partner_lastname']; ?></a>
                    
                    <?php if (strtolower($value['People']['martial_status']) == 'married' && $value['People']['gender'] == 'Male') { ?>
                        <?php if ($this->Session->read('User.user_id') == $hofId) { ?>
                            <br><a class="addexspouse" data-gid="<?php echo $value['People']['group_id']; ?>" data-id="<?php echo $value['People']['id']; ?>" data-first_name="<?php echo $value['People']['first_name']; ?>" href="javascript:void(0);">Add Ex-Spouse</a>
                        <?php } ?>
                    <?php } ?>
                    </div>
                <?php } ?>
                        
                        
                <?php if (empty($value['People']['f_id'])) { ?>
                    <?php if ($this->Session->read('User.user_id') == $hofId) { ?>
                        <a class="addfather" data-gid="<?php echo $value['People']['group_id']; ?>" data-id="<?php echo $value['People']['id']; ?>" data-first_name="<?php echo $value['People']['first_name']; ?>" href="javascript:void(0);">Add Father</a>
                    <?php } ?>
                <?php } else { ?>
                        <div><strong>Father</strong>: <a title="profile"  class="self" data-gid="<?php echo $value['People']['group_id']; ?>" data-id="<?php echo $value['People']['f_id']; ?>" href="javascript:profileOf(<?php echo $value['People']['f_id']; ?>);"><?php echo isset($translations[$value['parent1']['father']]) ? $translations[$value['parent1']['father']] : $value['parent1']['father']; ?> <?php echo isset($translations[$value['parent1']['father_lastname']]) ? $translations[$value['parent1']['father_lastname']] : $value['parent1']['father_lastname']; ?></a></div>
                <?php } ?>
                        
                        
                <?php if (empty($value['People']['m_id'])) { ?>
                    <?php if ($this->Session->read('User.user_id') == $hofId) { ?>
                        <a class="addmother" data-gid="<?php echo $value['People']['group_id']; ?>" data-id="<?php echo $value['People']['id']; ?>" data-first_name="<?php echo $value['People']['first_name']; ?>" href="javascript:void(0);">Add Mother</a>
                    <?php } ?>
                <?php } else { ?>                  
                        <div><strong>Mother</strong>:  <a title="profile"  class="self" data-gid="<?php echo $value['People']['group_id']; ?>" data-id="<?php echo $value['People']['m_id']; ?>" href="javascript:profileOf(<?php echo $value['People']['m_id']; ?>);"><?php echo isset($translations[$value['parent2']['mother']]) ? $translations[$value['parent2']['mother']] : $value['parent2']['mother']; ?> <?php echo isset($translations[$value['parent2']['mother_lastname']]) ? $translations[$value['parent2']['mother_lastname']] : $value['parent2']['mother_lastname']; ?></a></div>
                <?php } ?>
        </div>

        <div class="col-md-3 col-xs-4">
            
            <?php if( $value['People']['gender'] == 'Male') {  ?>
<?php if ( $this->Session->read('User.user_id') == $hofId && strtolower($value['People']['martial_status']) != 'single') { ?>
<a class="addchild" href="javascript:void(0);" data-gid="<?php echo $value['People']['group_id'];?>" data-first_name="<?php echo $value['People']['first_name'];?>" data-id="<?php echo $value['People']['id'];?>" >Add Children</a><br>
             <?php } } ?>  
             <?php 
                $children = $People->getChildren($value['People']['id'],$value['People']['gender']);
                $childs = array();
                if(is_array($children)){
                    foreach ( $children as $k => $v ) {
                        $child = $v[0]['childname'];
                        $childId = $v['People']['id'];
                        $childArr = explode(' ', $child);
                        $childNewArr = array();
                        foreach ($childArr as $sp) {
                            $childNewArr[] = isset($translations[$sp]) ? $translations[$sp] :  $sp;
                        }

                        $childs[] = '<a href="javascript: profileOf('.$childId.');">'.implode(' ', $childNewArr).'</a>';
                    }
                }
                
            if (count($childs)) {
            ?>
            <div><strong>Children</strong>: <?php echo implode(', ',$childs); ?></div>
            <?php } ?>
            
                                    
            <?php if ( $value['People']['f_id'] != '') {?>
                <?php if ( $this->Session->read('User.user_id') == $hofId) { ?>
                           <a class="addbrother" data-gid="<?php echo $value['People']['group_id'];?>" data-id="<?php echo $value['People']['id'];?>" data-first_name="<?php echo $value['People']['first_name'];?>" href="javascript:void(0);">Add Brother</a>
               <?php } ?>
               <?php $brothers = $People->getBrothers($value['People']['id']);
               $brother = array(); 
               foreach ( $brothers as $bKey => $vValue) {
               $brother[] ='<a href="javascript: profileOf('.$vValue['People']['id'].');">'.(isset($translations[$vValue['People']['first_name']]) ? $translations[$vValue['People']['first_name']] :  $vValue['People']['first_name']).' '.(isset($translations[$vValue['People']['last_name']]) ? $translations[$vValue['People']['last_name']] :  $vValue['People']['last_name']).'</a>';

                } ?>
               <?php if(count($brother)) { ?>
               <div><strong>Brothers</strong>: <?php echo implode(', ',$brother); ?></div>
               <?php } ?>
            <?php } ?>
               
               
            <?php if ( $value['People']['f_id'] != '') {?>
                <?php if ( $this->Session->read('User.user_id') == $hofId) { ?>
                <a class="addsister" data-gid="<?php echo $value['People']['group_id'];?>" data-id="<?php echo $value['People']['id'];?>" data-first_name="<?php echo $value['People']['first_name'];?>" href="javascript:void(0);">Add Sister</a>
                <?php } ?>
                <?php $sisters = $People->getSisters($value['People']['id']);
                $sister = array(); 
                foreach ( $sisters as $bKey => $vValue) {
                $sister[] = '<a href="javascript: profileOf('.$vValue['People']['id'].');">'.(isset($translations[$vValue['People']['first_name']]) ? $translations[$vValue['People']['first_name']] :  $vValue['People']['first_name']).' '.(isset($translations[$vValue['People']['last_name']]) ? $translations[$vValue['People']['last_name']] :  $vValue['People']['last_name']).'</a>';

                 } ?>
                <?php if(count($sister)) { ?>
                <div><strong>Sisters</strong>: <?php echo implode(', ',$sister); ?></div>
                <?php } ?>
            <?php } ?>
        </div>

        <div class="col-md-3 hidden-xs">
            <?php if ($value['People']['is_late'] != '1') {?>
                <?php if( $this->Session->read('User.user_id') == $value['People']['id'] || $this->Session->read('User.user_id') == $hofId) { ?>
                            <a class="editaddress" data-gid="<?php echo $value['People']['group_id'];?>" data-id="<?php echo $value['People']['id'];?>" data-aid="<?php echo $value['People']['address_id'];?>" href="javascript:void(0);">
                                                <?php echo $value['People']['address_id'] ? 'Edit Home Address' : 'Add Home Address';?></a><?php echo ($value['People']['address_id'] && $value['People']['address_id'] == $hofAddressId && $value['People']['id'] != $hofId) ? ' (Same as '.$hofName.')' : '';?><br>
                <?php } ?>
            <?php } ?>
                                                
                                                
            <?php if ($value['People']['is_late'] != '1') {?>
<?php if( $this->Session->read('User.user_id') == $value['People']['id'] || $this->Session->read('User.user_id') == $hofId) { ?>
            <a class="editbusiness" data-gid="<?php echo $value['People']['group_id'];?>" data-id="<?php echo $value['People']['id'];?>" data-aid="<?php echo $value['People']['business_address_id'];?>" href="#">
                            <?php echo ($value['People']['business_address_id'] || $value['People']['occupation'] != '') ? 'Edit Business Details' : 'Add Business Details';?></a><?php echo $value['People']['occupation'] ? ' ('.$value['People']['occupation'].')' : '';?><br>
<?php } ?>
            <?php } ?>     
                            
                            
            <?php if ($this->Session->read('User.user_id') == $value['People']['id'] || $this->Session->read('User.user_id') == $hofId) { ?>
                        <a class="editeducation" data-gid="<?php echo $value['People']['group_id']; ?>" data-id="<?php echo $value['People']['id']; ?>"  href="#">Add / Edit Education Details</a><br>
                    <?php } ?>
                    <?php 
                    $edducations = $PeopleEducation->getPeopleEducations($value['People']['id']);
                    $educations = array();
                    foreach ( $edducations as $k => $v ) {
                        $educations[] = $v['people_educations']['name'];
                    }

                    if (count($educations)) {
                    ?>
                    <div>Education: <?php echo implode(', ', $educations); ?></div>
                    <?php } ?> 

                    <?php if( $this->Session->read('User.user_id') == $hofId && $value['People']['id'] != $hofId) { ?>
<a  class="deletemember" data-gid="<?php echo $value['People']['group_id'];?>" data-id="<?php echo $value['People']['id'];?>" href="javascript:void(0);" style="color: red">Delete</a>
                     <?php } ?>
        </div>

        <?php if ( $value['Group']['tree_level'] != '') { ?>
        <div class="col-md-2 hidden-xs">
            <?php if( $this->Session->read('User.user_id') == $hofId) { ?>
           <?php if( $this->Session->read('User.user_id') == $value['People']['id'] || $this->Session->read('User.user_id') == $hofId) { ?>
                       <?php if( $hofId != $value['People']['partner_id']) { ?>
                       <a style="display:block" data-gid="<?php echo $value['People']['group_id'];?>"  data-id="<?php echo $value['People']['id'];?>" class="transfer-family" href="javascript:void(0);">Transfer of Family</a>
                       <?php } ?>
           <?php } ?>
           <?php } ?>
            <?php if( $this->Session->read('User.user_id') == $hofId) { ?>
           <?php if($value['People']['first_name'] != '' && $value['People']['last_name'] != '' && $value['People']['mobile_number'] != '' && $value['People']['village'] != '' && $value['People']['is_late'] == 0 && $value['Group']['tree_level'] != '' && $value['People']['gender'] == 'Male') { ?>
                       <a data-gid="<?php echo $value['People']['group_id'];?>" 
                       data-hofid="<?php echo $hofId;?>" 
           data-first_name="<?php echo $value['People']['first_name'];?>" 
           data-last_name="<?php echo $value['People']['last_name'];?>" 
           data-mobile_number="<?php echo $value['People']['mobile_number'];?>" 
           data-village="<?php echo $value['People']['village'];?>" 
           data-email="<?php echo $value['People']['email'];?>"

                       data-id="<?php echo $value['People']['id'];?>" 
                       href="javascript:void(0);" class="make_hof" style="display:block;">Make HOF of New Family</a>
           <?php } ?>
           <?php } ?>
        </div>
        <?php } else { ?>
    <?php if( $value['Group']['tree_level'] == '' )  { 
    $selLanguage = 'english';
    if ($this->Session->check('Website.language')) {
        $selLanguage = $this->Session->read('Website.language');
    }
    ?>
        <div class="col-md-2 hidden-xs"><a target="_blank" href="<?php echo $this->base.'/tree?gid='. $groupId.'&token='. urlencode('t='.md5('dsdsdss434dsds332323d34d').'&u='.md5($this->Session->read('User.user_id')).'&l='.md5($selLanguage));?>">View Tree</a></div>                
<?php } ?>
                                <?php } ?>

                                <?php 
                                if ( $value['People']['non_kvo'] == 0) {
                                   if (empty($value['People']['f_id'])) {
                            $missingData[] = 'Father';
                    }
                        }
        if ( $value['People']['non_kvo'] == 0) {
        if (empty($value['People']['m_id'])) {
            $missingData[] = 'Mother';
        }
        }
        if (empty($value['People']['gender'])) {
            $missingData[] = 'Gender';
        }
        if (empty($value['People']['address_id'])) {
            $missingData[] = 'Address';
        }
        if ( $value['People']['tree_level'] == '' && empty($value['People']['mobile_number'])) {
            $missingData[] = 'Mobile';
        } 
        if (empty($value['People']['date_of_birth'])) {
            $missingData[] = 'DOB';
        }
        if (empty($value['People']['village'])) {
            $missingData[] = 'Village';
        }
         if ( $value['People']['non_kvo'] == 0) {
        if (empty($value[0]['grandfather'])) {
            $missingData[] = 'Grandfather';
        }
        }
        if ( $value['People']['non_kvo'] == 0) {
         if (empty($value[0]['grandfather_mother'])) {
            $missingData[] = 'Grandfather-Mother';
        }
	  }                           ?>

    </div><br>
                        <?php } ?>
                        <?php } ?>
    <u><h4 style="display:none;" >Secondary Family</h4></u>
<?php foreach( $data as $key => $value ) { 
$missingData = array();?>
<?php if( $groupId != $value['People']['group_id']) { ?>
    <div style="display:none;" class="row">
        <div class="col-md-2"></div>
        <div class="col-md-2" <?php echo $value['People']['is_late'] == '1' ? "style='color:red';" : ''?>><?php echo $value['People']['first_name'] . ' ' . $value['People']['last_name'];?> </div>
        
        <div class="col-md-2">
            
                                    <?php if(strtolower($value['People']['martial_status']) == 'married' && empty($value['People']['partner_id'])) { ?>
            
                                    <?php } else  { ?> 
            <div>Spouse: <?php echo $value['People']['partner_name'];?></div>
                                    <?php } ?>
                   <?php if ($value['People']['is_late'] != '1') {?>
           
                    <?php } ?>
                    <?php if( empty($value['People']['f_id'])) { ?>

                    <?php }  else { ?>
                    <div>Father: <?php echo $value['People']['father'];?></div>
                    <?php } ?>
                    <?php if ($value['People']['is_late'] != '1') { ?>

                    <?php } ?>
                    <?php if (empty($value['People']['m_id'])) { ?>

                    <?php } else { ?>
                        <div>Mother: <?php echo $value['People']['mother']; ?></div>
                    <?php } ?>
        </div>
        
        
        <div class="col-md-2">
                                 <?php if( !empty($value['People']['partner_id']) && $value['People']['gender'] == 'Male') { ?>
            
                                    <?php $children = $People->getChildren($value['People']['id'],'Male');
                                    $childs = array();
                                    foreach ( $children as $k => $v ) {
                                        $childs[] = $v[0]['childname'];
                                    }
                                    
                                    ?>
            <div>Children: <?php echo implode(', ',$childs); ?></div>
                                <?php } ?>
                                    <?php if( $roleId == 1 && $value['Group']['tree_level'] != '') { ?>
           
                                     <?php } ?>
        </div>       
<?php 
 if ( $value['People']['non_kvo'] == 0) {
                                   if (empty($value['People']['f_id'])) {
            $missingData[] = 'Father';
        }
}
        if ( $value['People']['non_kvo'] == 0) {
        if (empty($value['People']['m_id'])) {
            $missingData[] = 'Mother';
        }
        }
        if (empty($value['People']['gender'])) {
            $missingData[] = 'Gender';
        }
        if (empty($value['People']['address_id'])) {
            $missingData[] = 'Address';
        }
        if ( $value['People']['tree_level'] == '' && empty($value['People']['mobile_number'])) {
            $missingData[] = 'Mobile';
        }
        if (empty($value['People']['date_of_birth'])) {
            $missingData[] = 'DOB';
        }
        if (empty($value['People']['village'])) {
            $missingData[] = 'Village';
        }
         if ( $value['People']['non_kvo'] == 0) {
        if (empty($value[0]['grandfather'])) {
            $missingData[] = 'Grandfather';
        }
        }
        if ( $value['People']['non_kvo'] == 0) {
        if (empty($value[0]['grandfather_mother'])) {
            $missingData[] = 'Grandfather-Mother';
        } 
        }


                                    ?>
        <!--<div class="col-md-3">
<?php if ( $value['People']['is_late'] == 0) { ?>
                                   <?php //echo "Missing: <span class=\"text-danger bg-danger\">" . implode(', ',$missingData) . "</span>";?>  
<?php } ?>
        </div>-->
    </div>


<?php } ?>
<?php } ?>
</div>
        </div>
    </div>
<div id="dialog-form" title="Transfer of family">
    <div class="container-fluid">
        <div class="row">
            <div class="form-group">
                <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="owner">Transfer to</label>   
                <div class="col-lg-8 col-md-8 col-xs-8">
                         <?php
                         
                         echo '<select class="owner combobox">';
foreach($owners as $key => $value){
if( $groupId != $value['group_id']) {
    echo "<option data-peopleid='{$value['id']}' value='{$value['group_id']}'>{$value['name']} ({$value['group_id']})</option>";
}
}
echo '</select>';
                        
            
            ?>
                </div>

            </div>
        </div>
    </div>
</div>
<?php echo $this->Html->script(array('ajaxupload')); ?>
<?php echo $this->Html->script(array('Family/details')); ?>
<script type="text/javascript">
 var image_format = "<?php echo 'jpeg|png|jpg'; ?>";
var groupid = '<?php echo $groupId;?>';
</script>

<script type="text/javascript">

$('.deletephoto').click(function(){
   
    var result = confirm("Want to delete?");
    if (result === true) {
     var $this = $(this);
    var id = $this.data('id');
     $.ajax({
        url: baseUrl + '/image/deleteImage',
        dataType: 'json',
        data: {id: id},
        type: "POST",
        success: function (response) {
            var displayMsg = response.message;
            showJsSuccessMessage(displayMsg);
            setTimeout(function () {
                $('.jssuccessMessage').hide('slow');
               window.location.href= baseUrl+ '/family/details/<?php echo $groupId;?>'
                
            }, 2500);
        }
    });
} else {
return;
}
});


</script>

