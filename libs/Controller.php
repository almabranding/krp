<?php
class Controller {
    
    function __construct() {
        $this->view = new View();
    }
    /**
     * 
     * @param string $name Name of the model
     * @param string $path Location of the models
     */
    public function loadModel($name,$control='', $modelPath = 'model/') {
        $path = $modelPath . $name.'_model.php';
        if (file_exists($path)) {
            if(!class_exists($name.'_Model'))require $modelPath .$name.'_model.php';
            $modelName = $name . '_Model';
            $this->model = new $modelName();
        }  
        
    }
    public function loadSingleModel($name, $modelPath = 'model/') {
        $path = $modelPath . $name.'_model.php';
        if (file_exists($path)) {
            if(!class_exists($name.'_Model')) require $modelPath .$name.'_model.php';
            $modelName = $name . '_Model';
            $model=new $modelName();
            return $model;
        }        
    }
    public function loadLang($_allowLang,$name=null) {
        $langPath='lang/'.LANG.'/';
        require $langPath .'default.php';
        $path = $langPath . $name.'.php';
        if (file_exists($path)) {
            require $path;
        }
        $this->setGlobal('_allowLang',$_allowLang);
        $this->setGlobal('lang',$lang);
    
    }
    public function setGlobal($var, $value) {
        $this->view->$var = $value;
        $this->model->$var = $value;
    }
    public function setModel($var, $value) {
        $this->model->$var = $value;
    }
    public function setView($var, $value) {
        $this->view->$var = $value;
    }

}