<?php

use App\Livewire\Dictamen;
use App\Livewire\RegistroPolicial;
use App\Livewire\RegistroUnico;
use App\Livewire\SolicitudAdministrativa;
use App\Livewire\Solicitudes;
use App\Livewire\InterfazAdministrador;
use App\Livewire\InterfazPermisologia;
use App\Livewire\InterfazAbogado;
use Illuminate\Support\Facades\Route;
use App\Livewire\MultiStepFormTesT;
use App\Http\Controllers\AbogadoController;
use App\Http\Controllers\PreguntasController;
use App\Livewire\EstablecerPreguntas;
use App\Livewire\Inicio;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/login'); // Redirige al login
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/inicio', function () {
        return view('inicio');
    })->name('inicio');

    Route::get('/inicio', Inicio::class)->name('inicio');

    // Route::get('/solicitud-administrativa', SolicitudAdministrativa::class)->name('solicitud-administrativa');
    Route::get('/registro-unico', RegistroUnico::class)->name('registro-unico');
    // Route::get('/dictamen', Dictamen::class)->name('dictamen');
    Route::get('/registro-policial', RegistroPolicial::class)->name('registro-policial');
    Route::get('/solicitudes', Solicitudes::class)->middleware('can:Crear transcripciones')->name('solicitudes');
    Route::get('/admin', InterfazAdministrador::class)->middleware('can:Ver usuarios')->name('admin');
    Route::get('/permisos', InterfazPermisologia::class)->middleware('can:Ver permisos')->name('permisos');
    Route::get('/menu', InterfazAbogado::class)->middleware('can:Ver transcripciones')->name('menu');
    Route::get('/buscar-abogados', [AbogadoController::class, 'buscar'])->name('buscar.abogados');

});
Route::get('/establecer-preguntas', EstablecerPreguntas::class)->name('establecer.preguntas');
Route::post('/verificar-preguntas', [App\Http\Controllers\Auth\PreguntaSeguridadController::class, 'verificar'])->name('preguntas.verificar');
Route::post('/destroy-session', [App\Http\Controllers\DestroySessionController::class, 'destroy'])->name('destroy.session');
Route::get('/preguntas-json', [App\Http\Controllers\PreguntasController::class, 'json'])->name('preguntas.json');
