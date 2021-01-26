<?php
//класс создания экземпляра класса подключения к базе даных
class Model {
    function __construct(){
        session_start();
        $this->database = new Database;
    }
}