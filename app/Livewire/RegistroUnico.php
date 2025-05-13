<?php

namespace App\Livewire;


use Livewire\WithFileUploads;
use Livewire\Component;
use App\Models\Nomenclador;
use App\Models\Persona;
use App\Models\Telefono;
use App\Models\Direccion;
use App\Models\Solicitud;
use App\Models\UnidadAdministrativa;
use App\Services\GuideNumberService;
use App\Models\Imagen;
use Illuminate\Support\Facades\Storage;
use App\Models\RegistroSolicitud;



class RegistroUnico extends Component
{
    use WithFileUploads;

    public $currentStep = 1;
    public $totalSteps = 3;
    public function nextStep(){
        $this->validateCurrentStep();
        $this->currentStep++;
    }
    public function nextnextStep(){
        $this->validateCurrentStep();
        $this->currentStep += 2;
    }

    public function prevStep(){
        $this->currentStep--;
    }
    public function prevprevStep(){
        $this->currentStep -= 2;
    }
    protected $messages = [
        'cedula.required' => 'La cédula es obligatoria.',
        'cedula.numeric' => 'La cédula debe ser un número.',
        'cedula.digits_between' => 'La cédula debe tener entre 7 y 8 dígitos.',
        'telefono.regex' => 'El teléfono debe tener el formato 0XXX-XXXXXXX.',
        'telefono.required' => 'El teléfono es obligatorio.',
        'telefono.digits_between' => 'El teléfono debe tener entre 10 y 11 dígitos.',
        'foto.image' => 'La foto debe ser una imagen.',
        'foto.max' => 'La foto no puede exceder 1 MB.',
    ];
    protected function validateCurrentStep()
    {
        if ($this->currentStep === 1) {
            $this->validate([

                //Datos del solicitante
                'nacionalidad' => 'required|in:V,E',
                'foto' => 'required|image|max:1024',
                'cedula' => 'required|numeric|digits_between:7,8|unique:persona,cedula',
                'primernombre' => 'required|string|max:50',
                'segundonombre' => 'required|string|max:50',
                'primerapellido' => 'required|string|max:50',
                'segundoapellido' => 'required|string|max:50',
                'sexo' => 'required|in:M,F',
                'telefono' => 'required|regex:/^\d{4}-\d{7}$/',
                'telefonolocal' => 'nullable|regex:/^\d{4}-\d{7,8}$/',
                'email' => 'required|email|max:100',

                //Datos de la ubicacion domicilaria del solicitante
                'ubicaciones.solicitante.calle' => 'required|string|max:200',
                'ubicaciones.solicitante.casa_edificio' => 'required|string|max:100',
                'ubicaciones.solicitante.piso' => 'nullable|string|max:10',
                'ubicaciones.solicitante.apartamento' => 'nullable|string|max:10',

                //Datos de la solicitud
                'estado_ciudadano' => 'required|string|max:100',
                'unidad_administrativa' => 'required|exists:unidad_administrativa,id',
                'delito' => 'required|string|max:255',
                'fecha_registrosiipol' => 'required|date|before_or_equal:today',
                'fecha_solicitud' => 'required|date|before_or_equal:today',
                'hora_solicitud' => 'required|date_format:H:i',
                ]);

        } elseif ($this->currentStep === 2) {
            $this->validate([
                'street' => 'required|string',
                'city' => 'required|string',
                'country' => 'required|string',
            ]);
        }
        // No validamos el último paso antes de enviar
    }


    public $personaId = [];
    public $showAssigned = false;

    // -------------------------
    // DATOS PERSONALES Y SOLICITUD (wire:model directos)
    // -------------------------
    public $cedula;
    public $nacionalidad;
    public $primernombre;
    public $segundonombre;
    public $primerapellido;
    public $segundoapellido;
    public $sexo;
    public $foto;
    public $direccion;
    public $telefono;
    public $telefonolocal;
    public $estado_ciudadano;
    public $direccion_dependencia;
    public $delito;
    public $fecha_inicio;
    public $fecha_final;
    public $fecha_solicitud;
    public $hora_solicitud;
    public $unidad_administrativa; // wire:model="unidad_administrativa"
    public $fecha_registrosiipol;
    // -------------------------
    // APODERADO (wire:model directos)
    // -------------------------
    public $nacionalidad_apoderado; // wire:model="nacionalidad_apoderado"
    public $cedula_apoderado;
    public $primernombre_apoderado;
    public $segundonombre_apoderado;
    public $primerapellido_apoderado;
    public $segundoapellido_apoderado;
    public $telefono_apoderado;
    public $telefonolocal_apoderado;
    public $sexo_apoderado;
    public $foto_apoderado;
    // -------------------------
    // ABOGADO (wire:model directos)
    // -------------------------
    public $nacionalidad_abogado; // wire:model="nacionalidad_abogado"
    public $cedula_abogado;
    public $primernombre_abogado;
    public $segundonombre_abogado;
    public $primerapellido_abogado;
    public $segundoapellido_abogado;
    public $telefono_abogado;
    public $telefonolocal_abogado;
    public $nombre_abogado; // wire:model="nombre_abogado"
    public $apellido_abogado; // wire:model="apellido_abogado"
    public $sexo_abogado;
    // -------------------------
    // ARREGLOS DE DIRECCIÓN (wire:model="ubicaciones.*.*")
    // -------------------------
    public $ubicaciones = [
        'solicitante' => [
            'estado' => null,
            'municipio' => null,
            'parroquia' => null,
            'calle' => null,
            'casa_edificio' => null,
            'piso' => null,
            'apartamento' => null,
            'estados' => [],
            'municipios' => [],
            'parroquias' => [],
        ],
        'apoderado' => [
            'estado' => null,
            'municipio' => null,
            'parroquia' => null,
            'calle' => null,
            'casa_edificio' => null,
            'piso' => null,
            'apartamento' => null,
            'estados' => [],
            'municipios' => [],
            'parroquias' => [],
        ],
        'abogado' => [
            'estado' => null,
            'municipio' => null,
            'parroquia' => null,
            'calle' => null,
            'casa_edificio' => null,
            'piso' => null,
            'apartamento' => null,
            'estados' => [],
            'municipios' => [],
            'parroquias' => [],
        ],
    ];

    // -------------------------
    // OTROS (colecciones para selects)
    // -------------------------
    public $unidadesAdministrativas;


    // DATOS PERSONALES Y SOLICITUD (wire:model directos)
    public $email; // wire:model="email"

    // APODERADO (wire:model directos)
    public $email_apoderado; // wire:model="email_apoderado"

    // ABOGADO (wire:model directos)
    public $email_abogado; // wire:model="email_abogado"

    public function mount()
    {
        $estados = Nomenclador::where('tipo', 9)->get();
        foreach (['solicitante', 'apoderado', 'abogado'] as $tipo) {
            $this->ubicaciones[$tipo]['estados'] = $estados;
            $this->ubicaciones[$tipo]['municipios'] = collect();
            $this->ubicaciones[$tipo]['parroquias'] = collect();
        }
    }

    // Método genérico para actualizar municipios y parroquias
    public function updated($property, $value)
    {
        foreach (['solicitante', 'apoderado', 'abogado'] as $tipo) {
            if ($property === "ubicaciones.$tipo.estado") {
                $this->ubicaciones[$tipo]['municipios'] = Nomenclador::where('padre', $value)->get();
                $this->ubicaciones[$tipo]['municipio'] = null;
                $this->ubicaciones[$tipo]['parroquias'] = collect();
                $this->ubicaciones[$tipo]['parroquia'] = null;
            }
            if ($property === "ubicaciones.$tipo.municipio") {
                $this->ubicaciones[$tipo]['parroquias'] = Nomenclador::where('padre', $value)->get();
                $this->ubicaciones[$tipo]['parroquia'] = null;
            }
        }
    }

    public function toggleAssigned()
    {
        $this->showAssigned = !$this->showAssigned;
    }


    public function FormatoyEnviar()                                                          //AQUI SE HACE EL SUBMIT E INSERCION A BASE DE DATOS
    {
        // -------------------------
        // DATOS PERSONALES Y SOLICITUD (wire:model directos)
        // -------------------------
        $guia = new GuideNumberService();
        //ARRAY CON TODOS LOS DATOS DE LAS PERSONAS DE LA SOLICITUD
        $paratablaPersona = [
            'solicitante' => [
                'cedula' => $this->cedula,
                'nacionalidad' => $this->nacionalidad,
                'primernombre' => mb_strtoupper($this->primernombre, 'UTF-8'),
                'segundonombre' => mb_strtoupper($this->segundonombre, 'UTF-8'),
                'primerapellido' => mb_strtoupper($this->primerapellido, 'UTF-8'),
                'segundoapellido' => mb_strtoupper($this->segundoapellido, 'UTF-8'),
                'sexo' => $this->sexo,
                'email' => $this->email,
                'telefono1' => $this->telefono,
                'telefonolocal' => $this->telefonolocal,
            ],
            'apoderado' => [
                'cedula' => $this->cedula_apoderado,
                'nacionalidad' => $this->nacionalidad_apoderado,
                'primernombre' => mb_strtoupper($this->primernombre_apoderado, 'UTF-8'),
                'segundonombre' => mb_strtoupper($this->segundonombre_apoderado, 'UTF-8'),
                'primerapellido' => mb_strtoupper($this->primerapellido_apoderado, 'UTF-8'),
                'segundoapellido' => mb_strtoupper($this->segundoapellido_apoderado, 'UTF-8'),
                'sexo' => $this->sexo_apoderado,
                'email' => $this->email_apoderado,
                'telefono' => $this->telefono_apoderado,
                'telefonolocal' => $this->telefonolocal_apoderado,
            ],
            'abogado' => [
                'cedula' => $this->cedula_abogado,
                'nacionalidad' => $this->nacionalidad_abogado,
                'primernombre' => mb_strtoupper($this->primernombre_abogado, 'UTF-8'),
                'segundonombre' => mb_strtoupper($this->segundonombre_abogado, 'UTF-8'),
                'primerapellido' => mb_strtoupper($this->primerapellido_abogado, 'UTF-8'),
                'segundoapellido' => mb_strtoupper($this->segundoapellido_abogado, 'UTF-8'),
                'sexo' => $this->sexo_abogado,
                'email' => $this->email_abogado,
                'telefono' => $this->telefono_abogado,
                'telefonolocal' => $this->telefonolocal_abogado,
            ],
        ];

        $personaIds = []; // Array para guardar los IDs

        //INSERCION DE PERSONA A LA BASE DE DATOS (TABLA PERSONA)
        foreach ($paratablaPersona as $key => $persona) {
            if (isset($persona['cedula'])) {
                // Crear la persona y guardar su ID
                $personaIds[$key] = Persona::create([
                    'cedula' => $persona['cedula'],
                    'nacionalidad' => $persona['nacionalidad'],
                    'primer_nombre' => $persona['primernombre'],
                    'segundo_nombre' => $persona['segundonombre'],
                    'primer_apellido' => $persona['primerapellido'],
                    'segundo_apellido' => $persona['segundoapellido'],
                    'sexo' => $persona['sexo'],
                    'correo' => $persona['email'],
                ])->id;
            }
        }
        //ARRAY CON TODOS LOS TELEFONOS
        $paratablaTelefono = [
            'solicitante' => [
                'telefono' => $this->telefono,
                'telefonolocal' => $this->telefonolocal,
            ],
            'apoderado' => [
                'telefono' => $this->telefono_apoderado,
                'telefonolocal' => $this->telefonolocal_apoderado,
            ],
            'abogado' => [
                'telefono' => $this->telefono_abogado,
                'telefonolocal' => $this->telefonolocal_abogado,
            ],
        ];


        //INSERCION DE TELEFONOS A LA BASE DE DATOS (TABLA TELEFONO)
        $telefonoIds = []; // Array para guardar los IDs
        foreach ($paratablaTelefono as $key => $telefono) {
            if (isset($telefono['telefono'])) {
                $telefonoIds[$key]['telefono'] = Telefono::create([
                    'numero' => $telefono['telefono'],
                    'tipo' => 'movil',
                ]);
            }
            if (isset($telefono['telefonolocal'])) {
                $telefonoIds[$key]['telefonolocal'] = Telefono::create([
                    'numero' => $telefono['telefonolocal'],
                    'tipo' => 'local',
                ]);
            }
        }



        //ASIGNACION DE LOS TELEFONOS A LAS PERSONAS (CON UNA TABLA PUENTE persona_telefono)
        foreach ($paratablaPersona as $key => $persona) {
            if (isset($personaIds[$key])) {
                $personaId = $personaIds[$key];

                // Verificar y asociar teléfono móvil
                if (!empty($telefonoIds[$key]['telefono'])) {
                    Persona::find($personaId)->telefonos()->attach($telefonoIds[$key]['telefono']->id);
                }

                // Verificar y asociar teléfono fijo
                if (!empty($telefonoIds[$key]['telefonolocal'])) {
                    Persona::find($personaId)->telefonos()->attach($telefonoIds[$key]['telefonolocal']->id);
                }
            }
        }

        $paratablaDireccion = [
            'solicitante' => [
                'estado' => Nomenclador::Find($this->ubicaciones['solicitante']['estado'])?->toArray() ?? null,
                'municipio' => Nomenclador::Find($this->ubicaciones['solicitante']['municipio'])?->toArray() ?? null,
                'parroquia' => Nomenclador::Find($this->ubicaciones['solicitante']['parroquia'])?->toArray() ?? null,
                'calle' => mb_strtoupper($this->ubicaciones['solicitante']['calle'], 'UTF-8'),
                'casa_edificio' => mb_strtoupper($this->ubicaciones['solicitante']['casa_edificio'], 'UTF-8'),
                'piso' => mb_strtoupper($this->ubicaciones['solicitante']['piso'], 'UTF-8'),
                'apartamento' => mb_strtoupper($this->ubicaciones['solicitante']['apartamento'], 'UTF-8'),
            ],
            'apoderado' => [
                'estado' => Nomenclador::Find($this->ubicaciones['apoderado']['estado'])?->toArray() ?? null,
                'municipio' => Nomenclador::Find($this->ubicaciones['apoderado']['municipio'])?->toArray() ?? null,
                'parroquia' => Nomenclador::Find($this->ubicaciones['apoderado']['parroquia'])?->toArray() ?? null,
                'calle' => mb_strtoupper($this->ubicaciones['apoderado']['calle'], 'UTF-8'),
                'casa_edificio' => mb_strtoupper($this->ubicaciones['apoderado']['casa_edificio'], 'UTF-8'),
                'piso' => mb_strtoupper($this->ubicaciones['apoderado']['piso'], 'UTF-8'),
                'apartamento' => mb_strtoupper($this->ubicaciones['apoderado']['apartamento'], 'UTF-8'),
            ],
            'abogado' => [
                'estado' => Nomenclador::Find($this->ubicaciones['abogado']['estado'])?->toArray() ?? null,
                'municipio' => Nomenclador::Find($this->ubicaciones['abogado']['municipio'])?->toArray() ?? null,
                'parroquia' => Nomenclador::Find($this->ubicaciones['abogado']['parroquia'])?->toArray() ?? null,
                'calle' => mb_strtoupper($this->ubicaciones['abogado']['calle'], 'UTF-8'),
                'casa_edificio' => mb_strtoupper($this->ubicaciones['abogado']['casa_edificio'], 'UTF-8'),
                'piso' => mb_strtoupper($this->ubicaciones['abogado']['piso'], 'UTF-8'),
                'apartamento' => mb_strtoupper($this->ubicaciones['abogado']['apartamento'], 'UTF-8'),
            ],
        ];



        $direccionIds = []; // Array para guardar los IDs
        /* dd($paratablaDireccion); */

        //INSERCION DE DIRECCION A LA BASE DE DATOS (TABLA DIRECCION)

        foreach ($paratablaDireccion as $key => $direccion) {
            if (isset($direccion['estado']) && isset($direccion['estado']["nombre"])) {

                $direccionIds[$key] = Direccion::create([
                    'estado' => $direccion['estado']["nombre"],
                    'municipio' => $direccion['municipio']["nombre"],
                    'parroquia' => $direccion['parroquia']["nombre"],
                    'calle' => $direccion['calle'],
                    'casa-edificio' => $direccion['casa_edificio'],
                    'piso' => $direccion['piso'],
                    'apartamento' => $direccion['apartamento'],
                ]);
            }
        }
        // dd($i);


        foreach ($paratablaPersona as $key => $persona) {
            if (isset($personaIds[$key]) && isset($direccionIds[$key])) {
                $personaId = $personaIds[$key];
                // Verificar y asociar direccion
                if (!empty($direccionIds[$key])) {
                    Persona::find($personaId)->direcciones()->attach($direccionIds[$key]);
                }
            }
        }


        $foto = $this->foto;
        $ruta = $foto->store('fotos', 'public');
        $imagen = new Imagen();
        $imagen->tipo ="persona-solicitante";
        $imagen->url = Storage::url($ruta);
        $imagen->fecha_registro = now()->toDateString();
        $imagen->save();
        $imagenId = $imagen->id;

        $foto_apoderado = $this->foto_apoderado;
        $ruta_apoderado = $foto_apoderado->store('fotos', 'public');
        $imagen_apoderado = new Imagen();
        $imagen_apoderado->tipo ="persona-apoderado";
        $imagen_apoderado->url = Storage::url($ruta_apoderado);
        $imagen_apoderado->fecha_registro = now()->toDateString();
        $imagen_apoderado->save();
        $imagenId_apoderado = $imagen_apoderado->id;

        $estado_solicitante = $this->estado_ciudadano;
        $unidad_administrativa = $this->unidad_administrativa;
        $delito = $this->delito;
        $fecha_solicitud = $this->fecha_solicitud;
        $hora_solicitud = $this->hora_solicitud;
        $fecha_registrosiipol = $this->fecha_registrosiipol;

        //INSERCION DE SOLICITUD A LA BASE DE DATOS (TABLA SOLICITUD)
        $solicitud = Solicitud::create([
            'tipo_solicitud' => 'Registro Único',
            'fecha_registro' => now()->toDateString(),
            'registrador_funcionario_id' => auth()->user()->funcionario->id,
            'solicitante_persona_id' => $personaIds['solicitante'],
            'apoderado_persona_id' => @$personaIds['apoderado'],
            'abogado_funcionario_id' => $personaIds['abogado'],
            'fecha_solicitud' => $fecha_solicitud,
            'hora_solicitud' => $hora_solicitud,
        ])->id;

        //INSERCION DEL REGISTRO DE SOLICITUD A LA BASE DE DATOS (TABLA REGISTRO_SOLICITUD)
        RegistroSolicitud::create([
            'solicitud_id' => $solicitud,
            'dependencia_id' => $unidad_administrativa,
            'delito' => $delito,
            'estado_persona' => $estado_solicitante,
            'fecha_apertura_siipol' => $fecha_registrosiipol,
        ]);

        //ASIGNACION DE LA IMAGEN A LA SOLICITUD (CON UNA TABLA PUENTE imagen_solicitud)
            $solicitud = Solicitud::find($solicitud)->imagenes()->attach($imagenId);



    }

    public function render()
    {

        $this->unidadesAdministrativas = UnidadAdministrativa::all();
        return view('livewire.registro-unico', [
            'ubicaciones' => $this->ubicaciones,
            'showAssigned' => $this->showAssigned,
            'unidadesAdministrativas' => $this->unidadesAdministrativas,
        ]);
    }
}
