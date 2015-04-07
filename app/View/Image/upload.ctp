<div class="container-fluid">
      <div class="row"> <h4>Upload Images</h4></div>
      <?php foreach( $data as $key => $value ) { ?>
       <div class="row">
        <div class="col-md-2" <?php echo $value['People']['is_late'] == '1' ? "style='color:red';" : ''?> ><?php echo $value['People']['first_name'] . ' ' . $value['People']['[last_name'];?> (<?php echo $value['People']['id'];?>)</div>
       <?php echo $this->Form->create('Image', array('type'=>'file','class' => 'clearfix imagepic', 'id' => 'imagepic'.$key, 'name' => 'add')); ?>
      <div class="col-md-3">
           <?php echo $this->Form->input('photo_id',array('type' => 'file','label'=>'Photo ID')); ?>
      </div>
        <div class="col-md-1">
            <?php if (file_exists($_SERVER["DOCUMENT_ROOT"].'\kvofront\app\webroot\people_images/' . $value['People']['id'] .'.' . $value['People']['ext']) ===  true) { ?>
            <?php echo $value['People']['id'] . '.' . $value['People']['ext'];?>
            <?php } ?>
        </div>
      <div class="col-md-1">
          <button type="button" class="btn btn-primary saveButton imagesubmit" data-key="<?php echo $key;?>">Upload</button>
      </div>
         <?php echo $this->Form->input('people_id',array('type' => 'hidden','label'=>false,'value' => $value['People']['id'])); ?>
         <?php echo $this->Form->end(); ?>
        </div>
      <br />
      
      <?php } ?>
</div>

<script type="text/javascript">
$('.imagesubmit').click(function(){
    var key = $(this).data('key');
  
     $("#imagepic"+key).submit();
     return false;
})
</script>