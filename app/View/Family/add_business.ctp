<div class="container-fluid">
    <h3 class="heading">Add/Edit Business for <?php echo $memberName;?></h3>
    <?php echo $this->Form->create('Address', array('class' => 'form-horizontal addressForm', 'id' => 'addressForm', 'name' => 'address')); ?>
    <div class="row-fuild">
        <div class="col-lg-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="Occupation">Current Occupation</label>
                <div class="col-lg-8 col-md-8 col-xs-8">
                    <div class="btn-group occupations" data-toggle="buttons">
                        <label class="btn btn-default <?php echo $occupation == 'Self-Employed' ? 'active' : '';?>">
                            <input type="radio" name="occupation" class="occupation" <?php echo $occupation == 'Self-Employed' ? 'checked=checked' : '';?> value="Self-Employed">Self-Employed
                        </label>
                        <label class="btn btn-default <?php echo $occupation == 'Service' ? 'active' : '';?>">
                            <input type="radio" name="occupation" class="occupation" <?php echo $occupation == 'Service' ? 'checked=checked' : '';?> value="Service">Service
                        </label>
                        <label class="btn btn-default <?php echo $occupation == 'House Wife' ? 'active' : '';?>">
                            <input type="radio" name="occupation" class="occupation" <?php echo $occupation == 'House Wife' ? 'checked=checked' : '';?> value="House Wife">House Wife
                        </label>
                        <label class="btn btn-default <?php echo $occupation == 'Retired' ? 'active' : '';?>">
                            <input type="radio" name="occupation" class="occupation" <?php echo $occupation == 'Retired' ? 'checked=checked' : '';?> value="Retired">Retired
                        </label>
                        <label class="btn btn-default <?php echo $occupation == 'Studying' ? 'active' : '';?>">
                            <input type="radio" name="occupation" class="occupation" <?php echo $occupation == 'Studying' ? 'checked=checked' : '';?> value="Studying">Studying
                        </label>
                        <label class="btn btn-default <?php echo $occupation == 'Other' ? 'active' : '';?>">
                            <input type="radio" name="occupation" class="occupation" <?php echo $occupation == 'Other' ? 'checked=checked' : '';?> value="Other">Other
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group tohidecontainer">
                <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="specialty_business_service">Specialty Business/Service</label>
                <div class="col-lg-8 col-md-8 col-xs-8">
                        <?php echo $this->Form->input('specialty_business_service', array('id' => 'specialty_business_service', 'value'=> $specialty_business_service,'placeholder' => 'Enter specialty of business/service' ,'title' => '','div' => false, 'label' => false, 'class' => 'form-control')); ?>
                    <br />
                    E.g. Dentist, Children Clothing, 
                </div>
            </div>
        </div>
    </div>
    <div class="tohidecontainer">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-xs-12" >
                <div class="form-group">
                    <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="first_name">Type of Business/Service</label>
                    <div class="col-lg-8 col-md-8 col-xs-8">
                    <?php echo $this->Form->input('business_name', array('id' => 'business_name', 
                        'value'=> $business_name,'placeholder' => 'Enter type of business/service' ,'title' => '','div' => false, 
                        'label' => false, 'class' => 'form-control')); ?>
                        <br />
                        E.g. Wholesale, Retail, Manufacturing, Agent, Professional
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="first_name">Nature of Business/Service</label>
                    <div class="col-lg-8 col-md-8 col-xs-8">
                    <?php echo $this->Form->input('nature_of_business', array('id' => 'nature_of_business', 
                        'value'=> $nature_of_business,'placeholder' => 'Enter nature of business/service' ,'title' => '','div' => false, 
                        'label' => false, 'class' => 'form-control')); ?>
                        <br />
                        E.g. Readymade Garments, CA, Doctor
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="name_of_business">Name of Business/Service</label>
                    <div class="col-lg-8 col-md-8 col-xs-8">
                    <?php echo $this->Form->input('name_of_business', array('id' => 'name_of_business', 
                        'value'=> $nature_of_business,'placeholder' => 'Enter name of business/service' ,'title' => '','div' => false, 
                        'label' => false, 'class' => 'form-control')); ?>
                        <br />
                        E.g. ACME Inc., ACE Constructions.
                    </div>
                </div>
            </div>
        </div>
        <div>
       
        </div>
        
        <?php if( $isSetHomeAddress != 0 ) { ?>
        <div class="row form-group" >
            <div class="col-lg-6 col-md-6 col-xs-12">
                <div class="col-lg-4 col-md-4 col-xs-4">&nbsp;</div>
                <div class="col-lg-8 col-md-8 col-xs-8">
                   
                     <input checked="<?php echo $isSameChecked === 1 ? "checked" : "";?>" class="same_ashomeaddress" type="radio" name="data[Address][address_grp1]" value="is_same" /> Same as my home address
				
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-xs-12">&nbsp;</div>
        </div>
        <?php } ?>
      
        <div class="row form-group otherbusinessa">
            <div class="col-lg-6 col-md-6 col-xs-12">
                <div class="col-lg-4 col-md-4 col-xs-4">&nbsp;</div>
                <div class="col-lg-8 col-md-8 col-xs-8">
                   <?php //echo '---'. $busniessID;?>
                             <?php
                             $ids = array(); ?>
                               <?php if( $isHOF != "" ) { ?>
                            <?php foreach ( $busniessIds as $k => $value ) { ?>
                    <?php $ids[]  = $value['People']['business_address_id'];?>
                    <input class="other" type="radio" name=data[Address][address_grp1] value="<?php echo $value['People']['business_address_id']; ?>" /> Same as <?php  echo $value['People']['first_name']; ?>  ( <?php echo $value['address']['building_name'] . ', ' . $value['address']['complex_name'] . ', ' . $value['address']['plot_number']. ', ' .$value['address']['road'] . ', ' . $value['address']['suburb']. ', ' .$value['address']['suburb_zone'] . ', ' . $value['address']['city'] ;?>)<br />
                           <?php  } ?>
                      <?php } ?>
                    <input class="other" type="radio" name="data[Address][address_grp1]" value="other" /> Other
                </div>  
            </div>
            <div class="col-lg-6 col-md-6 col-xs-12">&nbsp;</div>
        </div>
      

        <div class="addresscontainer" style="<?php echo $isHOF == "" || !in_array($aid, $ids)  ? 'display: block' : 'display: none';?>">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="last_name">Wing</label>
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
                        <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="website">Building Name</label>
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
                        <label class="col-lg-4 col-md-4 col-xs-4 control-label">Plot No.</label>
                        <div class="col-lg-8 col-md-8 col-xs-8">
                        <?php echo $this->Form->input('plot_number', array('id' => 'plot_number','tabindex'=> '5', 'value'=> $plot_number,'type' => 'text','placeholder' => 'Enter Plot No' ,'title' => '','div' => false, 'label' => false, 'class' => 'form-control')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 col-md-4 col-xs-4 control-label">Road</label>
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
                        <label class="col-lg-4 col-md-4 col-xs-4 control-label">Pincode</label>   
                        <div class="col-lg-8 col-md-8 col-xs-8">
                        <?php echo $this->Form->input('zip_code', array('id' => 'zip_code','tabindex'=> '11', 'value'=> $zip_code,'type' => 'text','placeholder' => 'Enter Pincode' ,'title' => '','div' => false, 'label' => false, 'class' => 'form-control zipcode')); ?>
                        </div>
                    </div>
                    <div class="form-group  subrb suburbdiv">
                        <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="suburb">Suburb</label>   
                        <div class="col-lg-8 col-md-8 col-xs-8">
                         <?php
            echo $this->Form->input('suburb', array('id' => 'suburb',
                'label' => false,
                'div' => false,
                'legend' => false,
                'empty' => __d('label', '--Select--'),
                'class' => 'combobox suburb',
                'tabindex'=> '10',
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
                                <label class="btn btn-default <?php echo $suburb_zone == 'east' ? 'active' : '';?>">
                                    <input data-zone="east" type="radio" name="suburb_zone" <?php echo $suburb == 'east' ? 'checked=checked' : '';?> value="east">East
                                </label>
                                <label class="btn btn-default <?php echo $suburb_zone == 'west' ? 'active' : '';?>">
                                    <input data-zone="west" type="radio" name="suburb_zone" <?php echo $suburb == 'west' ? 'checked=checked' : '';?> value="west">West
                                </label>
                                <label class="btn btn-default <?php echo $suburb_zone == 'central' ? 'active' : '';?>">
                                    <input data-zone="central"  type="radio" name="suburb_zone" <?php echo $suburb == 'central' ? 'checked=checked' : '';?> value="central">Central
                                </label>
                                <label class="btn btn-default <?php echo $suburb_zone == 'other' ? 'active' : '';?>">
                                    <input data-zone="other" type="radio" name="suburb_zone" <?php echo $suburb_zone == 'other' ? 'checked=checked' : '';?> value="other">Other
                                </label>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="city">City</label>   
                        <div class="col-lg-8 col-md-8 col-xs-8">
                        <?php echo $this->Form->input('city', array('id' => 'city','tabindex'=> '8','value'=> $city, 'placeholder' => 'Enter City' ,'title' => '','div' => false, 'label' => false, 'class' => 'form-control city')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="district">District</label>   
                        <div class="col-lg-8 col-md-8 col-xs-8">
                        <?php echo $this->Form->input('district', array('id' => 'district','tabindex'=> '9', 'value'=> $district,'placeholder' => 'Enter District' ,'title' => '','div' => false, 'label' => false, 'class' => 'form-control')); ?>
                        </div>
                    </div>
                    <div class="form-group statesdiv">
                        <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="education">State</label>   
                        <div class="col-lg-8 col-md-8 col-xs-8">
                         <?php
            echo $this->Form->input('state', array('id' => 'state',
                'label' => false,
                'div' => false,
                'legend' => false,
                'class' => 'statescombo state',
                'tabindex'=> '10',
                'empty' => __d('label', '--Select--'),
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
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        <label class="col-lg-4 col-md-4 col-xs-4 control-label">Business Phone</label>   
                        <div class="col-lg-8 col-md-8 col-xs-8">
                        <?php echo $this->Form->input('phone1', array('id' => 'phone1','tabindex'=> '12', 'value'=> $phone1,'type' => 'text','placeholder' => 'Enter Business Phone' ,'title' => '','div' => false, 'label' => false, 'class' => 'form-control')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 col-md-4 col-xs-4 control-label">Other Phone</label>   
                        <div class="col-lg-8 col-md-8 col-xs-8">
                        <?php echo $this->Form->input('phone2', array('id' => 'phone2', 'tabindex'=> '13','value'=> $phone2,'type' => 'text','placeholder' => 'Enter Other Phone' ,'title' => '','div' => false, 'label' => false, 'class' => 'form-control')); ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
<br/>
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
    var pid = '<?php echo $peopleid; ?>';
    var aid = '<?php echo $aid; ?>';
    var prntid = '<?php echo $parentid; ?>';
    var paddressid = '<?php echo $parentaddressid;?>';
    var occupation = '<?php echo $occupation;?>';
    var grpid = '<?php echo $gid; ?>';
    $('.cancel').click(function () {

        window.location.href = baseUrl + "/family/details/" + grpid;


    });
    $(function () {
        $("#zip_code").autocomplete({
            source: baseUrl + "/family/getZipCodesData",
            select: function (e, ui) {
                var sname = ui.item.value;

                $.ajax({
                    url: baseUrl + '/family/populateZipCodeData',
                    dataType: 'json',
                    data: {zipcode: sname},
                    type: "POST",
                    success: function (response) {

                        $('.zones').find('.btn-default').removeClass('active')
                        $(".city").val(response.city);
                        $(".std_code").val(response.std);
                        $(".suburb").val(response.suburb);
                        $(".std_code").val(response.std);
                        $('.state').val(response.state);
                        $('.subrb').find('.ui-autocomplete-input').val(response.suburb);
                        $('.statesdiv').find('.ui-autocomplete-input').val(response.state);

                        $('.zones').find('[data-zone=' + response.zone + ']').parent().addClass('active').attr('checked', 'checked');
                        $('[data-zone=' + response.zone + ']').attr('checked', 'checked');
                    }
                });
                //TODO: Add AJAX webmethod call here and fill out entire form.

            }
        });
        $("#business_name").autocomplete({
            source: baseUrl + "/family/getTypeBusinessData"
        });

        $("#nature_of_business").autocomplete({
            source: baseUrl + "/family/getNatureBusinessData"
        });
        $("#specialty_business_service").autocomplete({
            source: baseUrl + "/family/getSpecialBusinessData"
        });
    });

</script>
<?php echo $this->Html->script(array('Family/add_busniess')); ?>