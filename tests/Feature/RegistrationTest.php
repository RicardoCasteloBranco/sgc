<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Jetstream;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_requires_authentication(): void
    {
        if (! Features::enabled(Features::registration())) {
            $this->markTestSkipped('Registration support is not enabled.');
        }

        $response = $this->get('/register');

        $response->assertRedirect('/login');
    }

    public function test_registration_screen_cannot_be_rendered_if_support_is_disabled(): void
    {
        if (Features::enabled(Features::registration())) {
            $this->markTestSkipped('Registration support is enabled.');
        }

        $response = $this->get('/register');

        $response->assertStatus(404);
    }

    public function test_new_users_can_register(): void
    {
        if (! Features::enabled(Features::registration())) {
            $this->markTestSkipped('Registration support is not enabled.');
        }

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'login' => 'admin-login',
            'matricula' => 123,
            'cargo' => 'Administrador',
        ]);

        $this->actingAs($admin);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'login' => '12345678901',
            'email' => 'test@example.com',
            'matricula' => '987654321',
            'cargo' => 'Analista',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
        ]);

        $response->assertRedirect(route('register', absolute: false));
        $this->assertAuthenticatedAs($admin);
        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'login' => '12345678901',
            'email' => 'test@example.com',
            'matricula' => '987654321',
            'cargo' => 'Analista',
        ]);
        $this->assertSessionHas('status', 'Usuário cadastrado com sucesso.');
    }

    public function test_guests_cannot_register_users(): void
    {
        if (! Features::enabled(Features::registration())) {
            $this->markTestSkipped('Registration support is not enabled.');
        }

        $response = $this->post('/register', [
            'name' => 'Test User',
            'login' => '12345678901',
            'email' => 'test@example.com',
            'matricula' => '987654321',
            'cargo' => 'Analista',
        ]);

        $response->assertRedirect('/login');
        $this->assertDatabaseMissing('users', ['email' => 'test@example.com']);
    }
}
