<?php

use App\Http\Controllers\Customer\CustomerAuthControllers;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\CustomerControllers;



Route::group(['namespace' => 'Customer', 'prefix' => 'customer', 'as' => 'customer.'], function () {
    Route::get('login', [CustomerAuthControllers::class, 'login'])->name('login');
});