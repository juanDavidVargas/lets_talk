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
Route::get('recovery_password', 'inicio_sesion\LoginController@recoveryPassword')->name('recovery_password');
Route::post('recovery_password_email', 'inicio_sesion\LoginController@recoveryPasswordEmail')->name('recovery_password_email');
Route::get('recovery_password_link/{id}', 'inicio_sesion\LoginController@recoveryPasswordLink')->name('recovery_password_link');
Route::post('recovery_password_post', 'inicio_sesion\LoginController@recoveryPasswordPost')->name('recovery_password_post');
Route::get('logout', 'inicio_sesion\LoginController@logout')->name('logout');

// =======================================================================================================

// Rutas ADMINISTRADOR
Route::resource('administrador', 'admin\AdministradorController');
Route::post('cambiar_estado', 'admin\AdministradorController@cambiarEstadoUsuario')->name('cambiar_estado');
Route::post('validar_cedula', 'admin\AdministradorController@validarCedula')->name('validar_cedula');
Route::post('validar_cedula_edicion', 'admin\AdministradorController@validarCedulaEdicion')->name('validar_cedula_edicion');
Route::post('validar_correo', 'admin\AdministradorController@validarCorreo')->name('validar_correo');
Route::post('validar_correo_edicion', 'admin\AdministradorController@validarCorreoEdicion')->name('validar_correo_edicion');
Route::post('actualizar_clave', 'admin\AdministradorController@actualizarClave')->name('actualizar_clave');
Route::get('disponibilidad_entrenadores', 'admin\AdministradorController@disponibilidades')->name('administrador.disponibilidad_entrenadores');
Route::post('actualizar_disponibilidad_entrenador', 'admin\AdministradorController@actualizarDisponibilidad')->name('actualizar_evento');
Route::get('disponibilidad_admin', 'admin\AdministradorController@vistaAdminDisponibilidad')->name('administrador.disponibilidad_admin');
Route::post('disponibilidad_admin_store', 'admin\AdministradorController@storeAdminDisponibilidad')->name('administrador.disponibilidad_admin_store');
Route::post('disponibilidad_admin_delete', 'admin\AdministradorController@deleteAdminDisponibilidad')->name('administrador.disponibilidad_admin_delete');
Route::get('niveles_index', 'admin\AdministradorController@nivelesIndex')->name('administrador.niveles_index');

// =======================================================================================================

// Rutas ENTRENADOR
Route::resource('trainer', 'entrenador\EntrenadorController');
Route::post('cargar_eventos_entrenador', 'entrenador\EntrenadorController@cargarEventos')->name('cargar_eventos_entrenador');
Route::delete('eliminar_evento', 'entrenador\EntrenadorController@deleteEvent')->name('eliminar_evento');
Route::post('cargar_info_evento', 'entrenador\EntrenadorController@cargarInfoEventoPorId')->name('cargar_info_evento');
Route::post('detalle_sesion_entrenador', 'entrenador\EntrenadorController@cargaDetalleSesion')->name('detalle_sesion_entrenador');
Route::post('evaluacion_interna_entrenador', 'entrenador\EntrenadorController@evaluacionInternaEntrenador')->name('evaluacion_interna_entrenador');
Route::post('consulta_evaluacion_interna', 'entrenador\EntrenadorController@consultaEvaluacionInterna')->name('consulta_evaluacion_interna');
Route::post('aprobar_evento', 'entrenador\EntrenadorController@aprobarEvento')->name('aprobar_evento');
Route::post('rechazar_evento', 'entrenador\EntrenadorController@rechazarEvento')->name('rechazar_evento');
Route::post('eliminar_evento', 'entrenador\EntrenadorController@eliminarEvento')->name('eliminar_evento');

// =======================================================================================================

// Rutas ESTUDIANTE
Route::resource('estudiante', 'estudiante\EstudianteController');
Route::get('disponibilidad', 'estudiante\EstudianteController@disponibilidad')->name('estudiante.disponibilidad');




