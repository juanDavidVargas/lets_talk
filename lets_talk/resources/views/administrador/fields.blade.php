<div class="row m-t-30">
    <div class="col-xs-12 col-sm-12 col-md-3">
        <div class="wrap-input100 validate-input" data-validate="Required">
            {!! Form::text('nombres', isset($usuario) ? $usuario->nombres : null, ['class' => 'input100', 'id' => 'nombres']) !!}
            <span class="focus-input100" data-placeholder="Name"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3">
        <div class="wrap-input100 validate-input" data-validate="Required">
            {!! Form::text('apellidos', isset($usuario) ? $usuario->apellidos : null, ['class' => 'input100', 'id' => 'apellidos']) !!}
            <span class="focus-input100" data-placeholder="Surname"></span>
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
            {!! Form::select('genero', ['-1' => 'Select...', 'M' => 'Masculino', 'F' => 'Femenino'], null, ['class' => 'input100', 'id' => 'genero']) !!}
            <span class="focus-input100" data-placeholder="Genre"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3">
        <div class="wrap-input100 validate-input" data-validate="State Is Required">
            {!! Form::select('estado', ['-1' => 'Select...', '1' => 'Activo', '0' => 'Inactivo'], null, ['class' => 'input100', 'id' => 'estado']) !!}
            <span class="focus-input100" data-placeholder="State"></span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-3">
        <div class="wrap-input100">
            {!! Form::text('telefono', null, ['class' => 'input100', 'id' => 'telefono']) !!}
            <span class="focus-input100" data-placeholder="Phone"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3">
        <div class="wrap-input100">
            {!! Form::text('celular', null, ['class' => 'input100', 'id' => 'celular']) !!}
            <span class="focus-input100" data-placeholder="Cell Phone"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3">
        <div class="wrap-input100 validate-input" data-validate="Required">
            {!! Form::email('correo', null, ['class' => 'input100', 'id' => 'correo']) !!}
            <span class="focus-input100" data-placeholder="Email"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3">
        <div class="wrap-input100">
            {!! Form::text('direccion_residencia', null, ['class' => 'input100', 'id' => 'direccion_residencia']) !!}
            <span class="focus-input100" data-placeholder="Residence Address"></span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-3">
        <div class="wrap-input100">
            {!! Form::select('id_municipio_residencia', $municipios, null, ['class' => 'input100', 'id' => 'id_municipio_residencia']) !!}
            <span class="focus-input100" data-placeholder="Residence City"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3">
        <div class="wrap-input100 validate-input" data-validate="Required">
            {!! Form::select('id_rol', $roles, null, ['class' => 'input100', 'id' => 'id_rol']) !!}
            <span class="focus-input100" data-placeholder="Role"></span>
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
