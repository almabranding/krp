<section id="archive">    
    <? foreach ($this->works as $work) { ?>
   <div class="wrap">
        <div class="frame basic">
            <ul class="clearfix">
                <? foreach ($work['photos'] as $photo) { 
                    ?>
                <li style='width: <?=  $photo['width'].'px'?>'><img src='<?= UPLOAD . Model::getRouteImg($photo['img_date']) . $photo['file_name']; ?>'></li>
                <? } ?>
            </ul>
        </div>
                 </div>
       <? } ?>
</section>

