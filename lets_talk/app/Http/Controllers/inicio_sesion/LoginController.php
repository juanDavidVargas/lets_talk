<?php

namespace App\Http\Controllers\inicio_sesion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Responses\inicio_sesion\LoginStore;
use Exception;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('inicio_sesion.login_entrenador');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return new LoginStore();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function resetPassword()
    {
        return view('inicio_sesion.resetear_password');
    }

    public function resetPasswordStudent()
    {
        return view('inicio_sesion.resetear_password_estudiante');
    }

    public function loginEstudiante()
    {
        return view('inicio_sesion.login_estudiante');
    }

    public function recoveryPassword(Request $request)
    {
        return view('inicio_sesion.recovery_password');
    }

    public function logout(Request $request)
    {
        try {

            Session::forget('usuario_id');
            Session::forget('username');
            Session::forget('sesion_iniciada');
            Session::forget('rol');
            Session::flush();
            $request->session()->flush();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->to(route('home'));

        } catch (Exception $e)
        {
            alert()->error('Error','An error has occurred, try again, if the problem persists contact support.');
            return back();
        }
    }
}