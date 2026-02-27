<?php

namespace App\Jobs;

use App\Models\SubTodo;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class RegisterTodoReminder implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $serverTime = Carbon::now();
        $option = SubTodo::where("serverReminder",'<=',$serverTime)->where('intimated','!=',true)->get();
        foreach($option as $a){
            logger($a->work);
            $a->intimated = true;
            $a->save();
        }
    }
}
