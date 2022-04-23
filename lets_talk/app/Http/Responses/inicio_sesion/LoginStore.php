<?php

namespace App\Http\Responses\inicio_sesion;

use Illuminate\Contracts\Support\Responsable;

class LoginStore implements Responsable
{
    public function toResponse($request)
    {
        $username = request('username', null);
        $pass = request('pass', null);


        dd("desde login store", $username, $pass);
    }
}
