<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Task;

class TaskReminder extends Mailable
{
    use Queueable, SerializesModels;
    public $task;
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function build()
    {
        $task= $this->task;
        return $this->subject('reminder')
                ->markdown('emails.tasks.reminder', compact('task'));
    }
}
