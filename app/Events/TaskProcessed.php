<?php

namespace App\Events;

use App\Models\Task;

class TaskProcessed extends Event
{
    /**
     * Create a new event instance.
     *
     * @return void
     */

    public $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }
}
