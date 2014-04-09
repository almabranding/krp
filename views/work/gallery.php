<div id='galleryMovilMenu'>
    <div><?= $this->work['name'] ?></div><div class='grey'><a href='<?= URL ?>work'><?= $this->lang['backWorks'] ?></a></div>
</div>
<section id="work" class="">
    <div id='works_list' class='galleryMenu'><? include('workList.php') ?></div><div id='gallery'>
        <div class="wrap">
            <div class="frame" id="basic">
                <ul class="clearfix">
                    <? foreach ($this->work['photos'] as $photo) {
                        ?>
                        <li style='width: <?= $photo['width'] . 'px' ?>'><img  src='<?= UPLOAD . Model::getRouteImg($photo['img_date']) . $photo['file_name']; ?>'></li>
                    <? } ?>
                </ul>
                <div class='clr'></div>
                <div id="galleryInfo">
                    <h1><?= $this->work['name'] ?></h1>
                    <?= $this->work['content'] ?>
                </div>
            </div>
        </div>
    </div>
</section>