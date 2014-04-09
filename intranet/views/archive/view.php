<div id="sectionHeader">
    <? if($this->work){ ?>
    <a href="<?=URL?>archive"><div id="arrowBack">Back to archive</div></a>
    <h1>Edit <?=$this->work['name'];?></h1>
     <div id="sectionNav">        
        <a href="<?= URL ?>archive/photos/<?= $this->work['archive_id'] ?>"><div class="btn blue" >Photos</div></a>
    </div>
    <? }else{?>
     <a href="<?=URL?>archive/lista"><div id="arrowBack">Back to works</div></a>
    <h1>Create work</h1>
    <?}?>
    <div class="clr"></div>
</div>
<div id="sectionContent">
    <?php $this->form->render(); ?>
</div>
