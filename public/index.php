<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';

use Dudoserovich\ToDoPhp\TaskRepository;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

function renderPage($data)
{
    // Twig
    $loader = new Twig\Loader\FilesystemLoader(dirname(__DIR__) . '/templates');
    $view = new Environment($loader);
    try {
        echo $view->render('index.html.twig', ['tasks' => $data ?? array()]);
    } catch (LoaderError | RuntimeError | SyntaxError $e) {
        echo $e;
    }
}

setcookie("typeNoty", null, time() - 3600);
setcookie("messageNoty", null, time() - 3600);

try {
    renderPage(TaskRepository::getAll());

    if (isset($_COOKIE['typeNoty'])) {
        echo "<script> displayNotification('{$_COOKIE['messageNoty']}', '{$_COOKIE['typeNoty']}') </script>";
    }
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage();
    die();
}