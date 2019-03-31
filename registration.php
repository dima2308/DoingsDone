<?php
	require_once "functions.php";
    
    $pdo = initBD();
    
    $query = $pdo -> query("SELECT * FROM `users`");
    $res = $query -> fetchALL();
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $required_fields = ['name', 'email', 'password'];
        $errors = [];
        
        foreach ($required_fields as $value) {
            if ($_POST[$value] == null) {
                $errors[$value] = "Заполните поле";
            }
        }
        
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        
        if (($password != null) and (strlen($password) < 6) or (strlen($password) > 30)) {
            $errors['password'] = "Пароль должен содержать от 6 до 30 символов";
        }        
            
        foreach ($res as $value) {
            if ($email == $value['email']) {
                $errors['email'] = "Данный email уже используется";
            }
        }
        
        if (isset($_FILES['filename']['name'])) {  
            $real_name = $_FILES['filename']['name'];
            $tmp_name = $_FILES['filename']['tmp_name'];
            
            move_uploaded_file($tmp_name, 'img/avatars/' . $real_name);  
        }
        
        if (count($errors)) {
            $content = renderTemplate("templates/registration.php", [
                "errors" => $errors]);
                
            $layout_content = renderTemplate("templates/layout.php", [
            "content" => $content]);
            
            print($layout_content);    
        } 
        else {  
            $query = $pdo -> prepare("INSERT INTO users (`email`, `password`, `name`, `url`) VALUES (?, ?, ?, ?)");    
            $query -> execute([$email, password_hash($_POST['password'], PASSWORD_DEFAULT), $name, $_FILES['filename']['name']]);
            
            $content = renderTemplate("templates/login.php", ["f" => 5]);
        
            $layout_content = renderTemplate("templates/layout.php", [
                "content" => $content]);
            
            print($layout_content);
            
        }    
    }
    else {
        $content = renderTemplate("templates/registration.php", ["f" => 5]);
        
        $layout_content = renderTemplate("templates/layout.php", [
            "content" => $content]);
            
        print($layout_content);
    }
	
	
