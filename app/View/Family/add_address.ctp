<div class="container-fluid">
	<h3 class="heading">Add/Edit Address</h3>
    
	<?php echo $this->Form->create('Address', array('class' => 'form-horizontal addressForm', 'id' => 'addressForm', 'name' => 'address')); ?>
    
	<?php if ( $show ) { ?>
    <div class="row form-group">
		<div class="col-lg-6 col-md-6 col-xs-12">
			<div class="col-lg-4 col-md-4 col-xs-4">&nbsp;</div>
			<div class="col-lg-8 col-md-8 col-xs-8">
				<?php echo $this->Form->input("is_same", array('type' => "checkbox",'checked' => $parentaid == $aid ? 'checked' : '','class' => 'same_as', 'div' => false, "label" => array('class' => 'checkboxLabel', 'text' => __('Same as ' . $name . ' HOF')))); ?>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-xs-12">&nbsp;</div>
    </div>
	<br />
    <?php } ?>


	<div class="addresscontainer" style="<?php echo $parentaid == $aid && $parentid != $peopleid ? 'display:none': 'display:block';?>">
		<div class="row">
			<div class="col-lg-6 col-md-6 col-xs-12">
				<div class="form-group">
					<label class="col-lg-4 col-md-4 col-xs-4 control-label" for="ownership_type">Home Status</label>
					<div class="col-lg-8 col-md-8 col-xs-8">
						<div class="btn-group" data-toggle="buttons">
							<label class="btn btn-default <?php echo $ownership_type == 1 ? 'active' : '';?>">
								<input type="radio" class=ownership_type name="ownership_type" <?php echo $ownership_type == 1 ? 'checked=checked' : '';?> value="1">Ownership
							</label>
							<label class="btn btn-default <?php echo $ownership_type == 2 ? 'active' : '';?>">
								<input type="radio" class=ownership_type name="ownership_type" <?php echo $ownership_type == 2 ? 'checked=checked' : '';?> value="2">Leave & License
							</label>
							<label class="btn btn-default <?php echo $ownership_type == 3 ? 'active' : '';?>">
								<input type="radio" class=ownership_type name="ownership_type" <?php echo $ownership_type == 3 ? 'checked=checked' : '';?> value="3">Pagadi
							</label>
							<label class="btn btn-default <?php echo $ownership_type == 4 ? 'active' : '';?>">
								<input type="radio" class=ownership_type name="ownership_type" <?php echo $ownership_type == 4 ? 'checked=checked' : '';?> value="4">Other
							</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-4 col-md-4 col-xs-4 control-label" for="first_name">Total Number of Rooms</label>
					<div class="col-lg-8 col-md-8 col-xs-8">
						<?php echo $this->Form->input('rooms', array('id' => 'rooms','tabindex'=> '1','value'=> $rooms,'type' => 'text','placeholder' => 'Enter No. of Rooms' ,'title' => '','div' => false, 'label' => false, 'class' => 'form-control')); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-4 col-md-4 col-xs-4 control-label" for="wing">Wing</label>
					<div class="col-lg-8 col-md-8 col-xs-8">
						<?php echo $this->Form->input('wing', array('id' => 'wing', 'tabindex'=> '2', 'value'=> $wing,'placeholder' => 'Enter Wing' ,'title' => '','div' => false, 'label' => false, 'class' => 'form-control')); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-4 col-md-4 col-xs-4 control-label" for="room_number">Apartment No.</label>
					<div class="col-lg-8 col-md-8 col-xs-8">
						<?php echo $this->Form->input('room_number', array('id' => 'room_number','tabindex'=> '3','value'=> $room_number,'type' => 'text','placeholder' => 'Enter Apartment No.' ,'title' => '','div' => false, 'label' => false, 'class' => 'form-control')); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-4 col-md-4 col-xs-4 control-label" for="building_name">Building Name</label>
					<div class="col-lg-8 col-md-8 col-xs-8">
						<?php echo $this->Form->input('building_name', array('id' => 'building_name','tabindex'=> '4','value'=> $building_name,'type' => 'text', 'placeholder' => 'Enter Building Name' ,'title' => '','div' => false, 'label' => false, 'class' => 'form-control')); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-4 col-md-4 col-xs-4 control-label" for="complex_name">Complex Name</label>
					<div class="col-lg-8 col-md-8 col-xs-8">
						<?php echo $this->Form->input('complex_name', array('id' => 'complex_name','tabindex'=> '4','value'=> $complex_name,'type' => 'text', 'placeholder' => 'Enter Complex Name' ,'title' => '','div' => false, 'label' => false, 'class' => 'form-control')); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-4 col-md-4 col-xs-4 control-label" for="plot_number">Plot No.</label>
					<div class="col-lg-8 col-md-8 col-xs-8">
						<?php echo $this->Form->input('plot_number', array('id' => 'plot_number','tabindex'=> '5', 'value'=> $plot_number,'type' => 'text','placeholder' => 'Enter Plot No.' ,'title' => '','div' => false, 'label' => false, 'class' => 'form-control')); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-4 col-md-4 col-xs-4 control-label" for="road">Road</label>
					<div class="col-lg-8 col-md-8 col-xs-8">
						<?php echo $this->Form->input('road', array('id' => 'road', 'value'=> $road,'tabindex'=> '6','type' => 'text','placeholder' => 'Enter Road' ,'title' => '','div' => false, 'label' => false, 'class' => 'form-control road')); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-4 col-md-4 col-xs-4 control-label" for="cross_road">Cross Road</label>
					<div class="col-lg-8 col-md-8 col-xs-8">
						<?php echo $this->Form->input('cross_road', array('id' => 'cross_road','tabindex'=> '7', 'value'=> $cross_road,'type' => 'text','placeholder' => 'Enter Cross Road' ,'title' => '','div' => false, 'label' => false, 'class' => 'form-control')); ?>
					</div>
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-xs-12">
				<div class="form-group">
					<label class="col-lg-4 col-md-4 col-xs-4 control-label" for="zip_code">Pincode</label>   
					<div class="col-lg-8 col-md-8 col-xs-8">
						<?php echo $this->Form->input('zip_code', array('id' => 'zip_code','tabindex'=> '13', 'value'=> $zip_code,'type' => 'text','placeholder' => 'Enter Pincode' ,'title' => '','div' => false, 'label' => false, 'class' => 'form-control zipcode')); ?>
					</div>
				</div>
				<div class="form-group subrb suburbdiv">
					<label class="col-lg-4 col-md-4 col-xs-4 control-label" for="suburb">Suburb</label>   
					<div class="col-lg-8 col-md-8 col-xs-8">
					
					<?php

					echo $this->Form->input('suburb', array('id' => 'suburb',
					'label' => false,
					'div' => false,
					'legend' => false,
					'empty' => __d('label', '--Select--'),
					'class' => 'combobox suburb',
					'tabindex'=> '8',
					'style' => '',
					'options' => $suburbs,
					'value' => $suburb
					));
					?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-4 col-md-4 col-xs-4 control-label" for="suburb_zone">Suburb Zone</label>   
					<div class="col-lg-8 col-md-8 col-xs-8">
						<div class="btn-group zones" data-toggle="buttons">
							<label  class="btn btn-default <?php echo $suburb_zone == 'east' ? 'active' : '';?>">
							<input data-zone="east" tabindex= '9' type="radio" name="suburb_zone" <?php echo $suburb_zone == 'east' ? 'checked=checked' : '';?> value="east">East
							</label>
							<label  class="btn btn-default <?php echo $suburb_zone == 'west' ? 'active' : '';?>">
							<input data-zone="west" type="radio" name="suburb_zone" <?php echo $suburb_zone == 'west' ? 'checked=checked' : '';?> value="west">West
							</label>
							<label  class="btn btn-default <?php echo $suburb_zone == 'central' ? 'active' : '';?>">
							<input data-zone="central" type="radio" name="suburb_zone" <?php echo $suburb_zone == 'central' ? 'checked=checked' : '';?> value="central">Central
							</label>
							<label  class="btn btn-default <?php echo $suburb_zone == 'other' ? 'active' : '';?>">
							<input data-zone="other" type="radio" name="suburb_zone" <?php echo $suburb_zone == 'other' ? 'checked=checked' : '';?> value="other">Other
							</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-4 col-md-4 col-xs-4 control-label" for="city">City</label>   
					<div class="col-lg-8 col-md-8 col-xs-8">
						<?php echo $this->Form->input('city', array('id' => 'city','tabindex'=> '10','value'=> $city, 'placeholder' => 'Enter City' ,'title' => '','div' => false, 'label' => false, 'class' => 'form-control city')); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-4 col-md-4 col-xs-4 control-label" for="district">District</label>   
					<div class="col-lg-8 col-md-8 col-xs-8">
						<?php echo $this->Form->input('district', array('id' => 'district','tabindex'=> '11', 'value'=> $district,'placeholder' => 'Enter District' ,'title' => '','div' => false, 'label' => false, 'class' => 'form-control')); ?>
					</div>
				</div>
				<div class="form-group statediv">
					<label class="col-lg-4 col-md-4 col-xs-4 control-label" for="state">State</label>   
					<div class="col-lg-8 col-md-8 col-xs-8">
					<?php
					echo $this->Form->input('state', array('id' => 'state',
					'label' => false,
					'div' => false,
					'legend' => false,
					'empty' => __d('label', '--Select--'),
					'class' => 'combobox state',
					'tabindex'=> '12',
					'style' => '',
					'options' => $states,
					'value' => $state
					));
					?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-4 col-md-4 col-xs-4 control-label" for="std_code">STD Code</label>   
					<div class="col-lg-8 col-md-8 col-xs-8">
						<?php echo $this->Form->input('std_code', array('id' => 'std_code','tabindex'=> '14', 'value'=> $std_code,'type' => 'text','placeholder' => 'Enter STD Code' ,'title' => '','div' => false, 'label' => false, 'class' => 'form-control zipcode std_code')); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-4 col-md-4 col-xs-4 control-label" for="phone1">Home Phone</label>   
					<div class="col-lg-8 col-md-8 col-xs-8">
						<?php echo $this->Form->input('phone1', array('id' => 'phone1','tabindex'=> '15', 'value'=> $phone1,'type' => 'text','placeholder' => 'Enter Home phone' ,'title' => '','div' => false, 'label' => false, 'class' => 'form-control')); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-4 col-md-4 col-xs-4 control-label" for="phone2">Other Phone</label>   
					<div class="col-lg-8 col-md-8 col-xs-8">
						<?php echo $this->Form->input('phone2', array('id' => 'phone2', 'tabindex'=> '16','value'=> $phone2,'type' => 'text','placeholder' => 'Enter Other phone' ,'title' => '','div' => false, 'label' => false, 'class' => 'form-control')); ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-6 col-md-6 col-xs-12">
			<div class="form-actions">
				<div class="col-lg-4 col-md-4 col-xs-4">&nbsp;</div>
				<div class="col-lg-8 col-md-8 col-xs-8">
					<button type="button" class="btn btn-primary addressButton">Submit</button>
					<button type="button" style="color: red" class="btn btn-link cancel">Cancel</button>
				</div>
			</div>
		</div>
	</div>
    
<?php echo $this->Form->end(); ?>
</div>

<script type="text/javascript">
    $(function () {
        $('.state').val('<?php echo $state;?>');
        $('.statediv').find('.ui-autocomplete-input').val('<?php echo $state;?>');
        
       
             $( "#zip_code" ).autocomplete({
               source: baseUrl + "/family/getZipCodesData",
               select: function(e, ui) {
            var sname = ui.item.value;
            
            $.ajax({
        url: baseUrl + '/family/populateZipCodeData',
        dataType: 'json',
        data: {zipcode: sname},
        type: "POST",
        success: function (response) {
 $('.zones').find('.btn-default').removeClass('active');
           $( ".city" ).val(response.city);
           $( ".std_code" ).val(response.std);
           $( ".suburb" ).val(response.suburb);
           $( ".std_code" ).val(response.std);
           $('.state').val(response.state);
            $('.subrb').find('.ui-autocomplete-input').val(response.suburb);
            $('.statediv').find('.ui-autocomplete-input').val(response.state);
            
            $('.zones').find('[data-zone='+ response.zone +']').parent().addClass('active').attr('checked','checked');
            $('[data-zone='+ response.zone +']').attr('checked','checked');
        }
    });
           //TODO: Add AJAX webmethod call here and fill out entire form.

        }
            });
             });
    var aid = '<?php echo $addressid ? $addressid : ''; ?>';   
     var pid = '<?php echo $peopleid; ?>';
     var prntid = '<?php echo $parentid; ?>';
     var grpid = '<?php echo $gid; ?>';
     $('.cancel').click(function(){
        
             window.location.href = baseUrl +"/family/details/"+ grpid;
        
       
    });
    
    
</script>
<?php echo $this->Html->script(array('Family/add_address')); ?>
