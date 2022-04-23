<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function ()
 {
    // return view('welcome');
    return view('inicio_sesion.login');
});

// Rutas Login
Route::resource('login', 'inicio_sesion\LoginController');
Route::get('login_estudiante', 'inicio_sesion\LoginController@loginEstudiante')->name('login_estudiante');
Route::get('reset_password', 'inicio_sesion\LoginController@resetPassword')->name('reset_password');
Route::get('reset_password_student', 'inicio_sesion\LoginController@resetPasswordStudent')->name('reset_password_student');
Route::post('recovery_password', 'inicio_sesion\LoginController@recoveryPassword')->name('recovery_password');
