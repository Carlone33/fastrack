<?php

namespace App\Livewire\Administrador;

use Livewire\Component;
use App\Models\Funcionario;
use App\Models\Persona;
use App\Models\User;
use Spatie\Permission\Models\Role;

class Editar extends Component
{

    public $funcionarioId;
    public $funcionarioData = [];
    public $roles = [];

 protected $rules = [
        'funcionarioData.correo' => 'required|email',
        'funcionarioData.telefono' => 'required|regex:/^0[0-9]{3}-[0-9]{7}$/',
        'funcionarioData.credencial' => 'required',
        'funcionarioData.rol' => 'required',
    ];

    protected $listeners = ['recibirFuncionarioId'];

    public function mount($id = null)
    {
        if ($id) {
            $this->funcionarioId = $id;
            $this->cargarDatosFuncionario();
        }
        $this->roles = Role::pluck('name')->toArray();
    }

    public function recibirFuncionarioId($id)
    {
        $this->funcionarioId = $id;
        $this->cargarDatosFuncionario();
    }

    public function cargarDatosFuncionario()
    {
        $funcionario = Funcionario::with(['persona.telefonos', 'user.roles'])->find($this->funcionarioId);
        if ($funcionario) {
            $telefono = $funcionario->persona->telefonos->first();
            $this->funcionarioData = [
                'credencial' => $funcionario->credencial,
                'rol' => $funcionario->user->roles->pluck('name')->first() ?? '',
                'correo' => $funcionario->persona->correo ?? '',
                'telefono' => $telefono ? $telefono->numero : '',
                'cedula' => $funcionario->persona->cedula ?? '',
                'persona' => [
                    'primer_nombre' => $funcionario->persona->primer_nombre ?? '',
                    'segundo_nombre' => $funcionario->persona->segundo_nombre ?? '',
                    'primer_apellido' => $funcionario->persona->primer_apellido ?? '',
                    'segundo_apellido' => $funcionario->persona->segundo_apellido ?? '',
                ],
            ];
        }
    }

    public function guardarCambios()
    {
        $this->validate();
        $funcionario = Funcionario::with(['persona.telefonos', 'user.roles'])->find($this->funcionarioId);
        if ($funcionario) {
            // Actualizar credencial
            $funcionario->credencial = $this->funcionarioData['credencial'] ?? $funcionario->credencial;
            $funcionario->save();

            // Actualizar correo en persona
            if ($funcionario->persona) {
                $funcionario->persona->correo = $this->funcionarioData['correo'] ?? $funcionario->persona->correo;
                $funcionario->persona->save();
            }

            // Formatear teléfono antes de guardar
            $telefonoFormateado = preg_replace('/[^0-9]/', '', $this->funcionarioData['telefono']);
            if (strlen($telefonoFormateado) === 11) {
                $telefonoFormateado = substr($telefonoFormateado, 0, 4) . '-' . substr($telefonoFormateado, 4);
            }

            // Actualizar o crear teléfono
            if ($funcionario->persona) {
                if ($funcionario->persona->telefonos->count() > 0) {
                    $telefono = $funcionario->persona->telefonos->first();
                    $telefono->numero = $telefonoFormateado;
                    $telefono->save();
                } else {
                    $nuevoTelefono = new \App\Models\Telefono([
                        'numero' => $telefonoFormateado,
                        'tipo' => 'movil',
                    ]);
                    $funcionario->persona->telefonos()->save($nuevoTelefono);
                }
            }

            // Actualizar rol
            if ($funcionario->user) {
                $nuevoRol = $this->funcionarioData['rol'] ?? null;
                if ($nuevoRol) {
                    $funcionario->user->syncRoles([$nuevoRol]);
                }
            }
        }
        session()->flash('success', 'Cambios guardados correctamente.');
    }

    public function limpiarCampos()
    {
        $this->reset();
    }

    public function render()
    {
        return view('livewire.administrador.editar', [
            'funcionarioData' => $this->funcionarioData,
            'roles' => $this->roles,
        ]);
    }
}
