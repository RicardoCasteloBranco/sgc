<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Fortify;
use App\Services\LdapApiService;
use App\Models\User;
use App\Models\Perfil;
use App\Models\PerfilUsuario;

class FortifyServiceProvider extends ServiceProvider
{
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
    public function boot(): void
    {
        Fortify::authenticateUsing(function (Request $request) {

            $username = $request->input('username');
            $password = $request->input('password');

            $ldapService = new LdapApiService();

            $ldapData = $ldapService->authenticate($username, $password);
            if (!$ldapData) {
                return null;
            }

            /*
            * Procura um perfil pertencente ao sistema.
            */
            $ldapUser = collect($ldapData['data'])->first(function ($perfil) {
                foreach ($perfil as $key => $linha) {
                    if (str_starts_with($linha, 'Sistema:')) {
                        if (trim(substr($linha, 9)) === config('app.name')
                            && trim(substr($perfil[$key + 1],8)) == "ATIVO") {
                            return true;
                        }
                    }
                }

                return false;
            });

            if (!$ldapUser) {
                return null;
            }

            /*
            * Converte o array de strings em array associativo
            */
            $usuario = [];

            foreach ($ldapUser as $linha) {

                [$campo, $valor] = explode(': ', $linha, 2);

                $usuario[$campo] = $valor;
            }

            return $this->criarAcesso($usuario);
        });

        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }

    private function criarAcesso($usuario)
    {
        $idPerfil = Perfil::where('descricao', strtoupper($usuario['Perfil'] ?? null))->value('id');
        
        $user = User::updateOrCreate(
                [
                    'login' => $usuario['Login'] ?? null, //alterar aqui para CPF
                
                ],
                [
                    'name'     => $usuario['Nome de Guerra'],
                    'email'    => strtolower($usuario['Email']) ?? null,
                    'matricula' => $usuario['Matricula'] ?? null,
                    'cargo' => $usuario['Cargo'] ?? null,
                    'ome_disposicao' => $usuario['Ome Disposição'] ?? null,
                    'id_ome_disposicao' => (int)($usuario['Id Ome Disposição'] ?? null),
                    'secao' => $usuario['Secao'] ?? null,
                ]
        );

        PerfilUsuario::updateOrCreate(
            [
                    'user_id' => $user->id ?? null,
            ],
            [
                'user_id' => $user->id,
                'perfil_id' => $idPerfil,
            ]
        );
        return $user;
    }
}
