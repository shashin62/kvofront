<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">KVO Admin - Sign In</h3>
                </div>
                <div class="panel-body">
                    <form action="<?php echo FULL_BASE_URL . $this->base; ?>/user/login" role="form" id="UserLoginForm" method="post" accept-charset="utf-8">
                        <?php
                         if ($this->Session->check('Message.authlogin')) { ?>
                        <div class="alert alert-error"><?php echo  $this->Session->flash('authlogin');?></div>
                        <?php } ?>
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" autofocus placeholder="E-mail" name="data[User][email]" type="email" id="UserUsername">

                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="data[User][password]" type="password" id="UserPassword">
                            </div>
                            <input type="submit" class="btn btn-success btn-primary btn-small" value="Login">
                            <!--<a href="#/"><button type="submit" class="btn btn-link">Forgot Password?</button></a>-->
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
   
</script>
            