<?php

namespace App\Jobs;

use App\Models\SubTodo;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class TodoReminderJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public SubTodo $subTodo)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // covert time to server timezone
        $serverTimezone = Carbon::now()->timezoneName;
        $time = Carbon::parse($this->subTodo->reminder)
            ->copy()->setTimezone($serverTimezone)->startOfHour()->subHours(3);
        $this->subTodo->serverReminder=$time;
        $this->subTodo->save();
    }
}
