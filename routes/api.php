<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login',function (Request $request){

    $user=\App\Models\User::query()->first();
    return $user->createToken('test');
});

Route::get('/user', function (Request $request) {

    dd($request->user('api'));
    dd(auth('api')->check());
//    dd($request->user('api'));




});