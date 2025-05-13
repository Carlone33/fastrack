<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Persona;
use App\Models\Funcionario;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = [
            [
                'persona' => [
                    'primer_nombre' => 'Carlos',
                    'primer_apellido' => 'Admin',
                    'nacionalidad' => 'V',
                    'cedula' => '00000001',
                    'sexo' => 'M',
                    'correo' => 'admin@example.com',
                ],
                'funcionario' => ['credencial' => 'admin01'],
                'password' => '00000',
                'rol' => 'Administrador',
            ],
            [
                'persona' => [
                    'primer_nombre' => 'Paula',
                    'primer_apellido' => 'Permisologa',
                    'nacionalidad' => 'V',
                    'cedula' => '00000002',
                    'sexo' => 'F',
                    'correo' => 'permisologo@example.com',
                ],
                'funcionario' => ['credencial' => 'permi01'],
                'password' => '00000',
                'rol' => 'Permisologo',
            ],
            [
                'persona' => [
                    'primer_nombre' => 'Tomas',
                    'primer_apellido' => 'Transcriptor',
                    'nacionalidad' => 'V',
                    'cedula' => '00000003',
                    'sexo' => 'M',
                    'correo' => 'transcriptor@example.com',
                ],
                'funcionario' => ['credencial' => 'trans01'],
                'password' => '00000',
                'rol' => 'Transcriptor',
            ],
            [
                'persona' => [
                    'primer_nombre' => 'Pedro',
                    'primer_apellido' => 'Superadmin',
                    'nacionalidad' => 'V',
                    'cedula' => '00000004',
                    'sexo' => 'M',
                    'correo' => 'superadmin@example.com',
                ],
                'funcionario' => ['credencial' => '00000'],
                'password' => 'carlos33',
                'rol' => 'Superadministrador',
            ],
            [
                'persona' => [
                    'primer_nombre' => 'Tristan',
                    'segundo_nombre' => 'Ricardo',
                    'primer_apellido' => 'Gonzalez',
                    'segundo_apellido' => 'Hidalgo',
                    'nacionalidad' => 'E',
                    'cedula' => '00000005',
                    'sexo' => 'M',
                    'correo' => 'abogado@example.com',
                ],
                'funcionario' => ['credencial' => '33333'],
                'password' => 'carlos33',
                'rol' => 'Abogado',
            ],
            [
                'persona' => [
                    'primer_nombre' => 'Erika',
                    'segundo_nombre' => 'Emilia',
                    'primer_apellido' => 'Correa',
                    'segundo_apellido' => 'Rojas',
                    'nacionalidad' => 'E',
                    'cedula' => '00000006',
                    'sexo' => 'F',
                    'correo' => 'abogada@example.com',
                ],
                'funcionario' => ['credencial' => '44444'],
                'password' => 'carlos33',
                'rol' => 'Abogado',
            ],
            [
                'persona' => [
                    'primer_nombre' => 'Johana',
                    'segundo_nombre' => 'Josefina',
                    'primer_apellido' => 'Eliparo',
                    'segundo_apellido' => 'Colmenares',
                    'nacionalidad' => 'E',
                    'cedula' => '00000007',
                    'sexo' => 'F',
                    'correo' => 'abogad2a@example.com',
                ],
                'funcionario' => ['credencial' => '44445'],
                'password' => 'carlos33',
                'rol' => 'Abogado',
            ],
        ];

        foreach ($usuarios as $u) {
            $persona = Persona::create($u['persona']);
            $funcionario = Funcionario::create([
                'persona_id' => $persona->id,
                'credencial' => $u['funcionario']['credencial'],
            ]);
            User::create([
                'funcionario_id' => $funcionario->id,
                'password' => bcrypt($u['password']),
                'habilitado' => true
            ])->syncRoles([$u['rol']]);
        }
    }
}
