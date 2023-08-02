<div class="row m-t-30">
    <div class="col-xs-12 col-sm-12 col-md-3">
        <div class="wrap-input100 validate-input" data-validate="This Field is Required">
            {!! Form::text('nombres', isset($usuario) ? $usuario->nombres : null, ['class' => 'input100', 'id' => 'nombres']) !!}
            <span class="focus-input100" data-placeholder="Name"></span>
        </div>

        {!! Form::hidden('id_usuario', isset($usuario) ? $usuario->id_user : null, ['class' => 'input100', 'id' => 'id_usuario']) !!}
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3">
        <div class="wrap-input100 validate-input" data-validate="This Field is Required">
            {!! Form::text('apellidos', isset($usuario) ? $usuario->apellidos : null, ['class' => 'input100', 'id' => 'apellidos']) !!}
            <span class="focus-input100" data-placeholder="Lastname"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3">
        <div class="wrap-input100 validate-input" data-validate="This Field is Required">
            {!! Form::select('id_tipo_documento', $tipo_documento, isset($usuario) ? $usuario->id_tipo_documento : null, ['class' => 'input100', 'id' => 'id_tipo_documento']) !!}
            <span class="focus-input100" data-placeholder="Document Type"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3">
        <div class="wrap-input100 validate-input" data-validate="This Field is Required">
            {!! Form::text('numero_documento', isset($usuario) ? $usuario->numero_documento : null, ['class' => 'input100', 'id' => 'numero_documento']) !!}
            <span class="focus-input100" data-placeholder="Document Number"></span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-3">
        <div class="wrap-input100 validate-input" data-validate="This Field is Required">
            {!! Form::select('id_municipio_nacimiento', $municipios, isset($usuario) ? $usuario->id_municipio_nacimiento : null, ['class' => 'input100', 'id' => 'id_municipio_nacimiento']) !!}
            <span class="focus-input100" data-placeholder="Place of Birth"></span>
        </div>
    </div>

    @php
        use Carbon\Carbon;
        $fecha_nacimiento_formato = isset($usuario) ? Carbon::parse($usuario->fecha_nacimiento) : null;
    @endphp

    <div class="col-xs-12 col-sm-12 col-md-3">
        <div class="wrap-input100" >
            {!! Form::date('fecha_nacimiento', isset($fecha_nacimiento_formato) ? $fecha_nacimiento_formato : null, ['class' => 'input100', 'id' => 'fecha_nacimiento']) !!}
            <span class="focus-input100" data-placeholder="Date of Birth"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3">
        <div class="wrap-input100 validate-input" data-validate="This Field is Required">
            {!! Form::select('genero', ['-1' => 'Select...', 'M' => 'Masculino', 'F' => 'Femenino'], isset($usuario) ? $usuario->genero : null, ['class' => 'input100', 'id' => 'genero']) !!}
            <span class="focus-input100" data-placeholder="Genre"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3">
        <div class="wrap-input100 validate-input" data-validate="data-validate="This Field is Required">
            {!! Form::select('estado', ['-1' => 'Select...', '1' => 'Activo', '0' => 'Inactivo'], isset($usuario) ? $usuario->estado : null, ['class' => 'input100', 'id' => 'estado']) !!}
            <span class="focus-input100" data-placeholder="State"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3" id="div_correo">
        <div class="wrap-input100 validate-input" data-validate="This Field is Required">
            {!! Form::email('correo', isset($usuario) ? $usuario->correo : null, ['class' => 'input100', 'id' => 'correo']) !!}
            <span class="focus-input100 text-danger" data-placeholder="Email" id="correo"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3">
        <div class="wrap-input100 validate-input" data-validate="This Field is Required">
            {!! Form::text('celular', isset($usuario) ? $usuario->celular : null, ['class' => 'input100', 'id' => 'celular']) !!}
            <span class="focus-input100 text-danger" data-placeholder="Whatsapp"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3">
        <div class="wrap-input100">
            {!! Form::text('zoom', isset($usuario) ? $usuario->zoom : null, ['class' => 'input100', 'id' => 'zoom']) !!}
            <span class="focus-input100" data-placeholder="Zoom"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3">
        <div class="wrap-input100">
            {!! Form::text('zoom_clave', isset($usuario) ? $usuario->zoom_clave : null, ['class' => 'input100', 'id' => 'zoom_clave']) !!}
            <span class="focus-input100" data-placeholder="Zoom Pass"></span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-3" id="div_id_primer_contacto">
        <div class="wrap-input100 validate-input" data-validate="This Field is Required">
            {!! Form::select('id_primer_contacto', $tipo_contacto, isset($usuario) ? $usuario->primer_contacto_tipo : null, ['class' => 'input100 select2', 'id' => 'id_primer_contacto']) !!}
            <span class="focus-input100" data-placeholder="First Contact"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3 ocultar" id="div_primer_telefono">
        <div class="wrap-input100 validate-input" data-validate="This Field is Required">
            {!! Form::text('primer_telefono', isset($usuario) ? $usuario->primer_telefono : null, ['class' => 'input100', 'id' => 'primer_telefono']) !!}
            <span class="focus-input100" data-placeholder="Phone"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3 ocultar" id="div_primer_celular_whatsapp">
        <div class="wrap-input100 validate-input" data-validate="This Field is Required">
            {!! Form::text('primer_celular', isset($usuario) ? $usuario->primer_celular : null, ['class' => 'input100', 'id' => 'primer_celular']) !!}
            <span class="focus-input100 text-danger" data-placeholder="Whatsapp"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3 ocultar" id="div_primer_correo">
        <div class="wrap-input100 validate-input" data-validate="This Field is Required">
            {!! Form::email('primer_correo', isset($usuario) ? $usuario->primer_correo : null, ['class' => 'input100', 'id' => 'primer_correo']) !!}
            <span class="focus-input100 text-danger" data-placeholder="Email"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3 ocultar" id="div_primer_skype">
        <div class="wrap-input100 validate-input" data-validate="This Field is Required">
            {!! Form::text('primer_skype', isset($usuario) ? $usuario->primer_skype : null, ['class' => 'input100', 'id' => 'primer_skype']) !!}
            <span class="focus-input100" data-placeholder="Skype"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3 ocultar" id="div_primer_zoom">
        <div class="wrap-input100 validate-input" data-validate="This Field is Required">
            {!! Form::text('primer_zoom', isset($usuario) ? $usuario->primer_zoom : null, ['class' => 'input100', 'id' => 'primer_zoom']) !!}
            <span class="focus-input100" data-placeholder="Zoom"></span>
        </div>
    </div>

    {{-- ========================================= --}}

    <div class="col-xs-12 col-sm-12 col-md-3" id="div_id_segundo_contacto">
        <div class="wrap-input100">
            {!! Form::select('id_segundo_contacto', $tipo_contacto, isset($usuario) ? $usuario->segundo_contacto_tipo : null, ['class' => 'input100 select2', 'id' => 'id_segundo_contacto']) !!}
            <span class="focus-input100" data-placeholder="Second Contact"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3 ocultar" id="div_segundo_telefono">
        <div class="wrap-input100">
            {!! Form::text('segundo_telefono', isset($usuario) ? $usuario->segundo_telefono : null, ['class' => 'input100', 'id' => 'segundo_telefono']) !!}
            <span class="focus-input100" data-placeholder="Phone"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3 ocultar" id="div_segundo_celular_whatsapp">
        <div class="wrap-input100">
            {!! Form::text('segundo_celular', isset($usuario) ? $usuario->segundo_celular : null, ['class' => 'input100', 'id' => 'segundo_celular']) !!}
            <span class="focus-input100 text-danger" data-placeholder="Whatsapp"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3 ocultar" id="div_segundo_correo">
        <div class="wrap-input100">
            {!! Form::email('segundo_correo', isset($usuario) ? $usuario->segundo_correo : null, ['class' => 'input100', 'id' => 'segundo_correo']) !!}
            <span class="focus-input100 text-danger" data-placeholder="Email"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3 ocultar" id="div_segundo_skype">
        <div class="wrap-input100">
            {!! Form::text('segundo_skype', isset($usuario) ? $usuario->segundo_skype : null, ['class' => 'input100', 'id' => 'segundo_skype']) !!}
            <span class="focus-input100" data-placeholder="Skype"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3 ocultar" id="div_segundo_zoom">
        <div class="wrap-input100">
            {!! Form::text('segundo_zoom', isset($usuario) ? $usuario->segundo_zoom : null, ['class' => 'input100', 'id' => 'segundo_zoom']) !!}
            <span class="focus-input100" data-placeholder="Zoom"></span>
        </div>
    </div>

    {{-- ========================================= --}}

    <div class="col-xs-12 col-sm-12 col-md-3" id="div_id_opcional_contacto">
        <div class="wrap-input100">
            {!! Form::select('id_opcional_contacto', $tipo_contacto, isset($usuario) ? $usuario->opcional_contacto_tipo : null, ['class' => 'input100 select2', 'id' => 'id_opcional_contacto']) !!}
            <span class="focus-input100" data-placeholder="Optional Contact"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3 ocultar" id="div_opcional_telefono">
        <div class="wrap-input100">
            {!! Form::text('opcional_telefono', isset($usuario) ? $usuario->opcional_telefono : null, ['class' => 'input100', 'id' => 'opcional_telefono']) !!}
            <span class="focus-input100" data-placeholder="Phone"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3 ocultar" id="div_opcional_celular_whatsapp">
        <div class="wrap-input100">
            {!! Form::text('opcional_celular', isset($usuario) ? $usuario->opcional_celular : null, ['class' => 'input100', 'id' => 'opcional_celular']) !!}
            <span class="focus-input100 text-danger" data-placeholder="Whatsapp"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3 ocultar" id="div_opcional_correo">
        <div class="wrap-input100">
            {!! Form::email('opcional_correo', isset($usuario) ? $usuario->opcional_correo : null, ['class' => 'input100', 'id' => 'opcional_correo']) !!}
            <span class="focus-input100 text-danger" data-placeholder="Email"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3 ocultar" id="div_opcional_skype">
        <div class="wrap-input100">
            {!! Form::text('opcional_skype', isset($usuario) ? $usuario->opcional_skype : null, ['class' => 'input100', 'id' => 'opcional_skype']) !!}
            <span class="focus-input100" data-placeholder="Skype"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3 ocultar" id="div_opcional_zoom">
        <div class="wrap-input100">
            {!! Form::text('opcional_zoom', isset($usuario) ? $usuario->opcional_zoom : null, ['class' => 'input100', 'id' => 'opcional_zoom']) !!}
            <span class="focus-input100" data-placeholder="Zoom"></span>
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
        <div class="wrap-input100 validate-input" data-validate="This Field is Required">
            {!! Form::select('id_rol', $roles, isset($usuario) ? $usuario->id_rol : null, ['class' => 'input100', 'id' => 'id_rol']) !!}
            <span class="focus-input100" data-placeholder="Role"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3 ocultar" id="div_nivel">
        <div class="wrap-input100 validate-input" data-validate="This Field is Required">
            {!! Form::select('id_nivel', $niveles, isset($usuario) ? $usuario->id_nivel : null, ['class' => 'input100', 'id' => 'id_nivel']) !!}
            <span class="focus-input100" data-placeholder="Level"></span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3 ocultar" id="div_tipo_ing">
        <div class="wrap-input100 validate-input" data-validate="This Field is Required">
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
                <button class="login100-form-btn" type="submit" id="btn_save_user" name="btn_save_user">Save</button>
            </div>
        </div>
    </div>
</div>
