<?php

namespace App\Jobs;

use App\Models\SubTodo;
use App\Services\WebPushService;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

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
        Log::info("runnig in scheduler");
        $serverTime = Carbon::now();
        $option = SubTodo::where("serverReminder",'<=',$serverTime)->where('intimated',false)->get();
        foreach($option as $a){
            $subscription = (array) json_decode($a->todo->user->webPushSub()->first()->subscription);
            $payload = [
                "title"=>"upcoming event",
                "message" => "you have set the reminder for '$a->work' "
            ];
            WebPushService::send($subscription,$payload,$a);
            
        }
    }
}
