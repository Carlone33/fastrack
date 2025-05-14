<div>

@foreach ( $registrosPoliciales as $resultado )

    <div>

        Guía: {{ $resultado->guia }} </br>
        Solicitante: {{ $resultado->solicitud->solicitante->primer_nombre }}

    </div>


@endforeach


</div>
