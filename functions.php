<?php
function renderTemplate($template_path, $template_data)
{
    ob_start();
    if (file_exists($template_path)) {
        require_once "$template_path";
    } else {
        return "Файл $template_path не найден";
    }
    $content = ob_get_clean();
    return $content;
}

function initBD()
{
    $host = 'localhost';
    $db   = 'doings';
    $user = 'root';
    $pass = '';
    $charset = 'utf8';

    $dsn = "mysql:host=$host; dbname=$db; charset=$charset";
    $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, $user, $pass, $opt);
    return $pdo;
}

function getProjects()
{
    $pdo = initBD();
    $res = $pdo->prepare("SELECT * FROM `projects` WHERE `id_user` = ?");
    $res->execute([$_SESSION['user']['id']]);
    $projects = $res->fetchAll();
    return $projects;
}

function getTasksInProject($all_tasks, $project_id)
{
    $count = 0;
    foreach ($all_tasks as $val) {
        if ($val['id_project'] == $project_id) $count++;
    }
    return $count;
}

function normalizeDate($date)
{
    $string = substr($date, 0, 10);
    $day = substr($string, 8, 10);
    $month1 = $string[5];
    $month2 = $string[6];
    $year = substr($string, 0, 4);
    $res = $day . '.' . $month1 . $month2 . '.' . $year;
    return $res;
}
