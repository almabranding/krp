<?php
class Work extends Controller {
    function __construct() {
        parent::__construct();
        $this->view->js = array('work/js/sly.min.js','work/js/custom.js');
        $this->view->css = array('work/css/style.css');
    }
    function index() {
        $this->view->works=$this->model->getWorks();
        $this->view->render('work/index');
    }
    function view($id) {
        $this->view->works=$this->model->getWorks();
        $this->view->work=$this->model->getWorks($id);
        $this->view->render('work/gallery');
    }
    
    
}