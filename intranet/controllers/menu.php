<?php

class Menu extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->js = array('menu/js/custom.js');
        if(!Session::get('loggedIn')) header('location: '.URL);
    }
    function index() { 
        $this->view->menus = $this->model->getListByMenu();
        $this->view->render('menu/index');  
    }
    public function sort() 
    {
        $this->model->sort();
    }
}