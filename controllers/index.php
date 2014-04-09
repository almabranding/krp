<?php

class Index extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->js = array('index/js/modernizr.custom.86080.js');
        $this->view->css = array('index/css/style.css');
    }
    
   function index() {
       $this->view->bg=$this->model->getBg();
       $this->view->render('index/index');
    }
    
}