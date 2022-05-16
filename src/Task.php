<?php

namespace Dudoserovich\ToDoPhp;

class task
{
    private ?int $id;
    private ?string $task;
    private ?string $datetime;

    public function __construct($task = null, $datetime = null, $id = null)
    {
        $this->id = $id;
        $this->task = $task;
        $this->datetime = $datetime;
    }

    /**
     * @return string
     */
    public function getTask(): ?string
    {
        return $this->task;
    }

    /**
     * @return string
     */
    public function getDatetime(): ?string
    {
        return $this->datetime;
    }

    /**
     * @return int|mixed|null
     */
    public function getId()
    {
        return $this->id;
    }
}