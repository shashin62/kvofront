<div class="container-fluid">
    <h3 class="heading">Search People - Transfer of Family</h3>
    <?php echo $this->Form->create('People', array('class' => 'form-horizontal searchForm', 'id' => 'search', 'name' => 'register')); ?>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="first_name">First Name</label>
                <div class="col-lg-8 col-md-8 col-xs-8">
                        <?php echo $this->Form->input('first_name', array('id' => 'first_name', 'placeholder' => 'Enter First Name' ,'title' => '','div' => false, 'label' => false, 'class' => 'form-control search_username first_name','custom'=>"1")); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="main_surname">Main Surname</label>
                <div class="col-lg-8 col-md-8 col-xs-8">
                        <?php echo $this->Form->input('main_surname', array('id' => 'main_surname', 'placeholder' => 'Enter Main Surname' ,'title' => '','div' => false, 'label' => false, 'class' => 'form-control search_username main_surname','custom'=>"3")); ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="mobile_number">Mobile</label>
                <div class="col-lg-8 col-md-8 col-xs-8">
                        <?php echo $this->Form->input('mobile_number', array('id' => 'mobile_number', 'placeholder' => 'Enter Phone Number' ,'title' => '','div' => false, 'label' => false, 'class' => 'form-control search_username','custom'=>"4")); ?>
                </div>
            </div>
            
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-xs-12">
            
       
            <div class="form-group">
                <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="last_name">Last Name</label>   
                <div class="col-lg-4 col-md-4 col-xs-4">
                         <?php echo $this->Form->input('last_name', 
                       array('id' => 'last_name', 'type' => 'text','title' => '','div' => false, 'label' => false, 'class' => 'form-control search_username last_name','custom'=>"2")); ?>
                </div>
            </div>
            
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-md-6 col-xs-12">
            <div class="form-actions">
                <div class="col-lg-4 col-md-4 col-xs-4">&nbsp;</div>
                <div class="col-lg-8 col-md-8 col-xs-8">
                    <button type="button" class="btn btn-primary registerButton">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <?php echo $this->Form->end(); ?>
</div>
<div class="container-fluid">   
<h3 class="heading">Search Result</h3>
<table id="all_users" class="display" cellspacing="0" width="100%">
    <thead>
   <tr>
                        
                        <th>Id</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Main Surname</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
    </thead>
    <tbody>

    </tbody>
</table>
    </div>
<script>
   var id = '<?php echo $data["fid"];?>';
   var gid = '<?php echo $data["gid"];?>';
</script>
<?php echo $this->Html->script(array('Family/transfer')); ?>