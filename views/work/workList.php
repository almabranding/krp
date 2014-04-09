<ul id="">
        <?foreach($this->works as $key=>$work){?>
    <li><a class="<?=($key+1==$this->work['work_id'] && $this->work)?'selected':''?>" href="<?=URL?>work/view/<?=$work['work_id']?>/<?=$work['name']?>" rel="<?= UPLOAD . Model::getRouteImg($work['photos'][0]['img_date']) .''. $work['photos'][0]['file_name']; ?>"><?=$work['name']?></a>
        <?}?>               
</ul>