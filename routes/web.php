<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'domain')->name('domain');         // страница проверки доменов
Route::view('/register', 'register')->name('register');
Route::view('/login', 'login')->name('login');