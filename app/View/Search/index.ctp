<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 col-offset-2">
			<h3><?php echo $peopleData['first_name'] . ' ' . $peopleData['last_name'];?></h3>
		</div>
	</div>
	<div class="col-md-2">
		<div class="panel panel-default">
			<div class="panel-heading">
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
	<div class="col-md-8">
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-info">
					<div class="panel-heading">
						<i class="fa fa-gear fa-fw pull-right"></i>
						<h4 class="panel-title">Personal Information</h4>
					</div>
					<div class="panel-body">
						<table class="table table-condensed table-responsive table-borderless">
							<tbody>
                                                            <tr>
									<td width="200">First name</td>
									<td><?php echo $peopleData['first_name'];?></td>
								</tr>
                                                            <tr>
									<td width="200">Last name</td>
									<td><?php echo $peopleData['last_name'];?></td>
								</tr>
                                                                <tr>
									<td width="200">Father</td>
									<td><?php echo $peopleData['father'];?></td>
								</tr>
                                                                <tr>
									<td width="200">Mother</td>
									<td><?php echo $peopleData['mother'];?></td>
								</tr>
								<tr>
									<td width="200">Sect</td>
									<td><?php echo $peopleData['sect'];?></td>
								</tr>
                                                                <tr>
									<td width="200">Village</td>
									<td><?php echo $peopleData['village'];?></td>
								</tr>
                                                                <tr>
									<td width="200">Mobile Number</td>
									<td><?php echo $peopleData['mobile_number'];?></td>
								</tr>
								<tr>
									<td>Date of Birth</td>
									<td><?php echo $peopleData['date_of_birth'];?></td>
								</tr>
                                                                <tr>
									<td width="200">Martial Status</td>
									<td><?php echo $peopleData['martial_status'];?></td>
								</tr>
                                                                <tr>
									<td width="200">Blood Group</td>
									<td><?php echo $peopleData['blood_group'];?></td>
								</tr>
								
								<tr>
									<td>Address</td>
									<td><?php echo $addressData['suburb'] .', ' . $addressData['suburb_zone'] . ', ' . $addressData['city'];?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-info">
					<div class="panel-heading">
						<i class="fa fa-gear fa-fw pull-right"></i>
						<h4 class="panel-title">Contact</h4>
					</div>
					<div class="panel-body">
						<table class="table table-condensed table-responsive table-borderless">
							<tbody>
								<tr>
									<td width="200">State</td>
									<td><?php echo $addressData['state'];?></td>
								</tr>
								<tr>
									<td>City</td>
									<td><?php echo $addressData['city'];?></td>
								</tr>
								<tr>
									<td>Suburb</td>
									<td><?php echo $addressData['suburb'];?></td>
								</tr>
								<tr>
									<td>Suburb Zone</td>
									<td><?php echo $addressData['suburb_zone'];?></td>
								</tr>
                                                                <tr>
									<td>Phone</td>
									<td><?php echo $peopleData['mobile_number'];?></td>
								</tr>
                                                                <tr>
									<td>Email</td>
									<td><?php echo $peopleData['email'];?></td>
								</tr>
                                                                <tr>
									<td>Zip Code</td>
									<td><?php echo $addressData['zip_code'];?></td>
								</tr>
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
						<i class="fa fa-gear fa-fw pull-right"></i>
						<h4 class="panel-title">Education</h4>
					</div>
					<div class="panel-body">
						<table class="table table-condensed table-responsive table-borderless">
							<tbody>
								<tr>
									<td>Education</td>
									<td><?php echo $peopleData['education_1'];?></td>
								</tr>
								
							</tbody>
						</table>
					</div>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="panel panel-info">
					<div class="panel-heading">
						<i class="fa fa-gear fa-fw pull-right"></i>
						<h4 class="panel-title">Business Information</h4>
					</div>
					<div class="panel-body">
						<table class="table table-condensed table-responsive table-borderless">
							<tbody>
                                                            <tr>
									<td width="200">Occupation</td>
									<td><?php echo $peopleData['occupation'];?></td>
								</tr>
								<tr>
									<td width="200">Nature of Business</td>
									<td><?php echo $peopleData['nature_of_business'];?></td>
								</tr>
								<tr>
									<td width="200">Type of Business</td>
									<td><?php echo $peopleData['business_name'];?></td>
								</tr>
								<tr>
									<td width="200">Specialty of Business</td>
									<td><?php echo $peopleData['specialty_business_service'];?></td>
								</tr>
								<tr>
									<td width="200">Business Name</td>
									<td><?php echo $peopleData['business_name'];?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-2">
		
	</div>
</div>
