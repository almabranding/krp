<ul class="cb-slideshow">
    <? foreach ($this->bg as $bg) { ?>
    <li><span style="background-image: url('<?= UPLOAD . Model::getRouteImg($bg['img_date']) .'original/'. $bg['file_name']; ?>') "></span></li>
        <? } ?>
</ul>
