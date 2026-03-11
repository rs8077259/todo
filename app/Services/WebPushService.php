<?php

namespace App\Services;

use App\Models\SubTodo;
use Log;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;
use stdClass;

class WebPushService
{
    //public static function urlSafeB64($data) {    return str_replace(['+', '/', '='], ['-', '_', ''], $data);}
    public static function send(array $sub, array $payload,SubTodo $obj)
    {
        $sub['keys']= (array)$sub['keys'];
        $subscription = Subscription::create([
            'endpoint'=>$sub['endpoint'],
            'publicKey'=>$sub['keys']['p256dh'],
            'authToken'=>$sub['keys']['auth'],
            'contentEncoding'=>'aes128gcm'
        ]);
        $payload = json_encode($payload);
        
        $mail = env('web_security_mail');
        $private_key = env('web_push_private_key');
        $public_key = env('web_push_public_key');
        

        $auth = [
            'VAPID' => [ 
                'subject' => 'mailto:'.$mail,
                'publicKey' => ($public_key),
                'privateKey' => ($private_key),
            ],
        ];
        $webPush = new WebPush($auth,);
        $r = $webPush->sendOneNotification($subscription, $payload);
        \Illuminate\Support\Facades\Log::info($r->isSuccess());
        if($r->isSuccess()){
           $obj->intimated = true;
           $obj->save();
        }
        
    }
}
