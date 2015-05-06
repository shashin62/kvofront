<div class="container-fluid">
    <h3 class="heading">Add/Edit Education for <?php echo $peopleName; ?></h3>
    <?php echo $this->Form->create('PeopleEducation', array('class' => 'form-horizontal educationForm', 'id' => 'educationForm', 'name' => 'education')); ?>

    <div class="col-md-4">	
        <form class="form-horizontal addUser">
            <div class="form-group">
                <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="name">Degree</label>
                <div class="col-lg-8 col-md-8 col-xs-8">
                    <?php
                        echo $this->Form->input('name', array('id' => 'name',
                        'label' => false,
                        'div' => false,
                        'legend' => false,
                        'empty' => __d('label', '--Select--'),    
                        'class' => 'degree form-control',
                        'style' => '',
                        'options' => $degrees,
                        //'value' => $degrees
                        ));
                     ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="institution_name">Name of Institute</label>
                <div class="col-lg-8 col-md-8 col-xs-8">
                    <input type="text" class="form-control institution_name" name="data[PeopleEducation][institution_name]" id="institution_name" placeholder="Name of Institute" custom="2" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="university_name">Name of University</label>
                <div class="col-lg-8 col-md-8 col-xs-8">
                    <input type="text" class="form-control university_name" name="data[PeopleEducation][university_name]" id="university_name" placeholder="Name of University" custom="2" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="area_specialization">Area of Specialization</label>
                <div class="col-lg-8 col-md-8 col-xs-8">
                    <input type="text" class="form-control area_specialization" name="data[PeopleEducation][area_specialization]" id="area_specialization" placeholder="Area of Specialization" custom="2" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="year_of_passing">Year of Passing</label>
                <div class="col-lg-8 col-md-8 col-xs-8">
                    <input type="text" class="form-control year_of_passing" name="data[PeopleEducation][year_of_passing]" id="year_of_passing" placeholder="Year of Passing" custom="2" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="percentage">Percentage of Marks</label>
                <div class="col-lg-8 col-md-8 col-xs-8">
                    <input type="text" class="form-control percentage" name="data[PeopleEducation][percentage]" id="percentage" placeholder="Percentage of Marks" custom="2" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="part_full_time">Full Time/Part Time</label>
                <div class="col-lg-8 col-md-8 col-xs-8">
                    <input type="radio" class="part_full_time" value="Full" name="data[PeopleEducation][part_full_time]" id="part_full_time_full"  />&nbsp;Full Time
                    <input type="radio" class="part_full_time" value="Part" name="data[PeopleEducation][part_full_time]" id="part_full_time_part"  />&nbsp;Part Time
                </div>
            </div>
        <div class="row">
            <div class="form-actions">
                <div class="col-lg-4 col-md-4 col-xs-4">&nbsp;<input type="hidden" name="data[PeopleEducation][id]" id="id" /><input type="hidden" name="data[PeopleEducation][group_id]" id="group_id" value="<?php echo $groupId;?>"/><input type="hidden" name="data[PeopleEducation][people_id]" id="people_id" value="<?php echo $peopleId; ?>" /></div>
                <div class="col-lg-8 col-md-8 col-xs-8">
                    <?php $typetext = str_replace('add', ' ', $type); ?>
                    <button type="button" class="btn btn-primary addnew "><?php echo 'Submit'; ?></button>
                    <button type="button" style="color: red" class="btn btn-link cancel">Cancel</button>
                </div>
            </div>

        </div>
        </form>    
    </div>
    <div class="col-xs-12 col-md-8">
        <table id="all_degrees" class="display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Degree</th>
                    <th>Institution</th>
                    <th>University</th>
                    <th>Specialization</th>
                    <th>Year</th>
                    <th>Marks</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>



</div>

<?php echo $this->Html->script(array('Family/add_education')); ?>