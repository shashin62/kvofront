<div class="container-fluid">

<!-- Alert for all pages >
<div class="alert alert-success page-alert" id="alert">
	<button type="button" class="close"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
	<strong>Cool!</strong> This alert will close in 3 seconds. The data-delay attribute is in milliseconds.
</div>
<!-- Close Alert for all pages -->

	<div id="loginbox" class="col-md-6">
		<div class="panel panel-info">
			<div class="panel-heading">
				<div><a href="#" onClick="$('#loginbox').hide(); $('#forgotbox').show()" class="pull-right">Forgot password?</a></div>
				<div class="panel-title">Sign In</div>
			</div>
			<div class="panel-body">
				<form  class="form-horizontal" role="form" action="<?php echo FULL_BASE_URL . $this->base; ?>/user/login" role="form" id="UserLoginForm" method="post" accept-charset="utf-8">
					<div class="form-group">
						<label for="email" class="col-md-4 control-label">Mobile Number</label>
						<div class="col-md-8">
							<input type="text" class="form-control" name="data[People][mobile_number]" placeholder="Mobile number">
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="col-md-4 control-label">Password</label>
						<div class="col-md-8">
							<input type="password" name="data[People][password]" class="form-control" name="passwd" placeholder="Password">
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-4 col-md-8">
							<label>
								<input id="login-remember" type="checkbox" name="remember" value="1"> Remember me
							</label>
						</div>
					</div>
					<div class="form-group">
						<!-- Button -->                                        
						<div class="col-md-offset-4 col-md-8">
							<button id="btn-signup" type="submit" class="btn btn-info">Sign In</button> 
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-4 col-md-8 control">
							<div>
								Don't have an account! 
								<a href="#" onClick="$('#loginbox').hide(); $('#signupbox').show()">Sign Up Here</a>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div id="forgotbox" style="display:none" class="col-md-6">
		<div class="panel panel-info" >
			<div class="panel-heading">
				<div class="panel-title">Forgot password</div>
			</div>
			<div class="panel-body" >
				<form id="loginform" class="form-horizontal" role="form">
					<div class="form-group">
						<label for="email" class="col-md-4 control-label">Email</label>
						<div class="col-md-8">
							<input type="text" class="form-control" name="email" placeholder="Email Address">
						</div>
					</div>
					<div class="form-group">
						<!-- Button -->                                        
						<div class="col-md-offset-4 col-md-8">
							<button id="btn-signup" type="submit" class="btn btn-info">Submit</button> 
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-4 col-md-8 control">
							<div>
								Don't have an account! 
								<a href="#" onClick="$('#loginbox').hide(); $('#forgotbox').hide(); $('#signupbox').show()">
								Sign Up Here
								</a>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-4 col-md-8 control">
							<div>
								Have account? 
								<a href="#" onClick="$('#loginbox').show(); $('#forgotbox').hide(); $('#signupbox').hide()">
								Sign In
								</a>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div id="signupbox" style="display:none" class="col-md-6">
		<div class="panel panel-info">
			<div class="panel-heading">
				<div><a id="signinlink" href="#" onclick="$('#signupbox').hide(); $('#loginbox').show()" class="pull-right">Sign In</a></div>
				<div class="panel-title">Sign Up</div>
			</div>
			<div class="panel-body">
				<form  class="form-horizontal" role="form" action="<?php echo FULL_BASE_URL . $this->base; ?>/user/register" role="form" id="UserRegisterForm" method="post" accept-charset="utf-8">
					<div class="form-group">
						<label for="firstname" class="col-md-4 control-label">First Name</label>
						<div class="col-md-8">
							<?php echo $this->Form->input('first_name', array('id' => 'first_name', 'placeholder' => 'Enter First Name' ,'title' => '','div' => false, 'label' => false, 'class' => 'form-control')); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="lastname" class="col-md-4 control-label">Last Name</label>
						<div class="col-md-8">
							 <?php echo $this->Form->input('last_name', array('id' => 'last_name', 'placeholder' => 'Enter Last Name' ,'title' => '','div' => false, 'label' => false, 'class' => 'form-control')); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="col-md-4 control-label">Mobile</label>
						<div class="col-md-8">
							<?php echo $this->Form->input('mobile_number', array('id' => 'mobile_number', 'placeholder' => 'Enter mobile' ,'title' => '','div' => false, 'label' => false, 'class' => 'form-control')); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="email" class="col-md-4 control-label">Email</label>
						<div class="col-md-8">
							<?php echo $this->Form->input('email', array('id' => 'email', 'placeholder' => 'Enter email' ,'title' => '','div' => false, 'label' => false, 'class' => 'form-control')); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="email" class="col-md-4 control-label">Date of Birth</label>
						<div class="col-md-8">
							<?php echo $this->Form->input('date_of_birth', array('id' => 'date_of_birth', 'placeholder' => 'Enter DOB' ,'title' => '','div' => false, 'label' => false, 'class' => 'form-control')); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="email" class="col-md-4 control-label">Village</label>
						<div class="col-md-8">
							<?php echo $this->Form->input('village', array('id' => 'date_of_birth', 'placeholder' => 'Enter Village' ,'title' => '','div' => false, 'label' => false, 'class' => 'form-control')); ?>
						</div>
					</div>
					<div class="form-group">
						<!-- Button -->                                        
						<div class="col-md-offset-4 col-md-8">
							<button id="btn-signup" type="submit" class="btn btn-info">Sign Up</button> 
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-xs-6">
		<div class="panel panel-danger">
			<div class="panel-heading">
				Register now for <span class="text-success">FREE</span>
			</div>
			<div class="panel-body">
				<ul class="list-unstyled" style="line-height: 2">
					<li><span class="fa fa-check text-success"></span> See all your relatives</li>
					<li><span class="fa fa-check text-success"></span> Post Classifieds</li>
					<li><span class="fa fa-check text-success"></span> Matrimonial Help</li>
					<li><span class="fa fa-check text-success"></span> Share Media</li>
					<li><span class="fa fa-check text-success"></span> Stay in touch with the community</li>
					<li><a href="/faq/"><u>FAQ</u></a></li>
				</ul>
			</div>
		</div>
	</div>
</div>


