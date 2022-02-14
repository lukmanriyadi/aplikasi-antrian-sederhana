<?php

use App\Http\Controllers\AudioController;
use App\Http\Controllers\CounterController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\OfficerController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceUserController;
use App\Http\Controllers\UserController;
use App\Models\Queue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [QueueController::class,'create']);
Route::get('/demo', DemoController::class);
Route::get('/monitor', [CounterController::class, 'index']);
Route::get('/audio', [AudioController::class, 'index']);
Route::post('/audio', [AudioController::class, 'store']);
Route::put('/audio/{audio}', [AudioController::class, 'update']);
Route::resource('queue', QueueController::class);
Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::middleware(['officer'])->prefix('officer')->group(function () {
        Route::get('/',[OfficerController::class, 'index'])->name('officer');
        Route::post('/service', [ServiceUserController::class, 'store']);
        Route::delete('/service/{serviceUser}', [ServiceUserController::class, 'destroy']);
        Route::put('/counter', [CounterController::class, 'update']);
        Route::get('/queue',[OfficerController::class, 'queue']);
        Route::put('/queue/{queue}',[QueueController::class, 'update']);
    });

    Route::middleware(['admin'])->prefix('admin')->group(function () {
        Route::get('/', function () {
             // /admin
             return view('admin.index');
        })->name('admin');

        Route::resource('service', ServiceController::class)->except(['show']);
        Route::resource('user', UserController::class);
        Route::resource('counter', CounterController::class);
        Route::get('/queue', [QueueController::class, 'index']);
    });
});