<div class="container-fluid" id="content_view">
        
</div>
<div class="container-fluid">
    <div class="row text-center" id="page_pagination">
        
    </div>
</div>    
<div id="recTot" data="<?php echo ($recordsTotal) ? $recordsTotal : 0; ?>" style="display:none;"></div>
<?php echo $this->Html->script(array('customPaginate')); ?>
<?php echo $this->Html->script(array('Article/index')); ?>