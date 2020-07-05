<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Task;
class SendReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:remind';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //change it so that the date is in utc
        $nowTime = date("Y-m-d H:i:s");
        
        $hours_before = 2;
        $duration = '+'. $hours_before .' hours';
        $toTime = date('Y-m-d H:i:s', strtotime($duration,strtotime($nowTime)));
        
        $query = Task::join('statuses', 'statuses.id', '=','tasks.status_id' );
                
        $query = $query->whereBetween('due', [$nowTime, $toTime]);
        
        $query = $query->where('reminder_sent',  false);
        
        $query = $query->where('statuses.remind', true);
        
        $tasks = $query->get();
        
 
        foreach($tasks as $task)
        {
            
            $task->send_reminder_email();
            $event->reminder_sent=true;
            $event->save();
        }    }
}
