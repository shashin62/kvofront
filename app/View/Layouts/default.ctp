<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

 $selLanguage = 'english';
 if ($this->Session->check('Website.language')) {
     $selLanguage = $this->Session->read('Website.language');
 } 

?>
<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            KVO Front
        </title>
        <?php
        echo $this->Html->css(array('common', 'bootstrap.min', '/font-awesome-4.1.0/css/font-awesome.min',
            'dataTables.bootstrap',
            'bootstrapValidator.min',
            'datepicker.min',
            'bootstrap-select.min', 'jquery-ui.min', 'jquery-ui.theme.min'));
        ?>
        <?php
        echo $this->Html->script(array('jquery-1.11.1', 'common', 'bootstrap.min', 'jquery.validate', 'jquery-ui.min', 'combobox', 'autotab', 'jquery.imgareaselect.min'));
        ?>
        <script type="text/javascript" language="javascript" src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
        <!-- Bootstrap DataTables JavaScript -->
        <script type="text/javascript" language="javascript" src="//cdn.datatables.net/plug-ins/9dcbecd42ad/integration/bootstrap/3/dataTables.bootstrap.js"></script>
        <!-- Bootstrap validation JavaScript -->

        <!-- Bootstrap Datepicker JavaScript -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
        <!-- Bootstrap Select JavaScript -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/js/bootstrap-select.min.js"></script>
    </head>
    <body>
        <!-- Navigation -->
        <nav class="navbar navbar-default" role="navigation">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php  ($this->Session->read('Auth.User')) ? FULL_BASE_URL . $this->base.'/user/welcome' : FULL_BASE_URL . $this->base; ?>"><img src="<?php echo FULL_BASE_URL . $this->base; ?>/img/logo.png" height="30px"></a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav" id="right-top-links">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle animate" data-toggle="dropdown" role="button" aria-expanded="false">Activities <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#"><i class="fa fa-globe fa-fw"></i>About Us</a></li>
                                <li><a href="#">KVOS Jain Mahajan's Constitution</a></li>
                                <li><a href="#">Mission and Vission</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Interact <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Events</a></li>
                                <li><a href="#">Just Married</a></li>
                                <li><a href="#">Babies</a></li>
                                <li><a href="#">Obituaries</a></li>
                                <li><a href="#">New Members</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Community <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Matrimonial</a></li>
                                <li><a href="#">Classifieds</a></li>
                                <li><a href="#">Jobs</a></li>
                                <li><a href="<?php echo FULL_BASE_URL . $this->base. '/article';?>">Articles</a></li>
                                <li><a href="#">Community Pages</a></li>
                                <li><a href="#">Community Publications</a></li>
                            </ul>
                        </li>
                        <?php if ($this->Session->read('Auth.User')) { ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">My Account <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Media</a></li>
                                <li><a href="#">Profile</a></li>
                                <li><a href="#">My Family</a></li>
                            </ul>
                        </li>
                        <?php } ?>
                    </ul>
                    
                    <div class="btn-group control_types" data-toggle="buttons" style="margin-top: 5px;">
                        <label class="btn btn-default <?php echo ($selLanguage == 'english') ? 'active' : '';?>">
                            <input type="radio" name="web_lang" id="web_lang_english" value="english" <?php echo ($selLanguage == 'english') ? 'checked="checked"' : '';?>>English
                        </label>
                        <label class="btn btn-default <?php echo ($selLanguage == 'hindi') ? 'active' : '';?>">
                            <input type="radio" name="web_lang" id="web_lang_hindi" value="hindi" <?php echo ($selLanguage == 'hindi') ? 'checked="checked"' : '';?>>हिन्दी
                        </label>
                        <label class="btn btn-default <?php echo ($selLanguage == 'gujurati') ? 'active' : '';?>">
                            <input type="radio" name="web_lang" id="web_lang_gujurati" value="gujurati" <?php echo ($selLanguage == 'gujurati') ? 'checked="checked"' : '';?>>ગુજરાતી
                        </label>
                    </div>
                    
                    <ul class="nav navbar-nav navbar-right" id="right-top-links">
                        <?php if ($this->Session->read('Auth.User')) { ?>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-alerts">
                                <li>
                                    <a href="#">
                                        <div>
                                            <i class="fa fa-comment fa-fw"></i> New Comment
                                        </div>
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="#">
                                        <div>
                                            <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                        </div>
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="#">
                                        <div>
                                            <i class="fa fa-envelope fa-fw"></i> Message Sent
                                        </div>
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="#">
                                        <div>
                                            <i class="fa fa-tasks fa-fw"></i> New Task
                                        </div>
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="#">
                                        <div>
                                            <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                            <span class="pull-right text-muted small">4 minutes ago</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                            <!-- /.dropdown-alerts -->
                        </li>
                        <?php } ?>
                        <!-- /.dropdown -->
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <?php if ($this->Session->read('Auth.User')) { ?>
                                <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a></li>
                                <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a></li>
                                <li class="divider"></li>
                                <?php } ?>
                                <?php if (!$this->Session->read('Auth.User')) { ?>
                                <li><a href="<?php echo FULL_BASE_URL . $this->base . '/user/login'; ?>"><i class="fa fa-sign-in fa-fw"></i> Sign Up</a></li>
                                <li><a href="<?php echo FULL_BASE_URL . $this->base . '/user/login'; ?>"><i class="fa fa-sign-in fa-fw"></i> Login</a></li>
                                <?php } ?>
                                <?php if ($this->Session->read('Auth.User')) { ?>
                                <li><a href="<?php echo FULL_BASE_URL . $this->base . '/user/logout'; ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                                <?php } ?>
                            </ul>
                            <!-- /.dropdown-user -->
                        </li>
                        <!-- /.dropdown -->
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
        </nav>
        <!-- Navigation End -->
        <div class="container-fluid">
            <div id="customFlash" class="jssuccessMessage top_success" style="display: none"></div>
                <?php echo $this->Session->flash(); ?>

                <?php echo $this->fetch('content'); ?>
            
        </div>

        <script type="text/javascript">
            var baseUrl = '<?php echo FULL_BASE_URL . $this->base; ?>';
        </script>

        <!-- jQuery DataTables JavaScript -->

        <div class="modal hide" id="README">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3>README</h3>
            </div>

        </div>
    </body>
</html>
