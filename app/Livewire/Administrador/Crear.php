<?php

namespace App\Livewire\Administrador;

use Livewire\Component;
use App\Models\Persona;
use App\Models\Funcionario;
use Illuminate\Support\Facades\Validator;

class Crear extends Component
{
    public $persona = [
        'primer_nombre' => '',
        'segundo_nombre' => '',
        'primer_apellido' => '',
        'segundo_apellido' => '',
        'nacionalidad' => 'V',
        'cedula' => '',
        'sexo' => 'M',
        'correo' => '',
    ];
    public $credencial = '';
    public $unidad_administrativa_id = '';

    public $success = false;
    public $error = '';
    public $rol = '';


    protected $rules = [
        'persona.primer_nombre' => 'required|string|max:50',
        'persona.primer_apellido' => 'required|string|max:50',
        'persona.nacionalidad' => 'required|in:V,E',
        'persona.cedula' => 'required|numeric|digits_between:6,10|unique:persona,cedula',
        'persona.sexo' => 'required|in:M,F',
        'persona.correo' => 'required|email',
        'credencial' => 'required|string|max:20|unique:funcionario,credencial',
        'rol' => 'required|string|exists:roles,name',
    ];

    public function guardarFuncionario()
    {
        $this->validate();

        $persona = Persona::create($this->persona);
        $funcionario = Funcionario::create([
            'persona_id' => $persona->id,
            'credencial' => $this->credencial,
            'unidad_administrativa_id' => 8,
            ]);

            // Crear usuario y asignar rol
            $user = \App\Models\User::create([
                'funcionario_id' => $funcionario->id,
                'password' => bcrypt('temporal123'),
                'habilitado' => true,
                'intentos_fallidos' => 0,
                'eliminado' => false,
                'bloqueado' => false,
                'fecha_ultimo_cambio_contrasena' => now(),
                'observaciones' => null,
                'pregunta_1' => null,
                'respuesta_1' => null,
                'pregunta_2' => null,
                'respuesta_2' => null,
                'pregunta_3' => null,

                'respuesta_3' => null,
            ]);
            if ($user && $user->id) {
                $user->assignRole($this->rol);
                return redirect()->route('admin');
            } else {
                $this->error = 'No se pudo crear el usuario. Verifica los datos o la conexión.';
                $this->success = false;
            }
    }

    // Devuelve los roles disponibles para el select
    public function getRolesProperty()
    {
        return \Spatie\Permission\Models\Role::all();
    }

    public function limpiarCampos()
    {
        $this->reset(['persona', 'credencial', 'unidad_administrativa_id', 'success', 'error']);
    }

    public function render()
    {
        return view('livewire.administrador.crear');
    }

}
