<?php
require_once "functions.php";

session_start();

$pdo = initBD();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $required_fields = ['email', 'password'];
    $errors = [];

    foreach ($required_fields as $value) {
        if ($_POST[$value] == null) {
            $errors[$value] = "Заполните поле";
        }
    }

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($email) && (!empty($password))) {
        $query = $pdo->prepare("SELECT * FROM `users` WHERE `email` = ?");
        $query->execute([$email]);
        $res = $query->fetchAll();

        $user = $res ? $res : null;
        if (($user)) {
            if (($password != null) and (password_verify($password, $user[0]['password']))) {
                $_SESSION['user'] = $user[0];
            } else $errors['password'] = "Неверный пароль";
        } else $errors['email'] = "Пользователь не найден";
    }


    if (count($errors)) {
        $content = renderTemplate("templates/login.php", [
            "errors" => $errors
        ]);
    } else {
        header("location: index.php");
    }
} else {
    $content = renderTemplate("templates/login.php", [
        "errors" => $errors
    ]);
}

$layout_content = renderTemplate("templates/layout.php", [
    "content" => $content
]);

print($layout_content);
