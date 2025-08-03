<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Date;
use Carbon\Carbon;
use App\Models\Solicitud;
use App\Models\SolicitudAdministrativa;
use App\Models\Persona;
use App\Models\Funcionario;

class SolicitudAdministrativaSeeder extends Seeder
{
    public function run()
    {
        // Crear persona de ejemplo
        $persona = Persona::create([
            'primer_nombre' => 'EDUARDO',
            'segundo_nombre' => 'JOSE',
            'primer_apellido' => 'GONZALES',
            'segundo_apellido' => 'JIMENEZ',
            'nacionalidad' => 'V',
            'cedula' => 'V12345678',
            'sexo' => 'M',
            'correo' => 'ejemplo@demo.com',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear funcionario de ejemplo
        $funcionario = Funcionario::create([
            'persona_id' => $persona->id,
            'unidad_administrativa_id' => null,
            'credencial' => 'FUNC-ADM-001',
            'rango' => 'Oficial',
            'cargo' => 'Registrador',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $registrador_funcionario_id = $funcionario->id;
        $solicitante_persona_id = $persona->id;
        $abogado_funcionario_id = $funcionario->id;
        $apoderado_persona_id = null; // Opcional
        $guia = 'ADM-' . strtoupper(uniqid());
        $fecha = Carbon::now();

        // 1. Crear la solicitud principal
        $solicitud = Solicitud::create([
            'tipo_solicitud' => 'Administrativa',
            'fecha_registro' => $fecha->toDateString(),
            'registrador_funcionario_id' => $registrador_funcionario_id,
            'solicitante_persona_id' => $solicitante_persona_id,
            'fecha_solicitud' => $fecha->toDateString(),
            'hora_solicitud' => $fecha->toTimeString(),
            'estado_solicitud' => 'Pendiente',
            'apoderado_persona_id' => $apoderado_persona_id,
            'abogado_funcionario_id' => $abogado_funcionario_id,
            'created_at' => $fecha,
            'updated_at' => $fecha,
        ]);

        // 2. Crear la solicitud administrativa
        SolicitudAdministrativa::create([
            'solicitud_id' => $solicitud->id,
            'guia' => $guia,
            'created_at' => $fecha,
            'updated_at' => $fecha,
        ]);
    }
}
