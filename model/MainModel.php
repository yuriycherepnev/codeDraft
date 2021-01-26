<?php

//основной класс для работы с базой даннных

class MainModel extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function auth($user){ //авторизация
        $response = [];
        $search_email = "SELECT * FROM users WHERE email=(:email)";
        $pdo = $this->database->prepare($search_email);
        $pdo->bindParam(":email", $user['email']);
        $pdo->execute();
        $account = $pdo->fetchAll();
        if ($account === Array()) {
            $response[0] = 'notfound';
        } else {
            $userPassword = md5($user['password']);
            if ($userPassword !== $account[0]['password']) {
                $response[0] = 'wrong_password';
            } else {
                $protective_id = mt_rand(100000, 999999);
                $_SESSION['email'] = $user['email'];
                $_SESSION['id'] = $account[0]['id'];
                $_SESSION['protective_id'] = $protective_id;

                $sql_protective_id = "UPDATE users SET protective_id=(:protective_id)  WHERE email=(:email)";
                $pdo = $this->database->prepare($sql_protective_id);
                $pdo->bindParam(":protective_id", $protective_id);
                $pdo->bindParam(":email", $user['email']);
                $pdo->execute();
                $response[0] = 'success';//если авторизация успешна, добавляем email пользователя в сессию
                $response[1] = $account[0]['id'];
            }
        }
        print_r(json_encode($response));
    }

    public function register($user){ //добавление пользователя в базу данных
        $response = [];
        $validate = $this->validation($user);
        if($validate !== []) {
            $response =  json_encode($validate, JSON_UNESCAPED_UNICODE);
            print_r($response);
        } else {
            $search_email = "SELECT * FROM users WHERE email=(:email)";
            $pdo = $this->database->prepare($search_email);
            $pdo->bindParam(":email", $user['email']);
            $pdo->execute();
            $email = $pdo->fetchAll();
            if ($email !== Array()) {
                $response[0] = 'email';
                print_r(json_encode($response));
            } else {
                $img = file_get_contents($_FILES['img']['tmp_name']);
                $protective_id = mt_rand(100000, 999999);
                $sql = "INSERT INTO users (name, second_name, email, password, avatar, protective_id) VALUES (:name, :second_name, :email, :password, :avatar, :protective_id);";
                $pdo = $this->database->prepare($sql);
                $pdo->bindParam(":name", $user['name']);
                $pdo->bindParam(":second_name", $user['surname']);
                $pdo->bindParam(":email", $user['email']);
                $pdo->bindParam(":password", md5($user['password']));
                $pdo->bindParam(":avatar", $img);
                $pdo->bindParam(":protective_id", $protective_id);
                $pdo->execute();
                $search_id = "SELECT id FROM users WHERE email=(:email)";
                $pdo = $this->database->prepare($search_id);
                $pdo->bindParam(":email", $user['email']);
                $pdo->execute();
                $id = $pdo->fetch();
                $_SESSION['email'] = $user['email'];//если регистрация успешна, добавляем email пользователя в сессию
                $_SESSION['id'] = $id['id'];
                $_SESSION['protective_id'] = $protective_id;
                $response[0] = 'success';//если авторизация успешна, добавляем email пользователя в сессию
                $response[1] = $id['id'];
                print_r(json_encode($response));
            }
        }
    }
    private function validation($user)
    {
        $check = [];
        $img_type = substr(($_FILES['img']['type']), 0, 5);
        $img_size = filesize($_FILES['img']['tmp_name']);
        $img_size = $img_size / 1024 / 1024;
        if (strlen($user['name']) > 100) {
            array_push($check, 'The name must be no more than 100 characters long!');
        }
        if (strlen($user['surname']) > 100) {
            array_push($check, 'Last name must be no more than 100 characters!');
        }
        if (strlen($user['password']) > 500) {
            array_push($check, 'Password must be less than 500 characters!');
        }
        if (!(filter_var($user['email'], FILTER_VALIDATE_EMAIL))) {
            array_push($check, 'email address is filled incorrectly!');
        }
        if ($img_type !== 'image') {
            array_push($check, 'The file type must be image!');
        }
        if ($img_size > 100) {
            array_push($check, 'Image size should not be more than 100 MB!');
        }
        return $check;
    }

    public function loadPage($id) { //здесь надо прописать код загрузки если пользователь не авторизован
        $account = [];
        $account['error'] = NULL;
        $search_id= "SELECT * FROM users WHERE id=(:id)";
        $pdo = $this->database->prepare($search_id);
        $pdo->bindParam(":id", $id);
        $pdo->execute();
        $request = $pdo->fetch();


        if ($id === NULL and $_SESSION['email'] === NULL) {
            $account['error'] = 'no_access';
        } else if ($request === false) {
            $account['error'] = 'user_not_found';
        }

        if (intval($request['protective_id']) === intval($_SESSION['protective_id'])) {
            $account['access'] = 'owner';
        } else {
            $account['access'] = 'guest';
        }
        $account['id'] = $request['id'];
        $account['name'] = $request['name'];
        $account['second_name'] = $request['second_name'];
        $account['avatar'] = $request['avatar'];
        return $account;
    }

    public function loadImg($id) {
        $selectImg = "SELECT * FROM images WHERE userid=(:id);";
        $pdo = $this->database->prepare($selectImg);
        $pdo->bindParam(":id", $id);
        $pdo->execute();
        $images = $pdo->fetchAll();
        $images = array_reverse($images);
        return $images;
    }

    public function upLoadImg() {
        $img = file_get_contents($_FILES['img_upload']['tmp_name']);
        $sql = "INSERT INTO images (name, image, userid) VALUES (:name, :image, :userid);";
        $pdo = $this->database->prepare($sql);
        $pdo->bindParam(":name", $_FILES['img_upload']['name']);
        $pdo->bindParam(":image", $img);
        $pdo->bindParam(":userid", $_SESSION['id']);
        $pdo->execute();
        $response = 'success';
        print_r($response);
    }
    public function addImg() {

    }
    public function deleteImage($image) {
        $sql = "DELETE FROM images WHERE id=(:id)";
        $pdo = $this->database->prepare($sql);
        $pdo->bindValue(":id", $image['imageid']);
        $pdo->execute();
        $response = 'success';
        print_r($response);
    }
    public function users() {
        $sql = "SELECT id, name, second_name, avatar FROM users";
        $pdo = $this->database->prepare($sql);
        $pdo->execute();
        $users = $pdo->fetchAll();
        return $users;
    }
    public function downloadImage($image) {
        $sql= "SELECT * FROM images WHERE id=(:id);";
        $pdo = $this->database->prepare($sql);
        $pdo->bindValue(":id", $image);
        $pdo->execute();
        $image = $pdo->fetch();
        $filename = $image['name'];
        $dir = 'assets/img/' . $image['name'];
        file_put_contents($dir, $image['image']);
        header("Content-Type:" . mime_content_type($dir));
        header("Content-Length: " . filesize($dir));
        header("Content-Disposition: attachment; filename=$filename");
        readfile($dir);
        unlink($dir);
    }
    public function exitPage() {
        session_destroy();
    }
    /* написать функционал для скачивания картинки и для редактирования аватара
    функционал для входа на сайт без регистрации */
}

?>