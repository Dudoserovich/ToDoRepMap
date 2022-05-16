<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';

use Dudoserovich\ToDoPhp\task;
use Dudoserovich\ToDoPhp\TaskRepository;

$task = $_POST['task'];
$datetime = date("Y-m-d H:i:s", strtotime($_POST['deadline']));

if ($task == '' || $_POST['deadline'] == '') {
    setcookie("typeNoty", "warning");
    setcookie("messageNoty", "Задайте все поля задачи");
} else {

    if (iconv_strlen($task) > 255) {
        setcookie("typeNoty", "danger");
        setcookie("messageNoty", "Слишком длинное задание (>255 символов)");
        header('Location: /ToDo');
        die();
    }

    if (TaskRepository::store(new task($task, $datetime))) {
        setcookie("typeNoty", "success");
        setcookie("messageNoty", "Задание добавлено");
    } else {
        setcookie("typeNoty", "danger");
        setcookie("messageNoty", "Такое задание уже существует");
    }

}
header('Location: /ToDo');
