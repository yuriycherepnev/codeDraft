<?php

class Page extends Controller
{
    function __construct() {
        parent::__construct();
    }
    public function Account($id){
        $this->loadModel('Main');
        $account = $this->model->loadPage($id);
        $images = $this->model->loadImg($id);
        $area = 'page';
        if ($account['error'] === NULL) {
            $this->view->render('account', $account, $area, $images);
        } else {
            $this->view->render($account['error'], $account, $area, $images);
        }
    }
    public function successRegister($id){
        $this->view->render('successRegister', $id);
    }
    public function Users(){
        $this->loadModel('Main');
        $users = $this->model->users();
        $area = 'page';
        $this->view->render('users', $users, $area);
    }
    public function addImage(){

    }
    public function downloadImg($image){
        $this->loadModel('Main');
        $this->model->downloadImage($image);
    }
}



