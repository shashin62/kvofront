<div class="container-fluid">
    <div class="panel panel-info">
        <div class="panel-heading">
                <div>Change Password</div>
        </div>
        <div class="panel-body">
	<div id="loginbox" class="col-md-6">
		
                <form  class="form-horizontal" role="form" action="<?php echo FULL_BASE_URL . $this->base; ?>/user/changepassword" role="form" id="changePassword" name="changePassword" method="post" accept-charset="utf-8">
                        <div class="form-group">
                                <label for="old_pin" class="col-md-4 control-label">Old Password</label>
                                <div class="col-md-8">
                                        <input type="password" id="old_pin" class="form-control" name="data[People][old_pin]" placeholder="Old Password">
                                </div>
                        </div>
                        <div class="form-group">
                                <label for="pin" class="col-md-4 control-label">New Password</label>
                                <div class="col-md-8">
                                        <input type="password" id="pin" name="data[People][pin]" class="form-control" placeholder="New Password">
                                </div>
                        </div>
                        <div class="form-group">
                                <label for="cpin" class="col-md-4 control-label">Confirm Password</label>
                                <div class="col-md-8">
                                        <input type="password" id="cpin" name="data[People][cpin]" class="form-control" placeholder="Confirm Password">
                                </div>
                        </div>
                        <div class="form-group">
                                <!-- Button -->                                        
                                <div class="col-md-offset-4 col-md-8">
                                        <button id="btn-changepwd" type="button" class="btn btn-info btnsubmit changepwd">Submit</button> 
                                </div>
                        </div>
                </form>
	</div>
        </div>
</div>
	
</div>

<?php echo $this->Html->script(array('User/changepassword')); ?>

