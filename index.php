<?php
    require_once "functions.php";
    
    session_start();
    
    $pdo = initBD();
    
    $status = $_GET['tasks']; 
    
    switch ($status) {
        case "td":
            $query = $pdo -> prepare("SELECT * FROM `tasks` WHERE `id_user` = ? and `data_stop` = ? and `status` = ? ORDER BY `data_stop`");
            $query -> execute([$_SESSION['user']['id'], date('Y-m-d'), 0]);
            break;
        case "tm":
            $query = $pdo -> prepare("SELECT * FROM `tasks` WHERE `id_user` = ? and `data_stop` = ? and `status` = ? ORDER BY `data_stop`"); 
            $d = strtotime("+1 day");
            $query -> execute([$_SESSION['user']['id'], date('Y-m-d', $d), 0]);
            break;
        case "fin":
            $query = $pdo -> prepare("SELECT * FROM `tasks` WHERE `id_user` = ? and `data_stop` < ? and `status` = ? ORDER BY `data_stop`");
            $query -> execute([$_SESSION['user']['id'], date('Y-m-d'), 2]);
            break;
        default: 
            $query = $pdo -> prepare("SELECT * FROM `tasks` WHERE `id_user` = ? ORDER BY `data_stop`");
            $query -> execute([$_SESSION['user']['id']]);
    }
    
    $result = $query -> fetchAll(); 
    
    // обновление на просроченные
    
    $query = $pdo -> prepare("UPDATE `tasks` SET `status` = ? WHERE `data_stop` < ? AND `status` = ?");
    $query -> execute([2, date('Y-m-d'), 0]);
    
    if (isset($_GET['id'])) {    
        $query = $pdo -> prepare("UPDATE `tasks` SET `status` = ? WHERE `id` = ? AND `status` = ?");
        $query -> execute([1, $_GET['id'], 0]);
    }
  
    //$pdo -> query('CREATE FULLTEXT INDEX name_search ON tasks(name)'); // создание индекса для поиска 
    
    $search = $_GET['search'] ?? '';
    
    if ($search) {
        $query = $pdo -> prepare("SELECT * FROM `tasks` WHERE `id_user` = ? and MATCH (name) AGAINST('$search')");
        $query -> execute([$_SESSION['user']['id']]);
        $result = $query -> fetchAll(); 
    }
    
    if (isset($_GET['project'])) {
        $query = $pdo -> prepare("SELECT * FROM `tasks` WHERE `id_user` = ? AND `id_project` = ? ORDER BY `data_stop`");
        $query -> execute([$_SESSION['user']['id'], $_GET['project']]);
        $result = $query -> fetchAll(); 
    }
    
    
        
 
    if (empty($_SESSION['user'])) {
        $content = renderTemplate("templates/guest.php", ['f' => 4]);
        $layout_content = renderTemplate("templates/layout_guest.php", [
            "content" => $content]);
    }
    else { 
        $content = renderTemplate("templates/index.php", [
            "title" => "Мои задачи",
            "tasks" => $result]);
        $layout_content = renderTemplate("templates/layout.php", [
            "content" => $content,
            "projects" => getProjects(),
            "tasks" => $result]);
    }
          
    print($layout_content);
?>
