<div class="container-fluid">
	<h3 class="heading"><?php echo $pageTitle;?></h3>
	<?php echo $this->Form->create('People', array('class' => 'form-horizontal peopleForm', 'id' => 'createFamily', 'name' => 'register')); ?>

	<div class="row">
		<div class="col-lg-6 col-md-6 col-xs-12">
			<?php if( $userType == 'addnew' || ($call_again === false || $call_again === true)) { ?>
			<div class="form-group">
				<label class="col-lg-4 col-md-4 col-xs-4 control-label" for="call_again">Call Again</label>
				<div class="col-lg-8 col-md-8 col-xs-8">
					<?php echo $this->Form->input("call_again", array('type' => "checkbox", 'checked' => $call_again == 1 ? 'checked' : '','div' => false, "label" => false)); ?>
				</div>
			</div>

			<?php } else  { ?>
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
						<label class="btn btn-default <?php echo $sect == 'deravasi' ? 'active' : '';?>">
							<input type="radio" name="sect" <?php echo $sect == 'deravasi' ? 'checked=checked' : '';?> value="deravasi">Deravasi
						</label>
						<label class="btn btn-default <?php echo $sect == 'sthanakvasi' ? 'active' : '';?>">
							<input type="radio" name="sect" <?php echo $sect == 'sthanakvasi' ? 'checked=checked' : '';?> value="sthanakvasi">Sthanakvasi
						</label>
						<label class="btn btn-default <?php echo $sect == 'other' ? 'active' : '';?>">
							<input type="radio" name="sect" <?php echo $sect == 'other' ? 'checked=checked' : '';?> value="other">Other
						</label>
					</div>
				</div>
			</div>


			<div class="form-group required">
				<label class="col-lg-4 col-md-4 col-xs-4 control-label" for="gender">Gender</label>   
				<div class="col-lg-8 col-md-8 col-xs-8">
					<div class="btn-group genders" data-toggle="buttons">
						<label class="btn btn-default <?php echo $gender == 'male' ? 'active' : '';?>">
							<input type="radio" name="gender" class="gender" <?php echo $gender == 'male' ? 'checked=checked' : '';?> value="male">Male
						</label>
						<label class="btn btn-default <?php echo $gender == 'female' ? 'active' : '';?>">
							<input type="radio" name="gender" class="gender" <?php echo $gender == 'female' ? 'checked=checked' : '';?> value="female">Female
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
        </div>

		<div class="col-lg-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label class="col-lg-4 col-md-4 col-xs-4 control-label" for="is_late">Late</label>
				<div class="col-lg-8 col-md-8 col-xs-8">
					<?php echo $this->Form->input("is_late", array('type' => "checkbox", 'checked' => $is_late == 1 ? 'checked' : '','div' => false, 'label' => false,)); ?>
				</div>
			</div>

			<div style="display: none;" class="form-group dd">
				<label class="col-lg-4 col-md-4 col-xs-4 control-label" for="date_of_death">Death Date</label>   
				<div class="col-lg-8 col-md-8 col-xs-8">
					<?php echo $this->Form->input('date_of_death', array('id' => 'date_of_death', 'placeholder' => 'enter in dd/mm/yyyy format' ,'type' => 'text','value'=> $date_of_death,'title' => '','div' => false, 'label' => false, 'class' => 'dp form-control date_of_death')); ?>
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
				<label class="col-lg-4 col-md-4 col-xs-4 control-label" for="call_again">Non KVO Family</label>
				<div class="col-lg-8 col-md-8 col-xs-8">
					<?php echo $this->Form->input("non_kvo", array('type' => "checkbox", 'checked' => $non_kvo == 1 ? 'checked' : '','div' => false, "label" => false)); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-4 col-md-4 col-xs-4 control-label" for="mahajan_membership_number">Mahajan #</label>   
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

			<div class="form-group education1_div">
				<label class="col-lg-4 col-md-4 col-xs-4 control-label" for="education">Education 1</label>   
				<div class="col-lg-4 col-md-4 col-xs-4">

				<?php

				echo $this->Form->input('education_1', array('id' => 'education_1',
				'label' => false,
				'div' => false,
				'legend' => false,
				'class' => 'combobox',
				'style' => '',
				'empty' => __d('label', '--Select--'),
				'options' => $educations,
				'value' => $education_1

				));
				?>
				</div>
				<div class="col-lg-4 col-md-4 col-xs-4">
					<?php echo $this->Form->input('year_of_passing_1', array('id' => 'year_of_passing_1','type' => 'tetfield', 'value'=> $year_of_passing_1,'placeholder' => 'Enter Year of passing' ,'title' => '','div' => false, 'label' => false, 'class' => 'phone_number form-control')); ?>
				</div>
			</div>

			<div class="form-group education2_div">
				<label class="col-lg-4 col-md-4 col-xs-4 control-label" for="education">Education 2</label>
				<div class="col-lg-4 col-md-4 col-xs-4">

				<?php

				echo $this->Form->input('education_2', array('id' => 'education_2',
				'label' => false,
				'div' => false,
				'legend' => false,
				'class' => 'combobox',
				'style' => '',
				'empty' => __d('label', '--Select--'),
				'options' => $educations,
				'value' => $education_2
				));
				?>
				</div>
				<div class="col-lg-4 col-md-4 col-xs-4">
					<?php echo $this->Form->input('year_of_passing_2', array('id' => 'year_of_passing_2','type' => 'tetfield', 'value'=> $year_of_passing_2,'placeholder' => 'Enter Year of passing' ,'title' => '','div' => false, 'label' => false, 'class' => 'phone_number form-control')); ?>
				</div>
			</div>

			<div class="form-group education3_div">
				<label class="col-lg-4 col-md-4 col-xs-4 control-label" for="education">Education 3</label>   
				<div class="col-lg-4 col-md-4 col-xs-4">

				<?php

				echo $this->Form->input('education_3', array('id' => 'education_3',
				'label' => false,
				'div' => false,
				'legend' => false,
				'class' => 'combobox',
				'style' => '',
				'empty' => __d('label', '--Select--'),
				'options' => $educations,
				'value' => $education_3

				));
				?>
				</div>
				<div class="col-lg-4 col-md-4 col-xs-4">
					<?php echo $this->Form->input('year_of_passing_2', array('id' => 'year_of_passing_2','type' => 'tetfield', 'value'=> $year_of_passing_2,'placeholder' => 'Enter Year of passing' ,'title' => '','div' => false, 'label' => false, 'class' => 'phone_number form-control')); ?>
				</div>
			</div>

			<div class="form-group education4_div">
				<label class="col-lg-4 col-md-4 col-xs-4 control-label" for="education">Education 4</label>
				<div class="col-lg-4 col-md-4 col-xs-4">
				
				<?php

				echo $this->Form->input('education_4', array('id' => 'education_4',
				'label' => false,
				'div' => false,
				'legend' => false,
				'class' => 'combobox',
				'style' => '',
				'empty' => __d('label', '--Select--'),
				'options' => $educations,
				'value' => $education_4

				));
				?>
				</div>
				<div class="col-lg-4 col-md-4 col-xs-4">
					<?php echo $this->Form->input('year_of_passing_4', array('id' => 'year_of_passing_4','type' => 'tetfield', 'value'=> $year_of_passing_4,'placeholder' => 'Enter Year of passing' ,'title' => '','div' => false, 'label' => false, 'class' => 'phone_number form-control')); ?>
				</div>
			</div>

			<div class="form-group education5_div">
				<label class="col-lg-4 col-md-4 col-xs-4 control-label" for="education">Education 5</label>
				<div class="col-lg-4 col-md-4 col-xs-4">
				
				<?php

				echo $this->Form->input('education_5', array('id' => 'education_5',
				'label' => false,
				'div' => false,
				'legend' => false,
				'class' => 'combobox',
				'style' => '',
				'empty' => __d('label', '--Select--'),
				'options' => $educations,
				'value' => $education_5

				));
				?>

				</div>
				<div class="col-lg-4 col-md-4 col-xs-4">
					<?php echo $this->Form->input('year_of_passing_5', array('id' => 'year_of_passing_5','type' => 'tetfield', 'value'=> $year_of_passing_5,'placeholder' => 'Enter Year of passing' ,'title' => '','div' => false, 'label' => false, 'class' => 'phone_number form-control')); ?>
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

<script type="text/javascript">
    var pid = '<?php echo $pid; ?>';
    var userType = '<?php echo $userType; ?>';
    var grpid = '<?php echo $gid; ?>';
    var is_late = '<?php echo $is_late; ?>';
    var gender = '<?php echo $gender;?>';
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
         if(  userType == 'addnew') {
              window.location.href = baseUrl +"/family/familiyGroups";
         } else {
             window.location.href = baseUrl +"/family/details/"+ grpid;
         }
       
    });
</script>
<?php echo $this->Html->script(array('Family/family_self_edit')); ?>