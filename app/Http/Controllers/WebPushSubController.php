<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebPushSubController extends Controller
{
    public function store(Request $request){
        $subscription = json_encode($request->json()->all());

        Auth::user()->webPushSub()->updateOrCreate(['user_id'=>Auth::user()->id],[
            "subscription"=>$subscription
        ]);
        return response()->json([
            "status"=>200
        ]);
    }
}
