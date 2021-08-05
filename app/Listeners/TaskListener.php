<?php

namespace App\Listeners;

use App\Events\TaskProcessed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TaskListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\TaskProcessed  $task
     * @return void
     */
    public function handle(TaskProcessed $task)
    {
        dd($task);
    }
}
