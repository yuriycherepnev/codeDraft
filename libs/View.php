<?php
//класс для рендеринга html страниц
class View
{
    public function render($name, $account = false, $area = false, $images = false) //аргументы для передачи информации из базы данных в html
    {
        if ($area == 'page') {
            require 'view/header.php';
            require 'view/' . $name . '.php';
        } else {
            require 'view/' . $name . '.php';
        }

    }
}

