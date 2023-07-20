<?php

namespace App\Http\Controllers\inicio_sesion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Responses\inicio_sesion\LoginStore;
use Exception;
use Illuminate\Support\Facades\Session;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordRecovery\MailPasswordRecovery;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

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
        // dd($request);
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

    public function recoveryPasswordEmail(Request $request)
    {
        $emailRecovery = $request->pass_recovery;
        $documentRecovery = $request->numero_documento;

        $consultaRecoveryPass = User::select('id_user','usuario','correo', 'numero_documento')
                                    ->where('correo', $emailRecovery)
                                    ->where('numero_documento', $documentRecovery)
                                    ->first();

        if (isset($consultaRecoveryPass) && !empty($consultaRecoveryPass) && !is_null($consultaRecoveryPass)) {
            $idUserRecovery = $consultaRecoveryPass->id_user;
            $usuarioRecovery = $consultaRecoveryPass->usuario;
            $correoRecovery = $consultaRecoveryPass->correo;

            Mail::to($correoRecovery)
            ->send(new MailPasswordRecovery($idUserRecovery, $usuarioRecovery, $correoRecovery));
            alert()->info('Info','The recovery password information has been sent to your email.');
            return view('inicio_sesion.login');
        } else {
            alert()->error('Error','Please, verify your email and Document Id, one of them does not exist.');
            return back();
        }
    }

    public function recoveryPasswordLink($id)
    {
        return view('inicio_sesion.recovery_password_link', compact('id'));
    }

    public function recoveryPasswordPost(Request $request)
    {
        $idUser = $request->id_user;
        $newPass = $request->new_pass;
        $confirmNewPass = $request->confirm_new_pass;

        if ($newPass != $confirmNewPass) {
            alert()->error('Error','New Password and Confirm New Password must be the same!');
            return back();
        } else {
            DB::connection('mysql')->beginTransaction();

            try {
                $userPassUpdate = User::where('id_user', $idUser)
                                        ->update(
                                            [
                                                'password' => Hash::make($newPass)
                                            ]
                                        );

                if($userPassUpdate) {
                    DB::connection('mysql')->commit();
                    alert()->success('Successfull Process', 'Password updated correctly.');
                    return view('inicio_sesion.login');

                } else {
                    DB::connection('mysql')->rollback();
                    alert()->error('error', 'An error occurred updating the user, try again, if the problem persists contact support.');
                    return back();
                }
            } catch (Exception $e) {
                dd($e);
                DB::connection('mysql')->rollback();
                alert()->error('Error', 'An error occurred updating the user, try again, if the problem persists contact support.');
                return back();
            }
        }
    }
}
