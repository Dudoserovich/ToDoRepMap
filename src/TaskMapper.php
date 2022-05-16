<?php

namespace Dudoserovich\ToDoPhp;

class TaskMapper
{
    public static function save($task)
    {
        $taskByFields = self::getByFields($task->getTask(), $task->getDateTime());

        if ($task->getId() == null) {
            if (!$taskByFields->getId()) {
                $foundTask = PdoAdapter::returnOneRequest('INSERT INTO tasks(task,datetime) VALUES(:task,:datetime)',
                    ['task' => $task->getTask(), 'datetime' => $task->getDateTime()]);
                return new Task($foundTask['task'], $foundTask['datetime'], $foundTask['id']);
            } else return false;
        } else {
            if ($taskByFields->getTask() != $task->getTask() && $taskByFields->getDatetime() != $task->getDatetime()) {
                PdoAdapter::noReturnRequest('UPDATE tasks set task=:task,datetime=:datetime WHERE id=:id',
                    ['task' => $task->getTask(), 'datetime' => $task->getDatetime(), 'id' => $task->getId()]);

                return self::getById($task->getId());
            } else return false;
        }
    }

    public static function remove($task)
    {
        // если запись найдена, удаляем
        if (TaskMapper::getById($task->getId())->getId()) {
            PdoAdapter::noReturnRequest('DELETE FROM `tasks` WHERE `id`=?', [$task->getId()]);
        }
    }

    public static function getAll(): array
    {
        $tasks = [];
        $rows = PdoAdapter::returnAllRequest('SELECT * from tasks ORDER BY id DESC');

        // получаем наши таски
        foreach ($rows as $row) {
            $task = new Task(
                (string)$row['task'],
                (string)$row['datetime'],
                (int)$row['id']
            );
            $tasks[] = $task;
        }

        return $tasks;
    }

    public static function getById($id): Task
    {
        $foundTask = PdoAdapter::returnOneRequest('SELECT * FROM `tasks` WHERE `id`=?', [$id]);

        if ($foundTask == false)
            return new Task();
        else return new Task($foundTask['task'], $foundTask['datetime'], $foundTask['id']);
    }

    public static function getByFields($task, $datetime): Task
    {
        $foundTask = PdoAdapter::returnOneRequest('SELECT * from tasks where task=:task AND datetime=:datetime',
            ['task' => $task, 'datetime' => $datetime]);

        if (!$foundTask)
            return new Task();
        else return new Task($foundTask['task'], $foundTask['datetime'], $foundTask['id']);
    }
}