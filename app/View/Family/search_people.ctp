<style type="text/css">
    #all_users_filter{
        display: none;
    }
</style>
<div class="container-fluid">
    
    <?php
    if( $name_parent ) {
        $title = 'Search and add ' . ucfirst(str_replace('add', ' ', $type)) . ' of ' . $name_parent;
    } else {
        $title = 'Search/Add New Family';
    }
    
    if( $name_parent ) {
        $buttonLabel = 'Add new ' . ucfirst(str_replace('add', ' ', $type)) . ' of ' . $name_parent;
    } else {
        $buttonLabel = 'Add New Family Owner';
    }
    ?>
    
<h3 class="heading"><?php echo $title; ?></h3>

    <div class="row">
        <div class="col-md-4">	
            <form class="form-horizontal addUser">
                <div class="form-group">
                    <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="first_name">First Name</label>
                    <div class="col-lg-8 col-md-8 col-xs-8">
                        <input type="text" class="form-control first_name search_username" name="first_name" placeholder="First Name" custom="1" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="last_name">Last Name</label>
                    <div class="col-lg-8 col-md-8 col-xs-8">
                        <input type="text" class="form-control last_name search_username" name="last_name" placeholder="Last Name" custom="2" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="main_surname">Main Surname</label>
                    <div class="col-lg-8 col-md-8 col-xs-8">
                        <input id = "main_surname" type="text" class="form-control main_surname search_username" name="main_surname" placeholder="Main Surname" custom="6"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="father">Fathers Name</label>
                    <div class="col-lg-8 col-md-8 col-xs-8">
                        <input type="text" class="form-control father search_username" name="father_name" placeholder="Fathers Name" custom="7" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="mother_name">Mothers Name</label>
                    <div class="col-lg-8 col-md-8 col-xs-8">
                        <input type="text" class="form-control mother search_username" name="mother_name" placeholder="Mothers Name" custom="8" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="mobile_number">Mobile Number</label>
                    <div class="col-lg-8 col-md-8 col-xs-8">
                        <input type="text" class="form-control mobile_number search" name="mobile_number" placeholder="Mobile number" custom="3"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="date_of_birth">DOB</label>
                    <div class="col-lg-8 col-md-8 col-xs-8">
                        <input id = "date_of_birth" type="text" class="dob form-control dp search_DOB" name="date_of_birth" placeholder="DOB" custom="4"/>
                    </div>
                </div>
                <div class="form-group villagediv">
                    <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="village">Village</label>
                    <div class="col-lg-8 col-md-8 col-xs-8">
                         <?php
                        
            echo $this->Form->input('village', array('id' => 'village',
                'label' => false,
                'div' => false,
                'legend' => false,
                'empty' => __d('label', '--Select--'),
                'class' => 'village combobox',
                'style' => '',
                'options' => $villages,
                'custom' => 5
            ));
            ?>
                        
                    </div>
                </div>
                
            </form>
        <div class="row">
			<div class="form-actions">
				<div class="col-lg-4 col-md-4 col-xs-4">&nbsp;</div>
				<div class="col-lg-8 col-md-8 col-xs-8">
					<button type="button" class="btn btn-primary addnew" data-first_name="<?php echo $name_parent;?>"><?php echo $buttonLabel;?></button>
                                        <button type="button" style="color: red" class="btn btn-link cancel">Cancel</button>
					<button type="button" style="color: red" class="btn btn-link clearfilter">Clear Filters</button>
				</div>
			</div>

        </div>
        </div>
        <div class="col-xs-12 col-md-8">
            <table id="all_users" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>Id</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Village</th>
                        <th>Phone</th>
                        <th>DOB</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php echo $this->Html->script(array('Family/search_people')); ?>
<script type="text/javascript">
 $(function () {
        $("#date_of_birth").datepicker({
            format: "dd/mm/yyyy",
        });
        $('.dp').on('change', function () {
            $('.datepicker').hide();
        });
       
    });
    
    
    var actiontype = '<?php echo $type;?>';
    var user_id = '<?php echo $fid;?>';
    var group_id = '<?php echo $gid;?>';
    
    $('.cancel').click(function(){
         if(  actiontype == 'addnew') {
              window.location.href = baseUrl +"/family/familiyGroups";
         } else {
             window.location.href = baseUrl +"/family/details/"+ group_id;
         }
    });
    
    
    $('.addnew').click(function(){
   
 var id = user_id;
 var gid = group_id;
 var first_name = $(this).data('first_name');
 var firstname = $.trim($('.first_name').val());
 var lastname = $.trim($('.last_name').val());
 var village = $.trim($('.village').val());
 var phone = $.trim($('.mobile_number').val());
 var dob = $.trim($('.dob').val()); 
 
 
 
   doFormPost(baseUrl+"/family/index?type=" + actiontype ,'{ "type":"'+ actiontype+'",\n\
"fid":"'+ id +'","gid":"'+ gid +'","name_parent":"'+ first_name +'","first_name":"'+ firstname +'",\n\
"last_name":"'+ lastname +'","date_of_birth":"'+ dob +'","mobile_number":"'+ phone +'","village":"'+ village +'"}');
});
</script>
