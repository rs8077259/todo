<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use function PHPUnit\Framework\returnArgument;
use function Util\cluster;

Route::get('/', function () {
    return view('index');
})->middleware('auth');
Route::livewire('/login','auth::login')->name('login');
Route::livewire('/register','auth::register');
Route::post('/sync',function(Request $request){
    Log::info('Payload',$request->all());

    $client_cluster = cluster($request->all());
    $database_cluster = cluster(Auth::user()->todo()->SubTodo()->all());

    return Response::json([])->status(200);
    
})->middleware('auth');
