<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Database\Seeders\PermissionsSeeder;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        $this->seed(PermissionsSeeder::class);

        // Membuat pengguna untuk pengujian
        $user = User::factory()->create([
            'nama' => 'test',
            'alamat' => 'Indonesia',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'no_telepon' => '1234567890',
            'jenis_kelamin' => 'Laki-Laki',
            'tanggal_lahir' => now(),
        ]);

        // Menginisiasi user dengan role admin
        $user->assignRole('Admin');
        
        // Acting sebagai user
        $this->actingAs($user); 
    }


    public function test_menampilkan_page_admin_index()
    {
        $response = $this->get('/admin');

        $response->assertStatus(200);
        $response->assertViewIs('users.admin.index');
    }
}
