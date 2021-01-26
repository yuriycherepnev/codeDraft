<?php

class Auth extends Controller {
    function __construct() {
        parent::__construct();
    }
    public function AuthUser($user){
        $this->loadModel('Main');
        $this->model->auth($user);
    }
}


