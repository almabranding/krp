<?php

class Archive extends Controller {
    function __construct() {
        parent::__construct();
        $this->view->js = array('archive/js/sly.min.js','archive/js/custom.js');
        $this->view->css = array('archive/css/style.css');
    }
    
    function index() {
        $this->view->works=$this->model->getWorks();
        $this->view->render('archive/index');
    }
    
    
}