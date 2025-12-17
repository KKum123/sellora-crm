<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\front\SubscribeController;
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

Route::get('/create-symbolic-link', function () {
    // Execute the artisan command to create the symbolic link

    $data =    Artisan::call('storage:link', []);


    if ($data) {
        return "Symbolic link created successfully!";
    } else {
        return "Error creating symbolic link";
    }
});

Route::get('/view-clear', function () {
    $exitCode = Artisan::call('route:cache');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('view:clear');
    return 'View cache cleared';
});





Route::get('/', function () {
    return view('main.index');
});
Route::get('/login', function () {
    return view('main.login');
});
Route::get('/help', action: function () {
    return view('main.help');
});

Route::post('team-login', [Controller::class, 'loginTeam']);


Route::get('/page-403', function () {
    return view('page403');
})->name('page403');

Route::get('/forgot-password', [Controller::class, 'forgotPassword']);
Route::post('/send-forgot-password', [Controller::class, 'sendForgotPassword']);
Route::post('/reset-forgot-password', [Controller::class, 'resetForgotPassword']);

Route::get('/reset-password/{token}', [Controller::class, 'resetPassword']);

