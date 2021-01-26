<?php


class errors extends Controller
{
    public function notFound(){
        $this->view->render('not_found');
    }
}