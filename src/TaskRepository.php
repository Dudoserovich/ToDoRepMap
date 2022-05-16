<?php

namespace Dudoserovich\ToDoPhp;

class TaskRepository
{
    public static function store(Task $task)
    {
        return TaskMapper::save($task);
    }

    public static function remove(Task $task)
    {
        TaskMapper::remove($task);
    }

    public static function getAll(): array
    {
        return TaskMapper::getAll();
    }

    public static function getById($id): Task
    {
        return TaskMapper::getById($id);
    }

    public static function getByFields($task, $datetime): Task
    {
        return TaskMapper::getByFields($task, $datetime);
    }
}