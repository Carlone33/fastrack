<?php

namespace App\Livewire;

use App\Models\Funcionario;
use App\Models\Nomenclador;
use App\Models\Persona;
use App\Models\Solicitud;
use App\Models\RegistroPolicial as ModelsRegistroPolicial;
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

class RegistroPolicial extends Component
{
    use WithFileUploads;
    use StorageTrait;



    public $search = '';
    public $abogado_id;
    public $searchAbogado = '';

    // Propiedades para los campos del formulario
    public $guia, $foto, $foto_cedula_solicitante, $foto_cedula_apoderado, $foto_poder, $foto_oficio, $juzgado, $numero_oficio, $fecha_oficio, $motivo, $delito, $numero_expediente_tribunal;
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


    protected $messages = [
        // Solicitante
        'nacionalidad.required' => 'La nacionalidad es obligatoria.',
        'nacionalidad.in' => 'La nacionalidad debe ser V o E.',
        'cedula.required' => 'La cédula es obligatoria.',
        'cedula.numeric' => 'La cédula debe ser un número.',
        'cedula.digits_between' => 'La cédula debe tener entre 7 y 8 dígitos.',
        'cedula.unique' => 'Esta cédula ya está registrada.',
        'primernombre.required' => 'El primer nombre es obligatorio.',
        'primernombre.string' => 'El primer nombre debe ser texto.',
        'primernombre.max' => 'El primer nombre no puede exceder 50 caracteres.',
        'primerapellido.required' => 'El primer apellido es obligatorio.',
        'primerapellido.string' => 'El primer apellido debe ser texto.',
        'primerapellido.max' => 'El primer apellido no puede exceder 50 caracteres.',
        'sexo.required' => 'El sexo es obligatorio.',
        'sexo.in' => 'El sexo debe ser M o F.',
        'telefono.required' => 'El teléfono es obligatorio.',
        'telefono.regex' => 'El teléfono debe tener el formato 0XXX-XXXXXXX.',
        'telefonolocal.regex' => 'El teléfono local debe tener el formato 0XXX-XXXXXXX o 0XXX-XXXXXXXX.',
        'email.required' => 'El correo electrónico es obligatorio.',
        'email.email' => 'El correo electrónico debe ser válido.',
        'email.max' => 'El correo electrónico no puede exceder 100 caracteres.',
        'foto.image' => 'La foto debe ser una imagen.',
        'foto.max' => 'La foto no puede exceder 1 MB.',

        // Dirección solicitante
        'ubicaciones.solicitante.estado.required' => 'El estado es obligatorio.',
        'ubicaciones.solicitante.estado.exists' => 'El estado seleccionado no es válido.',
        'ubicaciones.solicitante.municipio.required' => 'El municipio es obligatorio.',
        'ubicaciones.solicitante.municipio.exists' => 'El municipio seleccionado no es válido.',
        'ubicaciones.solicitante.parroquia.required' => 'La parroquia es obligatoria.',
        'ubicaciones.solicitante.parroquia.exists' => 'La parroquia seleccionada no es válida.',
        'ubicaciones.solicitante.calle.required' => 'La calle es obligatoria.',
        'ubicaciones.solicitante.calle.max' => 'La calle no puede exceder 200 caracteres.',
        'ubicaciones.solicitante.casa_edificio.required' => 'La casa o edificio es obligatorio.',
        'ubicaciones.solicitante.casa_edificio.max' => 'La casa o edificio no puede exceder 100 caracteres.',
        'ubicaciones.solicitante.piso.max' => 'El piso no puede exceder 10 caracteres.',
        'ubicaciones.solicitante.apartamento.max' => 'El apartamento no puede exceder 10 caracteres.',

        // Apoderado
        'nacionalidad_apoderado.in' => 'La nacionalidad del apoderado debe ser V o E.',
        'cedula_apoderado.numeric' => 'La cédula del apoderado debe ser un número.',
        'cedula_apoderado.digits_between' => 'La cédula del apoderado debe tener entre 7 y 8 dígitos.',
        'cedula_apoderado.unique' => 'Esta cédula de apoderado ya está registrada.',
        'primernombre_apoderado.max' => 'El primer nombre del apoderado no puede exceder 50 caracteres.',
        'primerapellido_apoderado.max' => 'El primer apellido del apoderado no puede exceder 50 caracteres.',
        'sexo_apoderado.in' => 'El sexo del apoderado debe ser M o F.',
        'telefono_apoderado.regex' => 'El teléfono del apoderado debe tener el formato 0XXX-XXXXXXX.',
        'telefonolocal_apoderado.regex' => 'El teléfono local del apoderado debe tener el formato 0XXX-XXXXXXX o 0XXX-XXXXXXXX.',
        'email_apoderado.email' => 'El correo electrónico del apoderado debe ser válido.',
        'email_apoderado.max' => 'El correo electrónico del apoderado no puede exceder 100 caracteres.',

        // Dirección apoderado
        'ubicaciones.apoderado.estado.exists' => 'El estado del apoderado no es válido.',
        'ubicaciones.apoderado.municipio.exists' => 'El municipio del apoderado no es válido.',
        'ubicaciones.apoderado.parroquia.exists' => 'La parroquia del apoderado no es válida.',
        'ubicaciones.apoderado.calle.max' => 'La calle del apoderado no puede exceder 200 caracteres.',
        'ubicaciones.apoderado.casa_edificio.max' => 'La casa o edificio del apoderado no puede exceder 100 caracteres.',
        'ubicaciones.apoderado.piso.max' => 'El piso del apoderado no puede exceder 10 caracteres.',
        'ubicaciones.apoderado.apartamento.max' => 'El apartamento del apoderado no puede exceder 10 caracteres.',

        // Otros campos
        'juzgado.required' => 'El juzgado es obligatorio.',
        'juzgado.max' => 'El juzgado no puede exceder 255 caracteres.',
        'numero_oficio.required' => 'El número de oficio es obligatorio.',
        'numero_oficio.max' => 'El número de oficio no puede exceder 50 caracteres.',
        'fecha_oficio.required' => 'La fecha de oficio es obligatoria.',
        'fecha_oficio.date' => 'La fecha de oficio debe ser una fecha válida.',
        'motivo.required' => 'El motivo es obligatorio.',
        'motivo.max' => 'El motivo no puede exceder 255 caracteres.',
        'delito.required' => 'El delito es obligatorio.',
        'delito.max' => 'El delito no puede exceder 255 caracteres.',
        'numero_expediente_tribunal.required' => 'El número de expediente es obligatorio.',
        'numero_expediente_tribunal.max' => 'El número de expediente no puede exceder 100 caracteres.', // <-- Mensaje añadido aquí

        // Documentos
        'foto_cedula_solicitante.image' => 'La foto de la cédula del solicitante debe ser una imagen.',
        'foto_cedula_solicitante.max' => 'La foto de la cédula del solicitante no puede exceder 2 MB.',
        'foto_cedula_apoderado.image' => 'La foto de la cédula del apoderado debe ser una imagen.',
        'foto_cedula_apoderado.max' => 'La foto de la cédula del apoderado no puede exceder 2 MB.',
        'foto_poder.image' => 'La foto del poder debe ser una imagen.',
        'foto_poder.max' => 'La foto del poder no puede exceder 2 MB.',
        'foto_oficio.image' => 'La foto del oficio debe ser una imagen.',
        'foto_oficio.max' => 'La foto del oficio no puede exceder 2 MB.',

        // Abogado
        'abogado_id.required' => 'Debe seleccionar un abogado.',
        'abogado_id.exists' => 'El abogado seleccionado no es válido.',
    ];

    public function nextStep()
    {
        if ($this->currentStep == 1 && ($this->showAssigned == 1 || $this->showAssigned == 2)) {
            // $this->validateCurrentStep();

            $this->currentStep++;
        } elseif ($this->currentStep == 2 && $this->showAssigned == 2) {
            // $this->validateCurrentStep();

            $this->currentStep += 2;
        } elseif ($this->currentStep == 2 && $this->showAssigned == 1) {
            // $this->validateCurrentStep();

            $this->currentStep++;
        } elseif ($this->currentStep == 3 || $this->currentStep == 4) {
            // $this->validateCurrentStep();

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
            'registro_policial',
            'REGPOL',
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

        $registropolicialId = ModelsRegistroPolicial::create([
            'guia' => $this->guia = $guideService->generate(
                'registro_policial',
                'REGPOL',
                4,
                null,
                false // Modo definitivo: actualiza el número en la DB
            ),
            'numero_oficio' => $this->numero_oficio,
            'fecha_oficio' => $this->fecha_oficio,
            'nombre_tribunal' => mb_strtoupper($this->juzgado, 'UTF-8'),
            'numero_expediente_tribunal' => mb_strtoupper($this->numero_expediente_tribunal, 'UTF-8'),
            'delito' => mb_strtoupper($this->delito, 'UTF-8'),
            'motivo' => mb_strtoupper($this->motivo, 'UTF-8'),
        ])->id;

        $solicitud = Solicitud::create([
            'tipo_solicitud' => 'REGISTRO POLICIAL',
            'fecha_registro' => now(),
            'registrador_funcionario_id' => auth()->user()->funcionario->id,
            'solicitante_persona_id' => $personaIds['solicitante'],
            'apoderado_persona_id' => $personaIds['apoderado'] ?? null,
            'abogado_funcionario_id' => $abogado,
            'fecha_solicitud' => now()->toDateString(),
            'hora_solicitud' => now()->toTimeString(),
        ]);

        $registrosolicitudId = RegistroSolicitud::create([
            'solicitud_id' => $solicitud->id,
            'delito' => mb_strtoupper($this->delito, 'UTF-8'),
        ])->id;

        $dirFoto = 'solicitudes/regpol/' . $this->guia . '/';

        if ($this->makeDirectory($dirFoto)) {
            $this->updateRecursivePermissions('regpol', '755');
        }


        $imagenes_recopiladas = [
            'foto_solicitante' => [
                'foto' => $this->foto,
                'ruta' => $this->foto ? $this->foto->store('registropolicial') : null,
            ],
            'cedula_solicitante' => [
                'foto' => $this->foto_cedula_solicitante,
                'ruta' => $this->foto_cedula_solicitante ? $this->foto_cedula_solicitante->store('registropolicial') : null,
            ],
            'cedula_apoderado' => [
                'foto' => $this->foto_cedula_apoderado,
                'ruta' => $this->foto_cedula_apoderado ? $this->foto_cedula_apoderado->store('registropolicial') : null,
            ],
            'oficio' => [
                'foto' => $this->foto_oficio,
                'ruta' => $this->foto_oficio ? $this->foto_oficio->store('registropolicial') : null,
            ],
            'poder' => [
                'foto' => $this->foto_poder,
                'ruta' => $this->foto_poder ? $this->foto_poder->store('registropolicial') : null,
            ],
        ];


        foreach ($imagenes_recopiladas as $key => $imagen) {
            if ($imagen['ruta']) {
                $img = new Imagen();
                $img->tipo = $key;
                $img->url = Storage::url($imagen['ruta']);
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
        $registroPolicial = ModelsRegistroPolicial::find($registropolicialId);
        if ($registroPolicial) {
            $registroPolicial->solicitud_id = $solicitud->id;
            $registroPolicial->save();
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
            'registro_policial',
            'REGPOL',
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
                'cedula' => 'required|numeric|digits_between:7,8|unique:persona,cedula',
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
                'juzgado' => 'required|string|max:255',
                'numero_oficio' => 'required|string|max:50',
                'fecha_oficio' => 'required|date|before:now',
                'motivo' => 'required|string|max:255',
                'delito' => 'required|string|max:255',
                'numero_expediente_tribunal' => 'required|string|max:100', // <-- Añadido aquí
                'foto_cedula_solicitante' => 'required|image|max:2048',
                'foto_oficio' => 'required|image|max:2048',
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

    public function render()
    {
        // NO generes la guía aquí, solo retorna la vista y los datos necesarios
        $abogados = Funcionario::with(['persona', 'user'])
            ->whereHas('user.roles', function ($query) {
                $query->where('name', 'Abogado');
            })
            ->get();

        return view('livewire.registro-policial', [
            'abogados' => $abogados,
            'totalSteps' => $this->totalSteps,
            'currentStep' => $this->currentStep,
            'ubicaciones' => $this->ubicaciones,
        ]);
    }
}
