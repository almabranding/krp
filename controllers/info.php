<?php
class Info extends Controller {
    function __construct() {
        parent::__construct();
        $this->view->js = array();
        $this->view->css = array();
    }
    
    function index() {
        $this->view->info=$this->model->getInfo();
        $this->view->render('page/info');
    }
    
    
}
