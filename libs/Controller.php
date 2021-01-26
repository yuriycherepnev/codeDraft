<?php
//главный контроллер для подключения рендеринга, классов для работы с бд и т.д.

class Controller {
    function __construct(){
        $this->view = new View;
    }
    public function loadModel($name){
        $path = SITE_ROOT . '/model/' . $name . 'Model.php';
        $modelName = $name . 'Model';

        if (file_exists($path)) {
            require_once $path;
            $this->model = new $modelName;
        }
    }
}




