<div class="container">
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Welcome to KVO Admin</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
<div class="row">

<div class="col-lg-6 col-md-6 col-xs-12">	
                 <div class="form-group">
                    <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="phone_number">Last Week Completed Record(s)</label>
                    <div class="col-lg-8 col-md-8 col-xs-8">
                        <?php
                        if ( count($completedCountThisWeek)) {
                            foreach ( $completedCountThisWeek as $k => $v) {?>
                            <span><?php echo $v['name'];?></span> (<?php echo $v['count'];?>)<br />
                    <?php } } else { ?>
                        NA
                    <?php } ?>
                    </div>
                </div>                
            </div>
<div class="col-lg-6 col-md-6 col-xs-12">
                <div class="form-group">
                    <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="first_name">Current Week Record(s)</label>
                    <div class="col-lg-8 col-md-8 col-xs-8">
                        <?php foreach ( $enteredCount as $k => $v) {?>
                            <span><?php echo $v['name'];?></span>(<?php echo $v['count'];?>)<br />
                    <?php } ?>
                    </div>
                </div>
            </div>
<div class="col-lg-6 col-md-6 col-xs-12">
                <div class="form-group">
                    <label class="col-lg-4 col-md-4 col-xs-4 control-label" for="first_name">Incomplete Record(s)</label>
                    <div class="col-lg-8 col-md-8 col-xs-8">
                        <?php foreach ( $incompletedCount as $k => $v) {?>
                            <span><?php echo $v['name'];?></span>(<?php echo $v['count'];?>)<br />
                    <?php } ?>
                    </div>
                </div>
            </div>
</div>
</div>
<div class="container-fluid">   
<h3 class="heading">Members to be called again</h3>
<table id="callAgain" class="display" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Mobile</th>
    </tr>
    </thead>
    <tbody>

    </tbody>
</table>
    </div>
<?php echo $this->Html->script(array('Family/call_again')); ?>