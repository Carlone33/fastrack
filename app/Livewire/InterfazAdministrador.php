<?php

namespace App\Livewire;

use Livewire\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Funcionario;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\Persona;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\Paginator;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

class InterfazAdministrador extends Component
{

    use WithPagination;


    public $search = '';
    public $selected_id = 0;


    public $ConsultarModal;
    public $EditarModal;
    public $CrearModal;
    public $abrirEnModoEdicion = false;

    protected $listeners = [
        'cerrarModal' => 'cerrarModal',
        'abrirModal' => 'abrirModal',
        'abrirModalconEdicion' => 'abrirModalconEdicion',
        'activarEdicion' => 'activarEdicion',
    ];


    public function cerrarModal()
    {
        $this->funcionarioSeleccionadoId = null;
    }
    public function abrirModal($id)
    {
        return redirect()->route('funcionarios.consultar', ['id' => $id, 'modo' => 'consultar']);
    }
    public function abrirModalconEdicion($id)
    {
        // Redirige a la ruta web de edición para cargar el controlador y la vista
        return redirect()->route('funcionarios.editar', ['id' => $id]);
    }

    public function abrirModalYEnviarparaCrear(){
        // Redirige a la vista de crear funcionario sin id
        return redirect()->route('funcionarios.crear');
    }


    public function updatedFuncionarioSeleccionadoId($id)
    {
        if ($id) {
            $funcionario = Funcionario::join('persona', 'funcionario.persona_id', '=', 'persona.id')
                ->join('users', 'funcionario.id', '=', 'users.funcionario_id')
                ->select('funcionario.*', 'persona.*', 'users.*')
                ->find($id);
            if ($funcionario) {
                $this->dispatch('editarFuncionario', $funcionario->toArray());
            }
        }
    }

    public function activarEdicion($id)
    {
        $this->funcionarioSeleccionadoId = $id;
        $this->dispatch('abrirModalconEdicion', $id);
    }



    public function EnviarparaInhabilitar($id)
    {
        User::where('funcionario_id', $id)->update(['habilitado' => false]);;
    }
    public function EnviarparaHabilitar($id)
    {
        User::where('funcionario_id', $id)->update(['habilitado' => true]);
    }




    public $funcionarioSeleccionadoId = null;

    public function abrirModalInline($id)
    {

        // Si ya está abierto para este funcionario, ciérralo
        if ($this->funcionarioSeleccionadoId === $id) {
            $this->funcionarioSeleccionadoId = null;
        } else {
            $this->abrirEnModoEdicion = false;
            $this->funcionarioSeleccionadoId = $id;
        }
    }



    // Agrega este método auxiliar para buscar el funcionario en la colección paginada





    public function abrirModalInlineOrEditar($id)
    {
        if ($this->funcionarioSeleccionadoId === $id && $this->abrirEnModoEdicion) {
            // Si el modal está abierto y en modo edición, ciérralo
            $this->funcionarioSeleccionadoId = null;
            $this->abrirEnModoEdicion = false;
        } else {
            // Si no, ábrelo en modo edición
            $this->abrirEnModoEdicion = true;
            $this->funcionarioSeleccionadoId = $id;
            $this->dispatch('abrirModalconEdicion', $id);
        }
    }



    #[Computed()]
    public function funcionarios()
    {
        return Funcionario::join('persona', 'funcionario.persona_id', '=', 'persona.id')
            ->join('users', 'funcionario.id', '=', 'users.funcionario_id')
            ->select('funcionario.*', 'persona.*', 'users.*')
            ->when($this->search, function ($query) {
                $query->where('funcionario.credencial', 'like', '%' . $this->search . '%')
                    ->orWhere('persona.primer_nombre', 'like', '%' . $this->search . '%')
                    ->orWhere('persona.primer_apellido', 'like', '%' . $this->search . '%')
                    ->orWhere('persona.cedula', 'like', '%' . $this->search . '%');
            })
            ->paginate(8);
    }

    public function render()
    {
        return view('livewire.interfaz-administrador');
    }
}
