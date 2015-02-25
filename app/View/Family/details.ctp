<style>
ul.ui-menu {
    z-index:9999 ; /* The default is 100. !important overrides the default. */
}
.ui-dialog{
z-index: 0 !important
}
</style>
<div class="container-fluid">
      <div class="row"> <h4>Primary Family</h4></div>
    <br>
                        <?php

                       App::import('Model', 'People');
                        $People = new People();
                        $hofId ;
                  ?>
                        
			<?php foreach( $data as $key => $value ) {
                            if( $value['Group']['tree_level'] == '') {
                                $hofId = $value['People']['id'];
$hofAddressId = $value['People']['address_id'];
                            }
                            $missingData = array();?>
                    <?php if( $groupId == $value['People']['group_id']) { 
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
        <div class="col-md-1" <?php echo $value['People']['is_late'] == '1' ? "style='color:red';" : ''?> >
    <?php echo $firstName . ' ' . $lastName;?> (<?php echo $value['People']['id'];?>)
<?php if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/people_images/' . $value['People']['id'] .'.' . $value['People']['ext']) ===  true) { ?>
<div>
    <img style="width:75px;height:75px;" src="<?php echo $this->base;?>/people_images/<?php echo $value['People']['id'] .'.' . $value['People']['ext']; ?>"/>
    <a href="javascript:void(0);" class="deletephoto" data-id="<?php echo $value['People']['id'];?>">Delete</a>
</div>
<?php }?>
</div>
        <div class="col-md-1">
            <a class="self" data-gid="<?php echo $value['People']['group_id'];?>" data-id="<?php echo $value['People']['id'];?>" href="javascript:void(0);">Edit Detail</a><br>
                                    <?php if(strtolower($value['People']['martial_status']) == 'married' && empty($value['People']['partner_id'])) { ?>
            <a  style="display:none;" class="addspouse" data-gid="<?php echo $value['People']['group_id'];?>" data-id="<?php echo $value['People']['id'];?>" data-first_name="<?php echo $value['People']['first_name'];?>" href="javascript:void(0);">Add Spouse</a><br>
                                    <?php } else  { ?> 
            <div>Spouse: <a title="edit" class="self" data-gid="<?php echo $value['People']['group_id'];?>" data-id="<?php echo $value['People']['partner_id'];?>" href="javascript:void(0);"><?php echo $value['parent3']['partner_name'];?></a>
 <?php if( $value['People']['gender'] == 'male') { ?>
<a style="display:none;" class="addexspouse" data-gid="<?php echo $value['People']['group_id'];?>" data-id="<?php echo $value['People']['id'];?>" data-first_name="<?php echo $value['People']['first_name'];?>" href="javascript:void(0);">Add Ex-Spouse</a>
<?php } ?>
</div>
                                    <?php } ?>

        </div>
        <div class="col-md-2">
            <?php if ($value['People']['is_late'] != '1') {?>
            <a  style="display:none;" class="editaddress" data-gid="<?php echo $value['People']['group_id'];?>" data-id="<?php echo $value['People']['id'];?>" data-aid="<?php echo $value['People']['address_id'];?>" href="javascript:void(0);">
                                <?php echo $value['People']['address_id'] ? 'Edit Home Address' : 'Add Home Address';?></a><br>
                    <?php } ?>
                                    <?php if( empty($value['People']['f_id'])) { ?>
            <a  style="display:none;" class="addfather" data-gid="<?php echo $value['People']['group_id'];?>" data-id="<?php echo $value['People']['id'];?>" data-first_name="<?php echo $value['People']['first_name'];?>" href="javascript:void(0);">Add Father</a>
                                    <?php }  else { ?>
            <div>Father: <a title="edit"  class="self" data-gid="<?php echo $value['People']['group_id'];?>" data-id="<?php echo $value['People']['f_id'];?>" href="javascript:void(0);"><?php echo $value['parent1']['father'];?></a></div>
                                    <?php } ?>
        </div>
        <div class="col-md-2">
             <?php if ($value['People']['is_late'] != '1') {?>
            <a  style="display:none;" class="editbusiness" data-gid="<?php echo $value['People']['group_id'];?>" data-id="<?php echo $value['People']['id'];?>" data-aid="<?php echo $value['People']['business_address_id'];?>" href="#">
                            <?php echo $value['People']['business_address_id'] ? 'Edit Business Details' : 'Add Business Details';?></a><br>
             <?php } ?>
                                    <?php if( empty($value['People']['m_id'])) { ?>
            <a  style="display:none;" class="addmother" data-gid="<?php echo $value['People']['group_id'];?>" data-id="<?php echo $value['People']['id'];?>" data-first_name="<?php echo $value['People']['first_name'];?>" href="javascript:void(0);">Add Mother</a>
                                    <?php } else { ?>
            <div>Mother:  <a title="edit"  class="self" data-gid="<?php echo $value['People']['group_id'];?>" data-id="<?php echo $value['People']['m_id'];?>" href="javascript:void(0);"><?php echo $value['parent2']['mother'];?></a></div>
                                    <?php } ?>
        </div>
        <div class="col-md-2">
                                 <?php if( !empty($value['People']['partner_id']) && strtolower($value['People']['gender']) == 'male') { ?>
            <a  style="display:none;" class="addchild" href="javascript:void(0);" data-gid="<?php echo $value['People']['group_id'];?>" data-first_name="<?php echo $value['People']['first_name'];?>" data-id="<?php echo $value['People']['id'];?>" >Add Children</a><br>
                                    <?php $children = $People->getChildren($value['People']['id'],'male');
                                    $childs = array();
                                    foreach ( $children as $k => $v ) {
                                        $childs[] = $v[0]['childname'];
                                    }
                                    
                                    ?>
            <div>Children: <?php echo implode(', ',$childs); ?></div>
                                <?php } ?>
                                    <?php if( ($roleId == 1 || $this->Session->read('User.user_id') == $value['People']['created_by'] ) && $value['Group']['tree_level'] != '') { ?>
            <a  style="display:none;" class="deletemember" data-gid="<?php echo $value['People']['group_id'];?>" data-id="<?php echo $value['People']['id'];?>" href="javascript:void(0);" style="color: red">Delete</a>
                                     <?php } ?>
        </div>
 <div class="col-md-2">
<form id="<?php echo 'imagepic'.$key ;?>" enctype="multipart/form-data"
   method="post" action="<?php echo $this->base;?>/image/upload" name="add" class="clearfix imagepic">
      <div class="col-md-2">
           <?php echo $this->Form->input('photo_id',array('type' => 'file','label'=> '')); ?>
      </div>
<br><br>
<br/><br />
      <div class="col-md-1">
          <button type="button" class="btn btn-primary saveButton imagesubmit" data-key="<?php echo $key;?>">Upload</button>
      </div>
         <?php echo $this->Form->input('people_id',array('type' => 'hidden','label'=>false,'value' => $value['People']['id'])); ?>
         <?php echo $this->Form->end(); ?>
</div>
                                <?php if($value['Group']['tree_level'] != '') { ?>
        <div class="col-md-1">
            <?php if( $hofId != $value['People']['partner_id']) { ?>
            <a  style="display:none;" data-id="<?php echo $value['People']['id'];?>" class="transfer-family" href="javascript:void(0);">Transfer of Family</a>
            <?php } ?>

        </div>
                                <?php } else { ?>
        <div class="col-md-1"><a target="_blank" href="<?php echo $this->base.'/tree?gid='. $groupId.'&token='. md5('dsdsdss434dsds332323d34d');?>">View Tree</a></div>                
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
        <div class="col-md-3"> 
        <?php if ( $value['People']['is_late'] == 0 )  { ?>
                                    <?php // echo "Missing: <span class=\"text-danger bg-danger\">" . implode(', ',$missingData) . "</span>";?>                                    
<?php } ?>
        </div>
    </div><br>
                        <?php } ?>
                        <?php } ?>
    <u><h4>Secondary Family</h4></u>
<?php foreach( $data as $key => $value ) { 
$missingData = array();?>
<?php if( $groupId != $value['People']['group_id']) { ?>
    <div class="row">
        <div class="col-md-1" <?php echo $value['People']['is_late'] == '1' ? "style='color:red';" : ''?>><?php echo $value['People']['first_name'] . ' ' . $value['People']['last_name'];?> (<?php echo $value['People']['id'];?>)</div>
        
 <div class="col-md-1">
            
                                    <?php if(strtolower($value['People']['martial_status']) == 'married' && empty($value['People']['partner_id'])) { ?>
            
                                    <?php } else  { ?> 
            <div>Spouse: <?php echo $value['People']['partner_name'];?></div>
                                    <?php } ?>

        </div>
        <div class="col-md-2">
            <?php if ($value['People']['is_late'] != '1') {?>
           
                    <?php } ?>
                                    <?php if( empty($value['People']['f_id'])) { ?>
           
                                    <?php }  else { ?>
            <div>Father: <?php echo $value['People']['father'];?></div>
                                    <?php } ?>
        </div>
        <div class="col-md-2">
             <?php if ($value['People']['is_late'] != '1') {?>

             <?php } ?>
                                    <?php if( empty($value['People']['m_id'])) { ?>
           
                                    <?php } else { ?>
            <div>Mother: <?php echo $value['People']['mother'];?></div>
                                    <?php } ?>
        </div>
        <div class="col-md-2">
                                 <?php if( !empty($value['People']['partner_id']) && strtolower($value['People']['gender']) == 'male') { ?>
            
                                    <?php $children = $People->getChildren($value['People']['id'],'male');
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
        <div class="col-md-3">
<?php if ( $value['People']['is_late'] == 0) { ?>
                                   <?php //echo "Missing: <span class=\"text-danger bg-danger\">" . implode(', ',$missingData) . "</span>";?>  
<?php } ?>
        </div>
    </div>


<?php } ?>
<?php } ?>
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
<?php echo $this->Html->script(array('Family/details')); ?>
<script type="text/javascript">
var groupid = '<?php echo $groupId;?>';
</script>
<script type="text/javascript">
$('.imagesubmit').click(function(){
    var key = $(this).data('key');
  
     $("#imagepic"+key).submit();
     return false;
});

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
