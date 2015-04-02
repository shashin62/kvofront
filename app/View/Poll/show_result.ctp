<?php
$progressbarClasses = array('progress-bar-danger', 'progress-bar-success', 'progress-bar-warning', 'progress-bar-info', 'progress-bar-active');

$i = 0;
foreach ($pollOptions as $option) {
    $i = ($i == 5) ? 0 : $i;
    $percentage = 0;
    if (isset($voteCounts[$option])) {
        $percentage = (100 * round($voteCounts[$option] / ($totalResult), 2));
    }
?>
<?php echo $option; ?><span class="pull-right"><?php echo $percentage; ?>%</span>
<div class="progress progress-striped active">
    <div class="progress-bar <?php echo $progressbarClasses[$i]; ?>" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percentage; ?>%">
        <span class="sr-only">40% Complete (success)</span>
    </div>
</div>
<?php
    $i++;
}
?>