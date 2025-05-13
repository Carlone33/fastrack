<?php

namespace App\Livewire;
use Livewire\WithFileUploads;
use Livewire\Component;

class SolicitudAdministrativa extends Component
{

    use WithFileUploads;


    public $foto;
    public $guia;
    public $cedula;
    public $nacionalidad;
    public $primernombre;
    public $segundonombre;
    public $primerapellido;
    public $segundoapellido;
    public $direccion;
    public $telefono;
    public $telefonolocal;
    public $estado_ciudadano;
    public $direccion_dependencia;
    public $delito;
    public $fecha_inicio;
    public $fecha_final;
    public $nombre_abogado;
    public $apellido_abogado;
    public $cedula_abogado;
    public $telefono_abogado;

    protected function rules()
    {
        return [
            'guia' => 'required|numeric',
            'cedula' => 'required|numeric|digits_between:7,8',
            'nacionalidad' => 'required',
            'primernombre' => 'required',
            'segundonombre' => 'nullable',
            'primerapellido' => 'required',
            'segundoapellido' => 'nullable',
            'direccion' => 'required',
            'telefono' => 'required|digits:10',
            'telefonolocal' => 'nullable|digits:10',
            'estado_ciudadano' => 'required',
            'direccion_dependencia' => 'required',
            'delito' => 'required',
            'fecha_inicio' => 'required|date_format:Y-m-d',
            'fecha_final' => 'required|date_format:Y-m-d|after:fecha_inicio',
            'nombre_abogado' => 'required',
            'apellido_abogado' => 'required',
            'cedula_abogado' => 'required|numeric|digits_between:7,8',
            'telefono_abogado' => 'required|digits:10',
            'foto' => 'nullable|image|max:1024', // Valida que sea una imagen y no mayor a 1 MB
        ];
    }

    protected function messages()
    {
        return [
            'guia.required' => 'El número de guía es obligatorio.',
            'cedula.required' => 'La cédula es obligatoria.',
            'cedula.numeric' => 'La cédula debe ser un número.',
            'guia.numeric' => 'El número de guía debe ser un número.',
            'nacionalidad.required' => 'La nacionalidad es obligatoria.',
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
            'fecha_inicio.after_or_equal' => 'La fecha de inicio no puede ser anterior a hoy.',
            'fecha_final.after' => 'La fecha final debe ser posterior a la fecha de inicio.',
        ];
    }

    public function updated($propertyName)
    {
        // Intercepta cualquier cambio en las propiedades del formulario
        logger("La propiedad {$propertyName} fue actualizada con el valor: " . $this->$propertyName);
    }

    public function updatedCedula($value)
    {
        // Intercepta específicamente cambios en la propiedad 'cedula'
        logger("La cédula fue actualizada con el valor: {$value}");
    }

    public function FormatoyEnviar()
    {
        $this->validate(); // Valida los datos antes de procesarlos

        $this->nacionalidad = strtoupper($this->nacionalidad);
        $this->primernombre = strtoupper($this->primernombre);
        $this->segundonombre = strtoupper($this->segundonombre);
        $this->primerapellido = strtoupper($this->primerapellido);
        $this->segundoapellido = strtoupper($this->segundoapellido);
        $this->direccion = strtoupper($this->direccion);
        $this->estado_ciudadano = strtoupper($this->estado_ciudadano);
        $this->direccion_dependencia = strtoupper($this->direccion_dependencia);
        $this->delito = strtoupper($this->delito);
        $this->nombre_abogado = strtoupper($this->nombre_abogado);
        $this->apellido_abogado = strtoupper($this->apellido_abogado);

        dd($this->guia,
        $this->cedula,
        $this->nacionalidad,
        $this->primernombre,
        $this->segundonombre,
        $this->primerapellido,
        $this->segundoapellido,
        $this->direccion,
        $this->telefono,
        $this->telefonolocal,
        $this->estado_ciudadano,
        $this->direccion_dependencia,
        $this->delito,
        $this->fecha_inicio,
        $this->fecha_final,
        $this->foto
    );
        $path = null;

        if ($this->foto) {
            // Guarda la imagen en el directorio 'fotos' dentro del almacenamiento público
            $path = $this->foto->store('fotos/' . date('Y/m/d'), 'public');
        }

        // Aquí puedes guardar la ruta en la base de datos si es necesario
        // Ejemplo: Registro::create(['foto' => $path]);

        // session()->flash('message', 'Formulario enviado y foto guardada correctamente.');

        dd($this->guia,
            $this->cedula,
            $this->nacionalidad,
            $this->primernombre,
            $this->segundonombre,
            $this->primerapellido,
            $this->segundoapellido,
            $this->direccion,
            $this->telefono,
            $this->telefonolocal,
            $this->estado_ciudadano,
            $this->direccion_dependencia,
            $this->delito,
            $this->fecha_inicio,
            $this->fecha_final,
            $this->foto
        );

        $this->reset([
            'guia',
            'cedula',
            'nacionalidad',
            'primernombre',
            'segundonombre',
            'primerapellido',
            'segundoapellido',
            'direccion',
            'telefono',
            'telefonolocal',
            'estado_ciudadano',
            'direccion_dependencia',
            'delito',
            'fecha_inicio',
            'fecha_final',
            'nombre_abogado',
            'apellido_abogado',
            'cedula_abogado',
            'telefono_abogado',
            'foto'
        ]);

        $this->resetValidation();
    }
    public function render()
    {
        return view('livewire.solicitud-administrativa');
    }
}
