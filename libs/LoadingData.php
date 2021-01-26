<?php
$request = $_POST;
if (empty($request)) { //выясняем тип запроса
    return;
} else {
    if (file_exists(SITE_ROOT . '/datacontroller/' . $request['request_type'] . '.php')) {
        require SITE_ROOT . '/datacontroller/' . $request['request_type'] . '.php';
        $controller = new $request['request_type'];
        if (method_exists($controller, $request['method'])) {
            $controller->{$request['method']}($request); //передаем тело запроса в контроллер
        }
    }
}
?>