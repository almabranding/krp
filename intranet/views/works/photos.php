<div id="sectionHeader">
    <a href="<?=URL?>works"><div id="arrowBack">Back to works</div></a>
    <h1><?= $this->work['name'] ?></h1>
    <div id="sectionNav">        
        <a href="<?= URL ?>works/view/<?= $this->work['work_id'] ?>"><div class="btn grey" >Edit work</div></a>
        <div class="btn grey" onclick="showPop('newImage');" >Add new photo</div>
        <div class="btn red" id="deleteSelected">Delete photo</div>
        <div class="btn blue" id="selectHeadsheet">Use as a cover</div>
        <div class="btn blue" id="saveInputs">Save</div>
    </div>
    <div class="clr"></div>
</div>
<div id="sectionContent">
    <div>
        <ul id="sortable" class="ui-sortable sortable modelListImages" rel="cosa">
            <?php
            foreach ($this->photos as $key => $value) {;
                ?>
                <li id="foo_<?=$value['photo_id']; ?>" class="ui-state-default modelList <?= ($value['main']) ? 'mainPic' : '' ?>" onclick="">
                    <input value="<?=$value['photo_id']; ?>" name="check[]" class="checkFoto" type="checkbox">
                    <img width="154" height="207" class="listImage" caption="<?=$value['caption']; ?>" src="<?= URL . UPLOAD . Model::getRouteImg($value['img_date']) . 'thumb_' . $value['file_name'] . $strNoCache; ?>"/>
                   <p><?=$value['file_name']; ?></p>
                    <textarea rows="4" cols="50" name="caption[<?=$value['photo_id']; ?>]" class='inputSmall'><?=$value['caption']?></textarea>
                     <a target="_blank" href="<?= URL . UPLOAD . Model::getRouteImg($value['img_date']) . $value['file_name']; ?>"><input id="h1096" class="btnSmall" type="button" value="View" ></a>
                    <input class="btnSmall btnDelete" type="button" value="Delete" onclick="secureMsg('Do you want to delete this photo?', '/works/deletePhoto/<?= $value['photo_id'] ?>/<?= $this->work['work_id'] ?>');">
                </li>
            <?php } ?>
        </ul>
    </div>
</div>
<div class="white_box hide" id="newImage" style="width:auto;left:30%;position:absolute;">
    <? $this->viewUploadFile('works/addPhoto/' . $this->work['work_id']); ?>
</div>
<input id="id" value="<?=$this->work['work_id']?>" type="hidden">