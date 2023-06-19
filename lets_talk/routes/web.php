<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function ()
 {
    return view('inicio_sesion.login');
})->name('home');

// Rutas Login
Route::resource('login', 'inicio_sesion\LoginController');
Route::get('login_estudiante', 'inicio_sesion\LoginController@loginEstudiante')->name('login_estudiante');
Route::get('reset_password', 'inicio_sesion\LoginController@resetPassword')->name('reset_password');
Route::get('reset_password_student', 'inicio_sesion\LoginController@resetPasswordStudent')->name('reset_password_student');
Route::post('recovery_password', 'inicio_sesion\LoginController@recoveryPassword')->name('recovery_password');
Route::get('logout', 'inicio_sesion\LoginController@logout')->name('logout');

Route::resource('trainer', 'entrenador\EntrenadorController');
Route::resource('administrador', 'admin\AdministradorController');
Route::post('cambiar_estado', 'admin\AdministradorController@cambiarEstadoUsuario')->name('cambiar_estado');
Route::resource('estudiante', 'estudiante\EstudianteController');
Route::post('validar_cedula', 'admin\AdministradorController@validarCedula')->name('validar_cedula');
Route::post('validar_cedula_edicion', 'admin\AdministradorController@validarCedulaEdicion')->name('validar_cedula_edicion');
Route::post('validar_correo', 'admin\AdministradorController@validarCorreo')->name('validar_correo');
Route::post('validar_correo_edicion', 'admin\AdministradorController@validarCorreoEdicion')->name('validar_correo_edicion');
Route::post('actualizar_clave', 'admin\AdministradorController@actualizarClave')->name('actualizar_clave');

Route::post('cargar_eventos_entrenador', 'entrenador\EntrenadorController@cargarEventos')->name('cargar_eventos_entrenador');
Route::delete('eliminar_evento', 'entrenador\EntrenadorController@deleteEvent')->name('eliminar_evento');
Route::post('cargar_info_evento', 'entrenador\EntrenadorController@cargarInfoEventoPorId')->name('cargar_info_evento');
Route::get('disponibilidad_entrenadores', 'admin\AdministradorController@disponibilidades')->name('administrador.disponibilidad_entrenadores');
Route::get('disponibilidad', 'estudiante\EstudianteController@disponibilidad')->name('estudiante.disponibilidad');
Route::post('actualizar_disponibilidad_entrenador', 'admin\AdministradorController@actualizarDisponibilidad')->name('actualizar_evento');

Route::get('disponibilidad_admin', 'admin\AdministradorController@vistaAdminDisponibilidad')->name('administrador.disponibilidad_admin');
Route::post('disponibilidad_admin_store', 'admin\AdministradorController@storeAdminDisponibilidad')->name('administrador.disponibilidad_admin_store');
Route::post('disponibilidad_admin_delete', 'admin\AdministradorController@deleteAdminDisponibilidad')->name('administrador.disponibilidad_admin_delete');
