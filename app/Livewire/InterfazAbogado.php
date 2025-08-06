<?php
namespace App\Livewire;

use App\Models\Solicitud;
use App\Models\RegistroPolicial;
use App\Models\RegistroUnico;
use App\Models\SolicitudAdministrativa;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class InterfazAbogado extends Component
{
    use WithPagination;

    public $busqueda = '';

    public $tipo_funcionario;

    public $selected_id = 0;

    public $rol_usuario = '';


    public $modalOpen = false;
    public $editando = false;
    public $registroSeleccionado = null;
    public $modalTitle = 'Exclusión Registro Policial';

    public $tipoSolicitud = '';


    public function verDetalles($id, $tipo = null, $funcionario = null)
    {
        // Redirige a la ruta de detalles con el id, tipo y funcionario
        $funcionarioParam = $funcionario ?? $this->tipo_funcionario;
        if (empty($funcionarioParam)) {
            $funcionarioParam = 'abogado_funcionario_id';
        }
        return redirect()->route('solicitudes.detalle.full', [
            'id' => $id,
            'tipo' => $tipo ?? $this->tipoSolicitud,
            'funcionario' => $funcionarioParam
        ]);
    }

    public function mount()
    {
        $roles_usuario = auth()->user()->roles->pluck('name')->toArray();
        $this->rol_usuario = $roles_usuario[0] ?? '';

        $this->selected_id = auth()->user()->funcionario->id;

        if (in_array('Superadministrador', $roles_usuario) || in_array('Administrador', $roles_usuario)) {
            $this->tipo_funcionario = null; // Ver todos los registros
        } elseif ($this->rol_usuario == 'Transcriptor') {
            $this->tipo_funcionario = 'registrador_funcionario_id';
        } else {
            $this->tipo_funcionario = 'abogado_funcionario_id';
        }
    }

    #[Computed()]
    public function resultados()
    {
        // Filtra según el tipo seleccionado y el funcionario si es abogado
        if ($this->tipoSolicitud === 'RegistroPolicial') {
            $query = RegistroPolicial::with([
                'solicitud',
                'solicitud.solicitante',
                'solicitud.apoderado',
                'solicitud.abogado',
                'solicitud.registroSolicitud',
            ]);
            if ($this->tipo_funcionario === 'abogado_funcionario_id') {
                $query->whereHas('solicitud', function($q) {
                    $q->where('abogado_funcionario_id', $this->selected_id);
                });
            }
            if (!empty($this->busqueda)) {
                $busqueda = mb_strtolower($this->busqueda);
                $query->where(function($q) use ($busqueda) {
                    $q->whereRaw('LOWER(guia) LIKE ?', ['%'.$busqueda.'%'])
                      ->orWhereHas('solicitud.solicitante', function($q2) use ($busqueda) {
                          $q2->whereRaw('LOWER(primer_nombre) LIKE ?', ['%'.$busqueda.'%'])
                             ->orWhereRaw('LOWER(primer_apellido) LIKE ?', ['%'.$busqueda.'%']);
                      });
                });
            }
            return $query->orderBy('created_at', 'desc')->paginate(8);
        }

        if ($this->tipoSolicitud === 'Transcripción') {
            $query = Solicitud::with([
                'solicitante',
                'apoderado',
                'abogado',
                'registroSolicitud',
            ])->where('tipo_solicitud', 'Transcripción');
            if ($this->tipo_funcionario === 'abogado_funcionario_id') {
                $query->where('abogado_funcionario_id', $this->selected_id);
            }
            // Si es superadministrador o administrador, no filtrar por funcionario
            return $query->orderBy('created_at', 'desc')->paginate(8);
        }

        if ($this->tipoSolicitud === 'Administrativa') {
            $query = SolicitudAdministrativa::with([
                'solicitud',
                'solicitud.solicitante',
                'solicitud.apoderado',
                'solicitud.abogado',
                'solicitud.registroSolicitud',
            ]);
            if ($this->tipo_funcionario === 'abogado_funcionario_id') {
                $query->whereHas('solicitud', function($q) {
                    $q->where('abogado_funcionario_id', $this->selected_id);
                });
            }
            if (!empty($this->busqueda)) {
                $busqueda = mb_strtolower($this->busqueda);
                $query->where(function($q) use ($busqueda) {
                    $q->whereRaw('LOWER(guia) LIKE ?', ['%'.$busqueda.'%'])
                      ->orWhereHas('solicitud.solicitante', function($q2) use ($busqueda) {
                          $q2->whereRaw('LOWER(primer_nombre) LIKE ?', ['%'.$busqueda.'%'])
                             ->orWhereRaw('LOWER(primer_apellido) LIKE ?', ['%'.$busqueda.'%']);
                      });
                });
            }
            return $query->orderBy('created_at', 'desc')->paginate(8);
        }

        if ($this->tipoSolicitud === 'RegistroUnico') {
            $query = RegistroUnico::with([
                // relaciones necesarias
            ]);
            // Si hay relación con solicitud y abogado, agregar filtro aquí
            // Si es superadministrador o administrador, no filtrar por funcionario
            return $query->orderBy('created_at', 'desc')->paginate(8);
        }

        // Si no hay filtro, muestra todos juntos (concatenado y paginado manualmente)
        $registrosPoliciales = RegistroPolicial::with([
            'solicitud',
            'solicitud.solicitante',
            'solicitud.apoderado',
            'solicitud.abogado',
            'solicitud.registroSolicitud',
        ]);
        $solicitudesAdministrativas = SolicitudAdministrativa::with([
            'solicitud',
            'solicitud.solicitante',
            'solicitud.apoderado',
            'solicitud.abogado',
            'solicitud.registroSolicitud',
        ]);
        if ($this->tipo_funcionario === 'abogado_funcionario_id') {
            $registrosPoliciales = $registrosPoliciales->whereHas('solicitud', function($q) {
                $q->where('abogado_funcionario_id', $this->selected_id);
            });
            $solicitudesAdministrativas = $solicitudesAdministrativas->whereHas('solicitud', function($q) {
                $q->where('abogado_funcionario_id', $this->selected_id);
            });
        }
        if (!empty($this->busqueda)) {
            $busqueda = mb_strtolower($this->busqueda);
            $registrosPoliciales = $registrosPoliciales->where(function($q) use ($busqueda) {
                $q->whereRaw('LOWER(guia) LIKE ?', ['%'.$busqueda.'%'])
                  ->orWhereHas('solicitud.solicitante', function($q2) use ($busqueda) {
                      $q2->whereRaw('LOWER(primer_nombre) LIKE ?', ['%'.$busqueda.'%'])
                         ->orWhereRaw('LOWER(primer_apellido) LIKE ?', ['%'.$busqueda.'%']);
                  });
            });
            $solicitudesAdministrativas = $solicitudesAdministrativas->where(function($q) use ($busqueda) {
                $q->whereRaw('LOWER(guia) LIKE ?', ['%'.$busqueda.'%'])
                  ->orWhereHas('solicitud.solicitante', function($q2) use ($busqueda) {
                      $q2->whereRaw('LOWER(primer_nombre) LIKE ?', ['%'.$busqueda.'%'])
                         ->orWhereRaw('LOWER(primer_apellido) LIKE ?', ['%'.$busqueda.'%']);
                  });
            });
        }
        $registrosPoliciales = $registrosPoliciales->get()->map(function($item) {
            $item->tipo = 'RegistroPolicial';
            return $item;
        });
        $solicitudesAdministrativas = $solicitudesAdministrativas->get()->map(function($item) {
            $item->tipo = 'Administrativa';
            return $item;
        });
        $all = $registrosPoliciales->concat($solicitudesAdministrativas);
        $all = $all->sortByDesc(function($item) {
            return $item->created_at;
        });
        // Paginación manual
        $page = request()->get('page', 1);
        $perPage = 8;
        $items = $all->slice(($page - 1) * $perPage, $perPage)->values();
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $all->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        return $paginator;
    }


        public function verHistorial($solicitudId)
    {
        return redirect()->route('solicitud.movimientos', ['solicitud' => $solicitudId]);
    }


    public function cambiarEstadoRegistroPolicial() {
        if (!$this->registroSeleccionado) return;

        $registro = $this->registroSeleccionado;
        $estadoAnterior = $registro->solicitud->estado_solicitud ?? 'Desconocido';
        $estadoNuevo = 'Revisado por abogado';

        // Cambia el estado en la solicitud
        $registro->solicitud->estado_solicitud = $estadoNuevo;
        $registro->solicitud->save();

        // Registra el movimiento
        \App\Models\MovimientosSolicitud::create([
            'solicitud_id' => $registro->solicitud->id,
            'usuario_id' => auth()->id(),
            'estado_anterior' => $estadoAnterior,
            'estado_nuevo' => $estadoNuevo,
            'descripcion' => $registro->observaciones_abogado ?? null,
        ]);

        // Refresca el modal
        $this->abrirModal($registro->id);
        session()->flash('message', 'Estado actualizado y movimiento registrado.');
    }


    public function cambiarEstadoRegistroPolicialDesdeTabla($id)
    {
        $registro = \App\Models\RegistroPolicial::with('solicitud')->find($id);
        if (!$registro || !$registro->solicitud) return;

        $estadoAnterior = $registro->solicitud->estado_solicitud ?? 'Desconocido';
        $estadoNuevo = 'Revisado por abogado';

        $registro->solicitud->estado_solicitud = $estadoNuevo;
        $registro->solicitud->save();

        \App\Models\MovimientosSolicitud::create([
            'solicitud_id' => $registro->solicitud->id,
            'usuario_id' => auth()->id(),
            'estado_anterior' => $estadoAnterior,
            'estado_nuevo' => $estadoNuevo,
            'descripcion' => 'Cambio de estado desde la tabla principal',
        ]);

        // Refresca la tabla
        $this->resetPage();
        $this->dispatch('estadoCambiado');
    }

    public function render()
    {
        return view('livewire.interfaz-abogado', [
            'tipo_funcionario' => $this->tipo_funcionario,
            'resultados' => $this->resultados(),
        ]);
    }
}
