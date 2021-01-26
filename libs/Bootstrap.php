<?php
//файл начальной загрузки (рендеринг регистрации и авторизации)
$url = $_GET['url'];
$url = explode('/', $url);
$errors = 0;

if ($_SESSION['email'] !== NULL) {
    if (empty($url[0])) { //подключение начальной страницы
        require $_SERVER['DOCUMENT_ROOT'] . '/controller/Page.php';
        $controller = new Page;
        $controller->Account($_SESSION['id']);
    } else {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/controller/' . $url[0] . '.php')) {
            require $_SERVER['DOCUMENT_ROOT'] . '/controller/' . $url[0].'.php';
            $controller = new $url[0];
            if (method_exists($controller, $url[1])) { //подключение страницы при клике по ссылке
              $controller->{$url[1]}($url[2]);
            } else {
                $errors = 1;
            }
        } else {
            $errors = 1;
        }
    }
} else {
    if (empty($url[0])) { //подключение начальной страницы
        require $_SERVER['DOCUMENT_ROOT'] . '/controller/Main.php';
        $controller = new Main;
        $controller->page();
    } else {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/controller/' . $url[0] . '.php')) {
            require $_SERVER['DOCUMENT_ROOT'] . '/controller/' . $url[0].'.php';
            $controller = new $url[0];
            if (method_exists($controller, $url[1])) { //подключение страницы при клике по ссылке
                $controller->{$url[1]}($url[2]);
            } else {
                $errors = 1;
            }
        } else {
            $errors = 1;
        }
    }
}
if ($errors !== 0) {
    require $_SERVER['DOCUMENT_ROOT'] . '/datacontroller/Errors.php';
    $errors = new Errors;
    $errors->notFound();
}
?>