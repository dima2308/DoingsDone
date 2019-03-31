<?php
    require_once "functions.php";
    
    session_start();
    
    $pdo = initBD();
    
    $query = $pdo -> prepare("SELECT * FROM `tasks` WHERE `id_user` = ? ORDER BY `data_stop`");  // повтор
    $query -> execute([$_SESSION['user']['id']]);
    $result = $query -> fetchAll(); 
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $required_fields = ['name'];
        $errors = [];
        
        foreach ($required_fields as $value) {
            if ($_POST[$value] == null) {
                $errors[$value] = "Заполните поле";
            }
        }

        $name = $_POST['name'];
        
        
       if (count($errors)) {
            $content = renderTemplate("templates/add-project.php", [
                "errors" => $errors]);           
            } 
        else { 
            $pdo = initBD();
            $res = $pdo -> prepare("INSERT INTO `projects` (`name`, `id_user`) VALUES (?, ?)");
            $res -> execute([$name, $_SESSION['user']['id']]);
            header("location: index.php"); }
        
    }
    else {
        $content = renderTemplate("templates/add-project.php", ['f' => 4]); }
    
    
    $layout_content = renderTemplate("templates/layout.php", [
            "content" => $content,
            "projects" => getProjects(),
            "tasks" => $result]);
            
    print($layout_content);
