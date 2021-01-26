<?php

class Register extends Controller {
    function __construct() {
        parent::__construct();
    }
    public function AddUser($user){
        $this->loadModel('Main');
        $this->model->register($user);
    }
}
