<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>code-draft.com</title>
    <link rel="shortcut icon" href="/assets/img/icon.png" type="image">
    <link rel="stylesheet" type="text/css" href="/assets/css/myPage.css">
</head>
<body class="body">
<main class="main">
    <nav id="nav">
        <div class="nav flex-row flex-end">
            <div id="logo" class="flex-row align-items-center">
                <div><img src="/assets/img/logo.png" alt=""></div>
                <p>code-draft.com</p>
            </div>
            <a href="/Main/page"><div class="nav_button">Main</div></a>
            <a href="/Page/Account<?php if ($_SESSION['id'] !== NULL) {
                echo '/' . $_SESSION['id'];
            } ?>"><div class="nav_button">My Page</div></a>
            <a href="/Page/Users"><div class="nav_button">Users</div></a>
            <a href=""><div id="exit" class="nav_button">Exit</div></a>
        </div>
        <div class="line"></div>
    </nav>

