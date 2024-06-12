@component('mail::message')

@component('mail::panel')
#Placas de vehículos con Mantenimiento tipo Preventivo próximo a vencer

@component('mail::table')
|          PLACA         |         KM ACTUAL      |        KM VENCE        |       UBICACIÓN        |
|:----------------------:|:----------------------:|:----------------------:|:----------------------:|
@foreach ($array_placa_mtto as $placas)
| <a href="https://servicios.spe.com.co/administracion/ver_mtto/{{$placas['segaut_codigo']}}" target="_blank"><strong>{{$placas['placa']}}</strong></a> | {{$placas['kilometraje']}} | {{$placas['Km_Vencer']}} | {{$placas['ubicacion_placa']}} |
@endforeach
@endcomponent
@endcomponent

Mensaje automático por favor no responder.

Gracias
SPE
@endcomponent
