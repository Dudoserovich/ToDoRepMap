<?php

namespace Dudoserovich\ToDoPhp;

class TaskRepository
{
    public static function store(task $task)
    {
        return TaskMapper::save($task);
    }

    public static function remove(task $task)
    {
        TaskMapper::remove($task);
    }

    public static function getAll(): array
    {
        return TaskMapper::getAll();
    }

    public static function getById($id): task
    {
        return TaskMapper::getById($id);
    }

    public static function getByFields($task, $datetime): task
    {
        return TaskMapper::getByFields($task, $datetime);
    }
}