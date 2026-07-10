<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class LdapApiService
{
    private $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.ldap.base_url');
    }

    public function authenticate($username, $password)
    {
        $response = Http::post("{$this->baseUrl}", [
            'usuario' => $username,
            'senha' => $password,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }
}