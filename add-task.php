<?php
    require_once "functions.php";
    
    session_start();
    
    $pdo = initBD();
    
    $query = $pdo -> prepare("SELECT * FROM `tasks` WHERE `id_user` = ? ORDER BY `data_stop`"); // повтор
    $query -> execute([$_SESSION['user']['id']]);
    $result = $query -> fetchAll(); 
      
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $required_fields = ['name', 'project', 'date'];
        $errors = [];
        
        foreach ($required_fields as $value) {
            if ($_POST[$value] == null) {
                $errors[$value] = "Заполните поле";
            }
        }

        $name = $_POST['name'];
        $project = $_POST['project'];
        $finish_date = $_POST['date'];
        //$filename = $_FILES['filename']['name'];
        
        if (isset($_FILES['filename']['name'])) {  
            $real_name = $_FILES['filename']['name'];
            $tmp_name = $_FILES['filename']['tmp_name'];
            
            if (filesize($tmp_name) > 1024 *1024) {
                $errors['file'] = 'Размер файла не должен превышать 1 МБ';
                echo $errors['file'];
            }
            else {
                $filepath = 'files/' . $real_name;
                 
                if (!file_exists($filepath))
                    move_uploaded_file($tmp_name, 'files/' . $real_name);  
            }
        }
        

       if (count($errors)) {
            $content = renderTemplate("templates/add-task.php", [
                "errors" => $errors,
                "projects" => getProjects()]);           
            } 
        else { 
            $pdo = initBD();
            $pdo_query = $pdo -> prepare("SELECT id FROM projects WHERE name = ?");
            $pdo_query -> execute([$project]);
            $pdo_res = $pdo_query -> fetchColumn();
            

            $pdo_query = $pdo -> prepare("INSERT INTO `tasks` (`id_user`, `id_project`, `name`, `data_start`, `data_stop`, `deadline`, `url`, `status`) VALUES (?, ?, ?, NOW(), ?, ?, ?, ?)");
            $pdo_query -> execute([$_SESSION['user']['id'], $pdo_res, $name, $finish_date, "2012-05-05", $filepath, 0]);

            header("location: index.php");
            } 
    }
    
    else {
        $content = renderTemplate("templates/add-task.php", ["projects" => getProjects()]); }
    
    
    $layout_content = renderTemplate("templates/layout.php", [
            "content" => $content,
            "projects" => getProjects(),
            "tasks" => $result]);
            
    print($layout_content);
