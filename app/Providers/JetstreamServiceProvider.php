<?php

namespace App\Providers;

use App\Models\Funcionario;
use App\Models\TrazaAcceso;
use App\Actions\Jetstream\DeleteUser;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class JetstreamServiceProvider extends ServiceProvider
{

    // /**
    //  * Debido a un bug de Fortify::authenticateUsing que resulta en una
    // doble ejecucion de la autenticacion
    //  * se creo una variable que diferencie el primer llamado del
    // segundo para ejecutar el registro de la traza.
    //  * Para Abril del 2024 fue categorizado como un error sin arreglo
    // por el equipo de Laravel por la naturaleza
    //  * inofensiva del error y su alto potencial de generar errores en
    // caso de arreglarlo.
    //  */
    protected $isFirstCall = true;


    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Request $request): void
    {
        $this->configurePermissions();

        Jetstream::deleteUsersUsing(DeleteUser::class);

        Fortify::authenticateUsing(function (Request $request) {
            $errores = [];
            $funcionario = Funcionario::where('credencial', $request->credencial)->first();

            if ($funcionario) {
                $user = User::where('funcionario_id', $funcionario->id)->first();

                if ($user) {
                    if ($user->habilitado) {
                        if (Hash::check($request->password, $user->password)) {
                            $session = DB::select('select * from sessions where user_id = ?', [$user->id]);

                            if (!$session) {
                                if ($this->isFirstCall) {
                                    $this->isFirstCall = false;

                                    // Obten la direccion IP del usuario
                                    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                                        $ip = $_SERVER['HTTP_CLIENT_IP'];
                                    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                                        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                                    } else {
                                        $ip = $_SERVER['REMOTE_ADDR'];
                                    }

                                    $historialSesion = new TrazaAcceso;
                                    $historialSesion->user_id = $user->id;
                                    $historialSesion->ip = $ip;
                                    $historialSesion->login = now();
                                    $historialSesion->save();
                                }

                                $user->intentos_fallidos = 0;
                                $id = $user->id;
                                $user->save();
                                if (is_null($user->pregunta_1)) {
                                    session()->put('question1', $id);
                                    return null;
                                } else {
                                    session()->put('user_id', $id);
                                    $rifa=['pregunta_1' => $user->pregunta_1, 'pregunta_2' => $user->pregunta_2, 'pregunta_3' => $user->pregunta_3];
                                    session()->put('rifa', $rifa);
                                    return null;
                                }

                            } else {
                                $errores[] = 'Ya existe una sesión activa.';
                            }
                        } else {
                            $nIntento = $user->intentos_fallidos;
                            if ($nIntento != 3) {
                                $errores[] = ((3 - $nIntento) != 1) ? 'Clave incorrecta, ' . (3 - $nIntento) . ' intentos restantes.' : 'Clave incorrecta, ultimo intento.';
                                $user->intentos_fallidos = $nIntento + 1;
                                $user->save();
                            } else {
                                $errores[] = 'Su usuario ha sido bloqueado.';
                                $user->habilitado = false;
                                $user->save();
                            }
                        }
                    } else {
                        $errores[] = 'Su usuario ha sido deshabilitado.';
                    }
                } else {
                    $errores[] = 'No existe un usuario asociado a estas credenciales.';
                }
            } else {
                $errores[] = 'Las credenciales no coinciden con ningún registro.';
            }

            session()->flash('errores', $errores);
            return null;
        });
    }

    /**
     * Configure the permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }
}
