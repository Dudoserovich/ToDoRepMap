<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';
use Dudoserovich\ToDoPhp\TaskRepository;

$id = $_POST['id'];

if ($id != '') {
    TaskRepository::remove(TaskRepository::getById($id));
    setcookie("typeNoty", "success");
    setcookie("messageNoty", "Задача успешно удалена");
} else {
    setcookie("typeNoty", "warning");
    setcookie("messageNoty", "Задача не была удалена");
}

header('Location: /ToDo');
