<?php 
$controlType = strtolower($pollData['control_type']);
if (!$controlType) {
    $controlType = 'radio';
}
?>
<div class="col-md-3">
    <form name="frmPoll" id="frmPoll">
    <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <?php echo $pollData['name']; ?>
                </h3>
            </div>
            <div class="panel-body pollbody">
                <ul class="list-group">
                    <?php
                    for ($i = 0; $i < $pollData['ans_no']; $i++) {
                        ?>
                        <li class="list-group-item">
                            <div class="radio">
                                <label><input type="<?php echo $controlType; ?>" name="poll_answer" value="<?php echo $pollData['answers'][$i]; ?>"><?php echo $pollData['answers'][$i]; ?></label>
                            </div>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <div class="panel-footer pollfoot">
                <input type="hidden" id="id" name="id" value="<?php echo $pollData['id']; ?>" />
                <input type="hidden" id="control_type" name="control_type" value="<?php echo $controlType; ?>" />
                <button type="button" class="btn btn-primary btn-sm" id="btnVote" name="btnVote"><span class="glyphicon glyphicon-ok"></span> Vote</button>
                <a href="javascript: showResult(<?php echo $pollData['id']; ?>)" class="pull-right"> View result</a>
            </div>
        </form>
    </div>
</div>
<?php echo $this->Html->script(array('Poll/index')); ?>