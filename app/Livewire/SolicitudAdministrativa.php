<?php

namespace App\Livewire;
use App\Models\Funcionario;
use App\Models\Nomenclador;
use App\Models\Persona;
use App\Models\Solicitud;
use App\Models\SolicitudAdministrativa as ModelsSolicitudAdministrativa;
use App\Models\RegistroSolicitud;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\GuideNumberService;
use App\Models\Telefono;
use App\Models\Direccion;
use App\Models\Imagen;
use Illuminate\Validation\Rule;
use App\Traits\StorageTrait;
use Illuminate\Support\Facades\Storage;

class SolicitudAdministrativa extends Component
{

    use WithFileUploads;

    public $search = '';
    public $abogado_id;
    public $searchAbogado = '';
    public $abogados = [];

    // Propiedades para los campos del formulario
    public $guia, $foto, $foto_cedula_solicitante, $foto_cedula_apoderado, $foto_poder, $delito;
    public $nacionalidad, $cedula, $primernombre, $segundonombre, $primerapellido, $segundoapellido, $sexo, $email, $telefono, $telefonolocal; //solicitante
    public $nacionalidad_apoderado, $cedula_apoderado, $primernombre_apoderado, $segundonombre_apoderado, $primerapellido_apoderado, $segundoapellido_apoderado, $sexo_apoderado, $email_apoderado, $telefono_apoderado, $telefonolocal_apoderado; //apoderado

    public $showAssigned;

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
        ]
    ];

   public $currentStep = 1;

    public $totalSteps = 5;


    public function nextStep()
    {
        if ($this->currentStep == 1 && ($this->showAssigned == 1 || $this->showAssigned == 2)) {
            $this->validateCurrentStep();
            $this->currentStep++;
        } elseif ($this->currentStep == 2 && $this->showAssigned == 2) {
            $this->validateCurrentStep();
            $this->currentStep += 2;
        } elseif ($this->currentStep == 2 && $this->showAssigned == 1) {
            $this->validateCurrentStep();
            $this->currentStep++;
        } elseif ($this->currentStep == 3 || $this->currentStep == 4) {
            $this->validateCurrentStep();
            $this->currentStep++;
        } else {
            $this->currentStep = $this->currentStep;
        }
    }
    public function prevStep()
    {

        if ($this->currentStep == 2) {

            $this->currentStep--;
        } elseif ($this->currentStep == 3) {

            $this->currentStep--;
        } elseif ($this->currentStep == 4 && $this->showAssigned == 1) {
            $this->currentStep--;
        } elseif ($this->currentStep == 4 && $this->showAssigned == 2) {
            $this->currentStep -= 2;
        } elseif ($this->currentStep == 5) {

            $this->currentStep--;
        }
    }

     public function mount()
    {
        // Solo generar la guía al montar el componente (no en cada render)
        $this->guia = (new GuideNumberService())->generate(
            'solicitud_administrativa',
            'ADM',
            4,
            null,
            true
        );
        $estados = Nomenclador::where('tipo', 9)->get();
        foreach (['solicitante', 'apoderado'] as $tipo) {
            $this->ubicaciones[$tipo]['estados'] = $estados;
            $this->ubicaciones[$tipo]['municipios'] = collect();
            $this->ubicaciones[$tipo]['parroquias'] = collect();
        }

        $abogados = Funcionario::with(['persona', 'user'])
            ->whereHas('persona', function ($query) {
            $query->where('primer_nombre', 'like', '%' . $this->searchAbogado . '%')
                ->orWhere('primer_apellido', 'like', '%' . $this->searchAbogado . '%')
                ->orWhere('cedula', 'like', '%' . $this->searchAbogado . '%');
            })
            ->get();

            foreach ($abogados as $abogado) {
                $this->abogados[] = [
                    'id' => $abogado->id,
                    'nombre' => $abogado->persona->primer_nombre . ' ' . $abogado->persona->primer_apellido,
                    'cedula' => $abogado->persona->cedula,
                ];
            }
    }


    public function updated($property, $value)
    {
        foreach (['solicitante', 'apoderado'] as $tipo) {
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



     public function submit()
    {
        $guideService = new GuideNumberService();

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
            ]
        ];
        // dd($paratablaPersona, $this->abogado_id);

        $paratablaTelefono = [
            'solicitante' => [
                'telefono' => $this->telefono,
                'telefonolocal' => $this->telefonolocal,
            ],
            'apoderado' => [
                'telefono' => $this->telefono_apoderado,
                'telefonolocal' => $this->telefonolocal_apoderado,
            ]
        ];

        $abogado = $this->abogado_id;

        $paratablaUbicacion = [
            'solicitante' => [
                'estado' => $this->ubicaciones['solicitante']['estado'],
                'municipio' => $this->ubicaciones['solicitante']['municipio'],
                'parroquia' => $this->ubicaciones['solicitante']['parroquia'],
                'calle' => mb_strtoupper($this->ubicaciones['solicitante']['calle'], 'UTF-8'),
                'casa_edificio' => mb_strtoupper($this->ubicaciones['solicitante']['casa_edificio'], 'UTF-8'),
                'piso' => $this->ubicaciones['solicitante']['piso'],
                'apartamento' => $this->ubicaciones['solicitante']['apartamento'],
            ],
            'apoderado' => [
                'estado' => $this->ubicaciones['apoderado']['estado'],
                'municipio' => $this->ubicaciones['apoderado']['municipio'],
                'parroquia' => $this->ubicaciones['apoderado']['parroquia'],
                'calle' => mb_strtoupper($this->ubicaciones['apoderado']['calle'], 'UTF-8'),
                'casa_edificio' => mb_strtoupper($this->ubicaciones['apoderado']['casa_edificio'], 'UTF-8'),
                'piso' => $this->ubicaciones['apoderado']['piso'],
                'apartamento' => $this->ubicaciones['apoderado']['apartamento'],
            ]
        ];
        foreach ($paratablaPersona as $key => $persona) {
            if (isset($persona['cedula'])) {
                $personaExistente = Persona::where('cedula', $persona['cedula'])->first();
                if ($personaExistente) {
                    $personaIds[$key] = $personaExistente->id;
                } else {
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
        }

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
        ];


        $direccionIds = []; // Array para guardar los IDs

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

        foreach ($paratablaPersona as $key => $persona) {
            if (isset($personaIds[$key]) && isset($direccionIds[$key])) {
                $personaId = $personaIds[$key];
                if (!empty($direccionIds[$key])) {
                    Persona::find($personaId)->direcciones()->attach($direccionIds[$key]);
                }
            }
        }

        // Crear la solicitud primero
        $solicitud = Solicitud::create([
            'tipo_solicitud' => 'SOLICITUD ADMINISTRA',
            'fecha_registro' => now(),
            'estado_solicitud' => 'En Proceso',
            'registrador_funcionario_id' => auth()->user()->funcionario->id,
            'solicitante_persona_id' => $personaIds['solicitante'],
            'apoderado_persona_id' => $personaIds['apoderado'] ?? null,
            'abogado_funcionario_id' => $abogado,
            'fecha_solicitud' => now()->toDateString(),
            'hora_solicitud' => now()->toTimeString(),
        ]);

        // Ahora crear el registro administrativo con el id de la solicitud
        $registroadministrativoId = ModelsSolicitudAdministrativa::create([
            'solicitud_id' => $solicitud->id,
            'guia' => $this->guia = $guideService->generate(
                'registro_policial',
                'ADM',
                4,
                null,
                false // Modo definitivo: actualiza el número en la DB
            ),
            'delito' => mb_strtoupper($this->delito, 'UTF-8'),
        ])->id;

        $registrosolicitudId = RegistroSolicitud::create([
            'solicitud_id' => $solicitud->id,
            'delito' => mb_strtoupper($this->delito, 'UTF-8'),
        ])->id;

        $dirFoto = 'solicitudes/soladm/' . $this->guia . '/';

        if ($this->makeDirectory($dirFoto)) {
            $this->updateRecursivePermissions('soladm', '755');
        }


        $imagenes_recopiladas = [
            'foto_solicitante' => [
                'foto' => $this->foto,
                'ruta' => $this->foto ? $this->foto->store('registropolicial', 'public') : null,
            ],
            'cedula_solicitante' => [
                'foto' => $this->foto_cedula_solicitante,
                'ruta' => $this->foto_cedula_solicitante ? $this->foto_cedula_solicitante->store('registropolicial', 'public') : null,
            ],
            'cedula_apoderado' => [
                'foto' => $this->foto_cedula_apoderado,
                'ruta' => $this->foto_cedula_apoderado ? $this->foto_cedula_apoderado->store('registropolicial', 'public') : null,
            ],
            'poder' => [
                'foto' => $this->foto_poder,
                'ruta' => $this->foto_poder ? $this->foto_poder->store('registropolicial', 'public') : null,
            ],
        ];


        foreach ($imagenes_recopiladas as $key => $imagen) {
            if ($imagen['ruta']) {
                $img = new Imagen();
                $img->tipo = $key;
                $img->url = $imagen['ruta']; // Solo la ruta relativa, ej: registropolicial/archivo.jpg
                $img->fecha_registro = now()->toDateString();
                $img->save();
                $imagenId = $img->id;

                // Guardar la relación entre la imagen y la solicitud (muchos a muchos)
                $solicitud->imagenes()->attach($imagenId);

                // Asociar la foto de la cédula del solicitante
                if ($key === 'cedula_solicitante' && isset($personaIds['solicitante'])) {
                    $solicitante = Persona::find($personaIds['solicitante']);
                    if ($solicitante) {
                        $solicitante->imagen_id = $imagenId;
                        $solicitante->save();
                    }
                }
                // Asociar la foto de la cédula del apoderado
                if ($key === 'cedula_apoderado' && isset($personaIds['apoderado'])) {
                    $apoderado = Persona::find($personaIds['apoderado']);
                    if ($apoderado) {
                        $apoderado->imagen_id = $imagenId;
                        $apoderado->save();
                    }
                }
            }
        }

        // Relaciones correctas (NO USAR attach en belongsTo)
        $registroAdministrativo = ModelsSolicitudAdministrativa::find($registroadministrativoId);
        if ($registroAdministrativo) {
            $registroAdministrativo->solicitud_id = $solicitud->id;
            $registroAdministrativo->save();
        }

        // Relación de solicitud con abogado (si tienes tabla pivote, usa attach, si es belongsTo, solo guarda el id)
        $solicitud->abogado_funcionario_id = $abogado;
        $solicitud->save();

        // Relación de solicitud con solicitante y apoderado (si es belongsTo, solo guarda el id)
        $solicitud->solicitante_persona_id = $personaIds['solicitante'];
        if (isset($personaIds['apoderado'])) {
            $solicitud->apoderado_persona_id = $personaIds['apoderado'];
        }
        $solicitud->save();

        // Generar la nueva guía solo para previsualización (no actualiza last_number)
        $this->guia = (new GuideNumberService())->generate(
            'solicitud_administrativa',
            'ADM',
            4,
            null,
            true // Solo previsualización para el siguiente registro
        );

        return redirect('/menu')->with('success', 'Registro policial creado exitosamente.');
    }

      public function validateCurrentStep()
    {

        if ($this->currentStep == 2) {
            $this->validate([
                'nacionalidad' => 'required|in:V,E',
                'cedula' => 'required|numeric|digits_between:7,8',
                'primernombre' => 'required|string|max:50',
                'segundonombre' => 'nullable|string|max:50',
                'primerapellido' => 'required|string|max:50',
                'segundoapellido' => 'nullable|string|max:50',
                'sexo' => 'required|in:M,F',
                'telefono' => 'required|regex:/^\d{4}-\d{7}$/',
                'telefonolocal' => 'nullable|regex:/^\d{4}-\d{7,8}$/',
                'email' => 'required|email|max:100',
                'foto' => 'nullable|image|max:1024',
                'ubicaciones.solicitante.estado' => 'required|integer',
                'ubicaciones.solicitante.municipio' => 'required|integer',
                'ubicaciones.solicitante.parroquia' => 'required|integer',
                'ubicaciones.solicitante.calle' => 'required|string|max:200',
                'ubicaciones.solicitante.casa_edificio' => 'required|string|max:100',
                'ubicaciones.solicitante.piso' => 'nullable|string|max:10',
                'ubicaciones.solicitante.apartamento' => 'nullable|string|max:10',
            ]);
            if ($this->showAssigned == 2) {
                $this->validate([
                    'foto' => 'required|image|max:1024',
                ]);
            }
        }

        if ($this->currentStep == 3) {
            $this->validate([
                // Validaciones del apoderado
                'nacionalidad_apoderado' => 'required|in:V,E',
                'cedula_apoderado' => 'required|numeric|digits_between:7,8|unique:persona,cedula',
                'primernombre_apoderado' => 'required|string|max:50',
                'segundonombre_apoderado' => 'required|string|max:50',
                'primerapellido_apoderado' => 'required|string|max:50',
                'segundoapellido_apoderado' => 'required|string|max:50',
                'sexo_apoderado' => 'required|in:M,F',
                'telefono_apoderado' => 'required|regex:/^\d{4}-\d{7}$/',
                'telefonolocal_apoderado' => 'required|regex:/^\d{4}-\d{7,8}$/',
                'email_apoderado' => 'required|email|max:100',
                // Dirección apoderado
                'ubicaciones.apoderado.estado' => 'required|integer|exists:nomencladors,id',
                'ubicaciones.apoderado.municipio' => 'required|integer|exists:nomencladors,id',
                'ubicaciones.apoderado.parroquia' => 'required|integer|exists:nomencladors,id',
                'ubicaciones.apoderado.calle' => 'required|string|max:200',
                'ubicaciones.apoderado.casa_edificio' => 'required|string|max:100',
                'ubicaciones.apoderado.piso' => 'required|string|max:10',
                'ubicaciones.apoderado.apartamento' => 'required|string|max:10',
            ]);
            if ($this->showAssigned == 1) {
                $this->validate([
                    'foto' => 'required|image|max:1024',
                ]);
            }
        }

        if ($this->currentStep == 4) {
            $this->validate([
                'delito' => 'required|string|max:255', // <-- Añadido aquí
                'foto_cedula_solicitante' => 'required|image|max:2048',
            ]);
            if ($this->showAssigned == 1) {
                $this->validate([
                    'foto_cedula_apoderado' => 'required|image|max:2048',
                    'foto_poder' => 'required|image|max:2048',
                ]);
            }
        }

        if ($this->currentStep == 5) {
            $this->validate([
                'abogado_id' => 'required|exists:users,id',
            ]);
        }
    }

        public function updatedCedula($value)
    {
        $persona = \App\Models\Persona::where('cedula', $value)->first();
        if ($persona) {
            $this->nacionalidad = $persona->nacionalidad;
            $this->primernombre = $persona->primer_nombre;
            $this->segundonombre = $persona->segundo_nombre;
            $this->primerapellido = $persona->primer_apellido;
            $this->segundoapellido = $persona->segundo_apellido;
            $this->sexo = $persona->sexo;
            $this->email = $persona->correo;
            // Teléfonos
            $telefonos = $persona->telefonos;
            foreach ($telefonos as $tel) {
                if ($tel->tipo === 'movil') {
                    $this->telefono = $tel->numero;
                } elseif ($tel->tipo === 'local') {
                    $this->telefonolocal = $tel->numero;
                }
            }
            // Direcciones
            $direccion = $persona->direcciones->first();
            if ($direccion) {
                $this->ubicaciones['solicitante']['estado'] = $this->getNomencladorIdByNombre($direccion->estado);
                $this->ubicaciones['solicitante']['municipio'] = $this->getNomencladorIdByNombre($direccion->municipio);
                $this->ubicaciones['solicitante']['parroquia'] = $this->getNomencladorIdByNombre($direccion->parroquia);
                $this->ubicaciones['solicitante']['calle'] = $direccion->calle;
                $this->ubicaciones['solicitante']['casa_edificio'] = $direccion->{'casa-edificio'};
                $this->ubicaciones['solicitante']['piso'] = $direccion->piso;
                $this->ubicaciones['solicitante']['apartamento'] = $direccion->apartamento;
            }
        }
    }

    public function updatedCedulaApoderado($value)
    {
        $persona = \App\Models\Persona::where('cedula', $value)->first();
        if ($persona) {
            $this->nacionalidad_apoderado = $persona->nacionalidad;
            $this->primernombre_apoderado = $persona->primer_nombre;
            $this->segundonombre_apoderado = $persona->segundo_nombre;
            $this->primerapellido_apoderado = $persona->primer_apellido;
            $this->segundoapellido_apoderado = $persona->segundo_apellido;
            $this->sexo_apoderado = $persona->sexo;
            $this->email_apoderado = $persona->correo;
            // Teléfonos
            $telefonos = $persona->telefonos;
            foreach ($telefonos as $tel) {
                if ($tel->tipo === 'movil') {
                    $this->telefono_apoderado = $tel->numero;
                } elseif ($tel->tipo === 'local') {
                    $this->telefonolocal_apoderado = $tel->numero;
                }
            }
            // Direcciones
            $direccion = $persona->direcciones->first();
            if ($direccion) {
                $this->ubicaciones['apoderado']['estado'] = $this->getNomencladorIdByNombre($direccion->estado);
                $this->ubicaciones['apoderado']['municipio'] = $this->getNomencladorIdByNombre($direccion->municipio);
                $this->ubicaciones['apoderado']['parroquia'] = $this->getNomencladorIdByNombre($direccion->parroquia);
                $this->ubicaciones['apoderado']['calle'] = $direccion->calle;
                $this->ubicaciones['apoderado']['casa_edificio'] = $direccion->{'casa-edificio'};
                $this->ubicaciones['apoderado']['piso'] = $direccion->piso;
                $this->ubicaciones['apoderado']['apartamento'] = $direccion->apartamento;
            }
        }
    }

    private function getNomencladorIdByNombre($nombre)
    {
        $nomenclador = \App\Models\Nomenclador::where('nombre', $nombre)->first();
        return $nomenclador ? $nomenclador->id : null;
    }

        /**
     * Crea un directorio en el disco 'public' si no existe.
     */
    public function makeDirectory($path)
    {
        if (!Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->makeDirectory($path);
        }
        return true;
    }

    /**
     * Actualiza los permisos recursivamente en un directorio del disco 'public'.
     * @param string $folder Carpeta base dentro de storage/app/public
     * @param string $permissions Permisos en formato octal, por ejemplo '755'
     */
    public function updateRecursivePermissions($folder, $permissions = '755')
    {
        $basePath = storage_path('app/public/' . $folder);
        if (is_dir($basePath)) {
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($basePath, \FilesystemIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::SELF_FIRST
            );
            foreach ($iterator as $item) {
                @chmod($item, octdec($permissions));
            }
            // También la carpeta base
            @chmod($basePath, octdec($permissions));
            return true;
        }
        return false;
    }

    public function render()
    {
        return view('livewire.solicitud-administrativa',[
            'totalSteps' => $this->totalSteps,
            'currentStep' => $this->currentStep,
            'ubicaciones' => $this->ubicaciones,
        ]);
    }
}
