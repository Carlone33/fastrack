<?php

namespace Database\Seeders;

use App\Models\RegistroPolicial;
use App\Models\RegistroSolicitud;
use App\Models\Solicitud;
use App\Models\Persona;
use App\Models\Telefono;
use App\Models\Direccion;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class TestSeeder extends Seeder
{

    public function run(): void
    {
        $registros = [
            'registro1' => [
                'persona' => [
                    'nacionalidad' => 'V',
                    'cedula' => '23710807',
                    'primer_nombre' => 'SANTIAGO',
                    'segundo_nombre' => 'DE JESÚS',
                    'primer_apellido' => 'PINO',
                    'segundo_apellido' => 'MADRID',
                    'sexo' => 'M',
                    'correo' => 'example@hotmail.com',
                ],
                'telefono' => [
                    'tipo' => 'Celular',
                    'numero' => '0414-1234567',
                ],
                'solicitud' => [
                    'tipo_solicitud' => 'REGISTRO POLICIAL',
                    'registrador_funcionario_id' => 4,
                    'abogado_funcionario_id' => 8,
                    'fecha_registro' => now()->format('Y-m-d'),
                    'fecha_solicitud' => now()->format('Y-m-d'),
                    'hora_solicitud' => now()->format('H:i:s'),
                    'estado_solicitud' => 'En Proceso',
                ],
                'registro_solicitud' => [
                    'delito' => 'TRAFICO ILICITO DE ESTUPEFACIENTES Y PSICOTROPICOS EN MENOR CUANTIA',
                ],
                'registro_policial' => [
                    'guia' => 'REGPOL-2025-0564',
                    'numero_oficio' => '98524',
                    'fecha_oficio' => now()->format('Y-m-d'),
                    'numero_expediente_tribunal' => '16C-19478-22',
                    'motivo' => 'SOBRESEIMIENTO DE LA CAUSA',
                    'nombre_tribunal' => 'JUZGADO DECIMO SEXTO CIRCUITO JUDICIAL PENAL DEL ÁREA METROPOLITANA DE CARACAS',
                ],
                'direccion' => [
                    'estado' => 'MIRANDA',
                    'municipio' => 'SUCRE',
                    'parroquia' => 'PETARE',
                    'calle' => 'AV. SUCRE, EDIFICIO EL NACIONAL, PISO 2',
                    'casa-edificio' => 'EDIFICIO EL NACIONAL',
                    'apartamento' => '2',
                    'piso' => '2',
                ],
            ],
            'registro2' => [
                'persona' => [
                    'nacionalidad' => 'V',
                    'cedula' => '29398396',
                    'primer_nombre' => 'JOSE',
                    'segundo_nombre' => 'JOAQUIN',
                    'primer_apellido' => 'GONZALES',
                    'segundo_apellido' => 'MADRID',
                    'sexo' => 'M',
                    'correo' => 'example@hotmail.com',
                ],
                'telefono' => [
                    'tipo' => 'Celular',
                    'numero' => '0414-1234567',
                ],
                'solicitud' => [
                    'tipo_solicitud' => 'REGISTRO POLICIAL',
                    'registrador_funcionario_id' => 4,
                    'abogado_funcionario_id' => 8,
                    'fecha_registro' => now()->format('Y-m-d'),
                    'fecha_solicitud' => now()->format('Y-m-d'),
                    'hora_solicitud' => now()->format('H:i:s'),
                    'estado_solicitud' => 'En Proceso',
                ],
                'registro_solicitud' => [
                    'delito' => 'TRAFICO ILICITO DE ESTUPEFACIENTES Y PSICOTROPICOS EN MENOR CUANTIA',
                ],
                'registro_policial' => [
                    'guia' => 'REGPOL-2025-0565',
                    'numero_oficio' => '98524',
                    'fecha_oficio' => now()->format('Y-m-d'),
                    'numero_expediente_tribunal' => '16C-19478-22',
                    'motivo' => 'SOBRESEIMIENTO DE LA CAUSA',
                    'nombre_tribunal' => 'JUZGADO DECIMO SEXTO CIRCUITO JUDICIAL PENAL DEL ÁREA METROPOLITANA DE CARACAS',
                ],
                'direccion' => [
                    'estado' => 'MIRANDA',
                    'municipio' => 'SUCRE',
                    'parroquia' => 'PETARE',
                    'calle' => 'AV. SUCRE, EDIFICIO EL NACIONAL, PISO 2',
                    'casa-edificio' => 'EDIFICIO EL NACIONAL',
                    'apartamento' => '2',
                    'piso' => '2',
                ],
            ],
        ];

        foreach ($registros as $registro) {
            // 1. Crear persona
            $persona = Persona::create($registro['persona']);

            // 2. Crear dirección y asociar a persona (asumiendo relación persona->direcciones)
            $direccion = new Direccion($registro['direccion']);
            $persona->direcciones()->save($direccion);

            // 3. Crear teléfono y asociar a persona (asumiendo relación persona->telefonos)
            $telefono = new Telefono($registro['telefono']);
            $persona->telefonos()->save($telefono);

            // 4. Crear solicitud y asociar persona como solicitante
            $solicitudData = $registro['solicitud'];
            $solicitudData['solicitante_persona_id'] = $persona->id;
            $solicitud = Solicitud::create($solicitudData);

            // 5. Crear registro_solicitud y asociar a solicitud
            $registroSolicitudData = $registro['registro_solicitud'];
            $registroSolicitudData['solicitud_id'] = $solicitud->id;
            $registroSolicitud = RegistroSolicitud::create($registroSolicitudData);

            // 6. Crear registro_policial y asociar a solicitud
            $registroPolicialData = $registro['registro_policial'];
            $registroPolicialData['solicitud_id'] = $solicitud->id;
            RegistroPolicial::create($registroPolicialData);
        }
    }
}
