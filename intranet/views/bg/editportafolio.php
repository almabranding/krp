<div id="sectionHeader">
    <h1>Background</h1>
    <div id="sectionNav">
        <div class="btn grey" onclick="showPop('newImage');" >Add new photo</div>
    </div>
    <div class="clr"></div>
</div>
<div id="sectionContent">
    <div>
        <ul id="sortable" class="ui-sortable sortable modelListImages" rel="cosa">
            <?php
            foreach ($this->modelPhotos as $key => $value) {
                ?>
                <li id="foo_<?=$value['photo_id']; ?>" class="ui-state-default modelList <?= ($value['main']) ? 'mainPic' : '' ?>" onclick="">
                    <input value="<?=$value['photo_id']; ?>" name="check[]" class="checkFoto" type="checkbox">
                    <img width="154" height="207" class="listImage" caption="<?=$value['caption']; ?>" src="<?= URL . UPLOAD . Model::getRouteImg($value['img_date']) . 'thumb_' . $value['file_name'] . $strNoCache; ?>"/>
                    <a target="_blank" href="<?= URL . UPLOAD . Model::getRouteImg($value['img_date']) . $value['file_name']; ?>"><input id="h1096" class="btnSmall" type="button" value="View" ></a>
                    <input class="btnSmall btnDelete" type="button" value="Delete" onclick="secureMsg('Do you want to delete this photo?', '/bg/deletePhoto/<?= $value['photo_id'] ?>');">
                </li>
            <?php } ?>
        </ul>
    </div>
</div>
<div class="white_box hide" id="newImage" style="width:auto;left:30%;position:absolute;">
    <? $this->viewUploadFile('bg/addPhoto/' . $this->id); ?>
</div>
