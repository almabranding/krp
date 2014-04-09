<?php

class Bg extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->js = array('bg/js/custom.js');
        if(!Session::get('loggedIn')) header('location: '.URL);
    }
    function index() { 
        header('location: '.URL.'bg/lista');  
    }
    public function lista($id) 
    {
        $this->view->modelPhotos=$this->model->getBg();
        $this->view->id=$id;
        $this->view->render('bg/editportafolio');  
    }
    public function addPhoto(){
       $img=new upload;
       $img->uploadImg();
       $this->model->addPhoto($img->getImg());
    }
    public function editPhoto($id) 
    {
        $this->model->editPhoto($id);
        header('location: ' . URL . 'bg/lista/');  
    }
    public function deletePhoto($id) 
    {
        $this->model->deletePhoto($id);
        header('location: ' . URL .  'bg/lista/');
    }
    
    
}