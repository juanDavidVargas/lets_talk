<div class="row m-t-30">
    <div class="col-xs-12 col-sm-12 col-md-3">
        <div class="wrap-input100 validate-input" data-validate="Required">
            {!! Form::text('nombres', isset($usuario) ? $usuario->nombres : null, ['class' => 'input100', 'id' => 'nombres']) !!}
            <span class="focus-input100" data-placeholder="Name"></span>
        </div>

        {!! Form::hidden('id_usuario', isset($usuario) ? $usuario->id_user : null, ['class' => 'input100', 'id' => 'id_usuario']) !!}
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3">
        <div class="wrap-input100 validate-input" data-validate="Required">
            {!! Form::text('apellidos', isset($usuario) ? $usuario->apellidos : null, ['class' => 'input100', 'id' => 'apellidos']) !!}
            <span class="focus-input100" data-placeholder="Lastname"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3">
        <div class="wrap-input100 validate-input" data-validate="Required">
            {!! Form::select('id_tipo_documento', $tipo_documento, isset($usuario) ? $usuario->id_tipo_documento : null, ['class' => 'input100', 'id' => 'id_tipo_documento']) !!}
            <span class="focus-input100" data-placeholder="Document Type"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3">
        <div class="wrap-input100 validate-input" data-validate="Required">
            {!! Form::text('numero_documento', isset($usuario) ? $usuario->numero_documento : null, ['class' => 'input100', 'id' => 'numero_documento']) !!}
            <span class="focus-input100" data-placeholder="Document Number"></span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-3">
        <div class="wrap-input100 validate-input" data-validate="Required">
            {!! Form::select('id_municipio_nacimiento', $municipios, isset($usuario) ? $usuario->id_municipio_nacimiento : null, ['class' => 'input100', 'id' => 'id_municipio_nacimiento']) !!}
            <span class="focus-input100" data-placeholder="Place of Birth"></span>
        </div>
    </div>

    @php
    use Carbon\Carbon;
    $fecha_nacimiento_formato = isset($usuario) ? Carbon::parse($usuario->fecha_nacimiento) : null;
    @endphp

    <div class="col-xs-12 col-sm-12 col-md-3">
        <div class="wrap-input100">
            {!! Form::date('fecha_nacimiento', isset($fecha_nacimiento_formato) ? $fecha_nacimiento_formato : null, ['class' => 'input100', 'id' => 'fecha_nacimiento']) !!}
            <span class="focus-input100" data-placeholder="Date of Birth"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3">
        <div class="wrap-input100">
            {!! Form::select('genero', ['-1' => 'Select...', 'M' => 'Masculino', 'F' => 'Femenino'], isset($usuario) ? $usuario->genero : null, ['class' => 'input100', 'id' => 'genero']) !!}
            <span class="focus-input100" data-placeholder="Genre"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3">
        <div class="wrap-input100 validate-input" data-validate="State Is Required">
            {!! Form::select('estado', ['-1' => 'Select...', '1' => 'Activo', '0' => 'Inactivo'], isset($usuario) ? $usuario->estado : null, ['class' => 'input100', 'id' => 'estado']) !!}
            <span class="focus-input100" data-placeholder="State"></span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-3">
        <div class="wrap-input100 validate-input" data-validate="Required">
            {!! Form::select('id_primer_contacto', $primer_contacto, isset($usuario) ? $usuario->primer_contacto : null, ['class' => 'input100 select2', 'id' => 'id_primer_contacto']) !!}
            <span class="focus-input100" data-placeholder="First Contact"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3 ocultar" id="div_telefono">
        <div class="wrap-input100 validate-input" data-validate="Required">
            {!! Form::text('telefono', isset($usuario) ? $usuario->telefono : null, ['class' => 'input100', 'id' => 'telefono']) !!}
            <span class="focus-input100" data-placeholder="Phone"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3 ocultar" id="div_celular_whatsapp">
        <div class="wrap-input100 validate-input" data-validate="Required">
            {!! Form::text('celular', isset($usuario) ? $usuario->celular : null, ['class' => 'input100', 'id' => 'celular']) !!}
            <span class="focus-input100 text-danger" data-placeholder="Whatsapp" id="celular"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3 ocultar" id="div_correo">
        <div class="wrap-input100 validate-input" data-validate="Required">
            {!! Form::email('correo', isset($usuario) ? $usuario->correo : null, ['class' => 'input100', 'id' => 'correo']) !!}
            <span class="focus-input100 text-danger" data-placeholder="Email" id="correo"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3 ocultar" id="div_skype">
        <div class="wrap-input100 validate-input" data-validate="Required">
            {!! Form::text('skype', isset($usuario) ? $usuario->skype : null, ['class' => 'input100', 'id' => 'skype']) !!}
            <span class="focus-input100" data-placeholder="Skype"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3 ocultar" id="div_zoom">
        <div class="wrap-input100 validate-input" data-validate="Required">
            {!! Form::text('zoom', isset($usuario) ? $usuario->zoom : null, ['class' => 'input100', 'id' => 'zoom']) !!}
            <span class="focus-input100" data-placeholder="Zoom"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3" id="">
        <div class="wrap-input100">
            {!! Form::text('contacto_opcional', isset($usuario) ? $usuario->contacto_opcional : null, ['class' => 'input100', 'id' => 'contacto_opcional']) !!}
            <span class="focus-input100" data-placeholder="Optional Contact"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3" id="">
        <div class="wrap-input100">
            {!! Form::text('contacto2', isset($usuario) ? $usuario->contacto2 : null, ['class' => 'input100', 'id' => 'contacto2']) !!}
            <span class="focus-input100" data-placeholder="2nd Contact"></span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-3">
        <div class="wrap-input100">
            {!! Form::text('direccion_residencia', isset($usuario) ? $usuario->direccion_residencia : null, ['class' => 'input100', 'id' => 'direccion_residencia']) !!}
            <span class="focus-input100" data-placeholder="Residence Address"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3">
        <div class="wrap-input100">
            {!! Form::select('id_municipio_residencia', $municipios, isset($usuario) ? $usuario->id_municipio_residencia : null, ['class' => 'input100', 'id' => 'id_municipio_residencia']) !!}
            <span class="focus-input100" data-placeholder="Residence City"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3">
        <div class="wrap-input100 validate-input" data-validate="Required">
            {!! Form::select('id_rol', $roles, isset($usuario) ? $usuario->id_rol : null, ['class' => 'input100', 'id' => 'id_rol']) !!}
            <span class="focus-input100" data-placeholder="Role"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3 ocultar" id="div_nivel">
        <div class="wrap-input100 validate-input" data-validate="Required">
            {!! Form::select('id_nivel', $niveles, isset($usuario) ? $usuario->id_nivel : null, ['class' => 'input100', 'id' => 'id_nivel']) !!}
            <span class="focus-input100" data-placeholder="Level"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3 ocultar" id="div_tipo_ing">
        <div class="wrap-input100 validate-input" data-validate="Required">
            {!! Form::select('id_tipo_ingles', $tipo_ingles, isset($usuario) ? $usuario->id_tipo_ingles : null, ['class' => 'input100', 'id' => 'id_tipo_ingles']) !!}
            <span class="focus-input100" data-placeholder="English"></span>
        </div>
    </div>
</div>

<div class="row m-b-45">
    <div class="col-xs-12 col-sm-12 col-md-4 col-md-offset-4">
        <div class="container-login100-form-btn">
            <div class="wrap-login100-form-btn">
                <div class="login100-form-bgbtn"></div>
                <button class="login100-form-btn" type="submit" id="btn_save_user" name="btn_save_user">
                    Save
                </button>
            </div>
        </div>
    </div>
</div>
