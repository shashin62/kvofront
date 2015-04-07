<div class="container-fluid">
    <div class="row">
        <div class="media">
            <div class="media-body">
                <h4 class="media-heading"><?php echo $data['title']; ?></h4>
                <p class="text-right">By <?php echo $data['author']; ?></p>    
                <?php
                $imgSrc = 'http://placehold.it/600x400';
                
                $adminUrl = 'http://admin.kvomahajan.com/files/article/main/';
                if ($data['image']) {
                   $imgSrc =  $adminUrl.$data['image'];
                }
                ?>
                <img class="media-object" src="<?php echo $imgSrc; ?>" alt="<?php echo $data['title']; ?>">
                
                <p><?php echo $data['body']; ?></p>
            </div>
        </div>
    </div>
</div> 