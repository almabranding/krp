<section id="work" class="">
    <div id='works_list'><?include('workList.php')?></div><div id="imagePreview">
        <img src="<?= UPLOAD . Model::getRouteImg($this->works[0]['photos'][0]['img_date']) .'thumb_'. $this->works[0]['photos'][0]['file_name']; ?>">
    </div>
</section>