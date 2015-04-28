<div class="container-fluid">
    <div class="col-md-10">
        <div class="row">
        <div class="col-md-3 col-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                <?php echo $peopleData['first_name'] . ' ' . $peopleData['last_name'];?>
                </div>
            </div>
        </div>
        <div class="col-md-9 col-offset-2">
            <div class="panel panel-info">
                <div class="panel-body">
                    <?php foreach ($treeLinkageData as $key => $value) { ?>
                        <?php $i = 1; ?>


                        <span><?php echo $value; ?></span>



                        <?php $i++;
                    } ?>
                </div>
            </div>

        </div>
        </div>
        <div class="row">
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
                            <?php if( $this->Session->read('User.user_id') == $peopleData['id'] || ($this->Session->read('User.group_id') == $peopleData['group_id'] && $this->Session->read('Auth.User.tree_level') == '')) { ?><a href="<?php echo FULL_BASE_URL . $this->base. '/family/index?type=self&id='.$peopleData['id'].'&gid='.$peopleData['group_id'];?>" class="text-default"><i class="fa fa-gear fa-fw pull-right"></i></a><?php } ?>
				<h1 class="panel-title">Photo</h1>
			</div>
			<div class="panel-body">
                            
                            <?php if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/people_images/' . $peopleData['id'] .'.' . $peopleData['ext']) ===  true) { ?>
                            <img class="media-object img-responsive center-block" src="<?php echo $this->base;?>/people_images/<?php echo $peopleData['id'] .'.' . $peopleData['ext']; ?>">
                            <?php } else { ?>
				<img class="media-object img-responsive center-block" src="http://placehold.it/120x120">
                            <?php } ?>
			</div>
		</div>
	</div>
	<div class="col-md-9">
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-info">
					<div class="panel-heading">
                                            <?php if( $this->Session->read('User.user_id') == $peopleData['id'] || ($this->Session->read('User.group_id') == $peopleData['group_id'] && $this->Session->read('Auth.User.tree_level') == '')) { ?><a href="<?php echo FULL_BASE_URL . $this->base. '/family/index?type=self&id='.$peopleData['id'].'&gid='.$peopleData['group_id'];?>" class="text-info"><i class="fa fa-gear fa-fw pull-right"></i></a><?php } ?>
						<h4 class="panel-title">Personal Information</h4>
					</div>
					<div class="panel-body">
						<table class="table table-condensed table-responsive table-borderless">
							<tbody>
                                                               <?php if ($peopleData['first_name']) { ?>
                                                               <tr>
									<td width="200">First name</td>
									<td><?php echo $peopleData['first_name'];?></td>
								</tr>
                                                                <?php } ?>
                                                                <?php if ($peopleData['last_name']) { ?>
                                                                <tr>
									<td width="200">Last name</td>
									<td><?php echo $peopleData['last_name'];?></td>
								</tr>
                                                                <?php } ?>
                                                                <?php if ($peopleData['father']) { ?>
                                                                <tr>
									<td width="200">Father</td>
									<td><?php echo $peopleData['father'];?></td>
								</tr>
                                                                <?php } ?>
                                                                <?php if ($peopleData['mother']) { ?>
                                                                <tr>
									<td width="200">Mother</td>
									<td><?php echo $peopleData['mother'];?></td>
								</tr>
                                                                <?php } ?>
                                                                <?php if ($peopleData['sect']) { ?>
								<tr>
									<td width="200">Sect</td>
									<td><?php echo $peopleData['sect'];?></td>
								</tr>
                                                                <?php } ?>
                                                                <?php if ($peopleData['village']) { ?>
                                                                <tr>
									<td width="200">Village</td>
									<td><?php echo $peopleData['village'];?></td>
								</tr>
                                                                <?php } ?>
                                                                <?php if ($peopleData['mobile_number']) { ?>
                                                                <tr>
									<td width="200">Mobile Number</td>
									<td><?php echo $peopleData['mobile_number'];?></td>
								</tr>
                                                                <?php } ?>
                                                                <?php if ($peopleData['date_of_birth']) { ?>
								<tr>
									<td>Date of Birth</td>
									<td><?php echo $peopleData['date_of_birth'];?></td>
								</tr>
                                                                <?php } ?>
                                                                <?php if ($peopleData['martial_status']) { ?>
                                                                <tr>
									<td width="200">Martial Status</td>
									<td><?php echo $peopleData['martial_status'];?></td>
								</tr>
                                                                <?php } ?>
                                                                <?php if ($peopleData['blood_group']) { ?>
                                                                <tr>
									<td width="200">Blood Group</td>
									<td><?php echo $peopleData['blood_group'];?></td>
								</tr>
								<?php } ?>
                                                                <?php if ($addressData['suburb'] || $addressData['suburb_zone'] || $addressData['city']) { ?>
								<tr>
									<td>Address</td>
									<td><?php echo $addressData['suburb'] .', ' . $addressData['suburb_zone'] . ', ' . $addressData['city'];?></td>
								</tr>
                                                                <?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-info">
					<div class="panel-heading">
                                                <?php if( $this->Session->read('User.user_id') == $peopleData['id'] || ($this->Session->read('User.group_id') == $peopleData['group_id'] && $this->Session->read('Auth.User.tree_level') == '')) { ?><a href="<?php echo FULL_BASE_URL . $this->base. '/family/index?type=self&id='.$peopleData['id'].'&gid='.$peopleData['group_id'];?>" class="text-info"><i class="fa fa-gear fa-fw pull-right"></i></a><?php } ?>
						<h4 class="panel-title">Contact</h4>
					</div>
					<div class="panel-body">
						<table class="table table-condensed table-responsive table-borderless">
							<tbody>
                                                                <?php if ($addressData['state']) { ?>
								<tr>
									<td width="200">State</td>
									<td><?php echo $addressData['state'];?></td>
								</tr>
                                                                <?php } ?>
                                                                <?php if ($addressData['city']) { ?>
								<tr>
									<td>City</td>
									<td><?php echo $addressData['city'];?></td>
								</tr>
                                                                <?php } ?>
                                                                <?php if ($addressData['suburb']) { ?>
								<tr>
									<td>Suburb</td>
									<td><?php echo $addressData['suburb'];?></td>
								</tr>
                                                                <?php } ?>
                                                                <?php if ($addressData['suburb_zone']) { ?>
								<tr>
									<td>Suburb Zone</td>
									<td><?php echo $addressData['suburb_zone'];?></td>
								</tr>
                                                                <?php } ?>
                                                                <?php if ($addressData['mobile_number']) { ?>
                                                                <tr>
									<td>Phone</td>
									<td><?php echo $peopleData['mobile_number'];?></td>
								</tr>
                                                                <?php } ?>
                                                                <?php if ($addressData['email']) { ?>
                                                                <tr>
									<td>Email</td>
									<td><?php echo $peopleData['email'];?></td>
								</tr>
                                                                <?php } ?>
                                                                <?php if ($addressData['zip_code']) { ?>
                                                                <tr>
									<td>Zip Code</td>
									<td><?php echo $addressData['zip_code'];?></td>
								</tr>
                                                                <?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
                    <div class="col-md-6">
				<div class="panel panel-info">
					<div class="panel-heading">
                                                <?php if( $this->Session->read('User.user_id') == $peopleData['id'] || ($this->Session->read('User.group_id') == $peopleData['group_id'] && $this->Session->read('Auth.User.tree_level') == '')) { ?><a href="<?php echo FULL_BASE_URL . $this->base. '/family/index?type=self&id='.$peopleData['id'].'&gid='.$peopleData['group_id'];?>" class="text-info"><i class="fa fa-gear fa-fw pull-right"></i></a><?php } ?>
						<h4 class="panel-title">Education</h4>
					</div>
					<div class="panel-body">
						<table class="table table-condensed table-responsive table-borderless">
							<tbody>
                                                                <?php if ($peopleData['education_1']) { ?>
								<tr>
									<td>Education</td>
									<td><?php echo $peopleData['education_1'];?></td>
								</tr>
                                                                <?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="panel panel-info">
					<div class="panel-heading">
                                                <?php if( $this->Session->read('User.user_id') == $peopleData['id'] || ($this->Session->read('User.group_id') == $peopleData['group_id'] && $this->Session->read('Auth.User.tree_level') == '')) { ?><a href="<?php echo FULL_BASE_URL . $this->base. '/family/addBusiness?type=self&id='.$peopleData['id'].'&aid='.$peopleData['business_address_id'].'&gid='.$peopleData['group_id'];?>" class="text-info"><i class="fa fa-gear fa-fw pull-right"></i></a><?php } ?>
						<h4 class="panel-title">Business Information</h4>
					</div>
					<div class="panel-body">
						<table class="table table-condensed table-responsive table-borderless">
							<tbody>
                                                                <?php if ($peopleData['occupation']) { ?>
                                                                <tr>
									<td width="200">Occupation</td>
									<td><?php echo $peopleData['occupation'];?></td>
								</tr>
                                                                <?php } ?>
                                                                <?php if ($peopleData['nature_of_business']) { ?>
								<tr>
									<td width="200">Nature of Business</td>
									<td><?php echo $peopleData['nature_of_business'];?></td>
								</tr>
                                                                <?php } ?>
                                                                <?php if ($peopleData['business_name']) { ?>
								<tr>
									<td width="200">Type of Business</td>
									<td><?php echo $peopleData['business_name'];?></td>
								</tr>
                                                                <?php } ?>
                                                                <?php if ($peopleData['specialty_business_service']) { ?>
								<tr>
									<td width="200">Specialty of Business</td>
									<td><?php echo $peopleData['specialty_business_service'];?></td>
								</tr>
                                                                <?php } ?>
                                                                <?php if ($peopleData['business_name']) { ?>
								<tr>
									<td width="200">Business Name</td>
									<td><?php echo $peopleData['business_name'];?></td>
								</tr>
                                                                <?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
        </div>
    </div>
    <div class="col-md-2">
        <?php echo $this->element('votes');?>
    </div>
</div>
