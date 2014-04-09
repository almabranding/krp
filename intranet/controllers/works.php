<?php

class Works extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->js = array('works/js/custom.js');
        if(!Session::get('loggedIn')) header('location: '.URL);
    }
    function index() { 
        header('location: '.URL.'works/lista');  
    }
    public function updateFotos(){
        $this->model->updateFotos();
    }
    public function view($id=null) 
    {
        $this->view->work=$this->model->getWorks($id);
        $this->view->form=$this->model->form($id);
        $this->view->render('works/view');  
    }
    public function lista($pag=1) 
    {
        $this->view->list=$this->model->toTable($this->model->getWorks());
        $this->view->render('works/list');  
    }
    public function photos($id) 
    {
        $this->view->work=$id;
        $works=$this->model->getWorks($id);
        $this->view->work=$works;
        $this->view->photos=$works['photos'];
        $this->view->render('works/photos');  
    }
    public function addPhoto($id){
       $img=new upload;
       $img->uploadImg();
       $img->resizeImg(580, 'height');
       $this->model->addPhoto($id,$img->getImg());
    } 
    public function deletePhoto($id,$work) 
    {
        $this->model->deleteImage($id);
        header('location: ' . URL .LANG . '/works/photos/'.$work);  
    }
    public function add() 
    {
       $id=$this->model->add();
       header('location: ' . URL  . 'works/photos/'.$id);
    }
    public function edit($id) 
    {
        $this->model->edit($id);
        header('location: ' . URL  . 'works/lista');
    }
    public function delete($id) 
    {
        $this->model->delete($id);
        header('location: ' . URL  .  'works/lista');
    }
   
    public function sort() 
    {
        $this->model->sort();
    }
   
//    public function deleteImages() 
//    {
//        $this->model->deleteImages();
//    }
//    public function deleteImage($model_id,$id) 
//    {
//        $this->model->deleteImage($id);
//        header('location: ' . URL .LANG . '/models/editportafolio/'.$model_id);  
//    }
    public function selectHeadsheet($id) 
    {
        $this->model->selectHeadsheet($id);
    }
     public function saveInputs(){
        $this->model->saveInputs();
    }
    public function deleteSelected() 
    {
        $this->model->deleteSelected();
    }
    
}