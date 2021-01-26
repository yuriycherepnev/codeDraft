<?php

class Img extends Controller {
    function __construct() {
        parent::__construct();
    }
    public function uploadImg(){
        $this->loadModel('Main');
        $this->model->upLoadImg();
    }
    public function deleteImg($image){
        $this->loadModel('Main');
        $this->model->deleteImage($image);
    }
}

