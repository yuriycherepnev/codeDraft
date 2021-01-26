<?php

function connect() {
    $server = $_SERVER['SERVER_ADDR']; // адрес сервера на котором находится код
    $username = 'root';
    $password = 'root';
    $dbname = 'registration';
    $charset = 'utf8';
    $connection = new PDO("mysql:host=$server;dbname=$dbname", "$username", "$password");
    return $connection;
}




