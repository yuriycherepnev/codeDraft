<?php
//класс подключения к базе данных
class Database extends PDO{
    function __construct(){
        /*$server = $_SERVER['SERVER_ADDR']; // адрес сервера на котором находится код
        $username = 'root';
        $password = 'root';
        $dbname = 'university';
        $charset = 'utf8';
        parent::__construct("mysql:host=$server;dbname=$dbname;charset=utf8", "$username", "$password");*/
       // parent::__construct("mysql:host=localhost;dbname=u1251455_codedraft;charset=utf8", "u1251455_user", "1q2w3e4r");
        parent::__construct("mysql:host=localhost;dbname=university;charset=utf8", "root", "root");
    }
}
