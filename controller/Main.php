<?php

class Main extends Controller {
    function __construct() {
        parent::__construct();
    }
    public function register(){
        $this->view->render('register');
    }
    public function auth(){
        $this->view->render('auth');
    }
    public function exit(){
        $this->loadModel('Main');
        $this->model->exitPage();
        $this->view->render('mainPage');
    }
    public function page() {
        $this->view->render('mainPage');
    }
}
?>