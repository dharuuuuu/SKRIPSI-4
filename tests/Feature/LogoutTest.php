<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Migrasi database
        $this->artisan('migrate');

        // Membuat role admin
        $role = Role::create(['name' => 'Admin']);

        // Membuat pengguna untuk pengujian
        $this->user = User::factory()->create([
            'nama' => 'test',
            'alamat' => 'Indonesia',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'no_telepon' => '1234567890',
            'jenis_kelamin' => 'Laki-Laki',
            'tanggal_lahir' => now(),
        ]);

        // Menginisiasi user dengan role admin
        $this->user->assignRole($role);
    }

    public function test_logout(): void
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->post(route('logout'));
        $response->assertRedirect('/');
        $this->assertGuest();
        $response->assertStatus(302);
    }
}
