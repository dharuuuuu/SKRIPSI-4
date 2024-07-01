<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Database\Seeders\PermissionsSeeder;
use Illuminate\Support\Facades\Hash;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        $this->seed(PermissionsSeeder::class);

        // Membuat pengguna untuk pengujian
        $this->user = User::create([
            'nama' => 'test',
            'alamat' => 'Indonesia',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'no_telepon' => '1234567890',
            'jenis_kelamin' => 'Laki-Laki',
            'tanggal_lahir' => now(),
        ]);
    }

    /** @test */
    public function test_profile_view()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->get('/user/profile');
        $response->assertStatus(200);
    }

    /** @test */
    public function test_berhasil_mengubah_password()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->put(route('user-password.update'), [
            'current_password' => 'password123',
            'password' => 'new-strong-password',
            'password_confirmation' => 'new-strong-password',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertTrue(Hash::check('new-strong-password', $this->user->fresh()->password));
    }

    /** @test */
    public function test_current_password_tidak_di_isi()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->put(route('user-password.update'), [
            'current_password' => '',
            'password' => 'new-strong-password',
            'password_confirmation' => 'new-strong-password',
        ]);

        $response->assertSessionDoesntHaveErrors('current_password');
    }

    /** @test */
    public function test_password_confirmation_tidak_sama()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->put(route('user-password.update'), [
            'current_password' => 'password123',
            'password' => 'new-strong-password',
            'password_confirmation' => 'different-password',
        ]);

        $response->assertSessionDoesntHaveErrors('password');
    }

    /** @test */
    public function test_current_password_salah()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->put(route('user-password.update'), [
            'current_password' => 'wrong-current-password',
            'password' => 'new-strong-password',
            'password_confirmation' => 'new-strong-password',
        ]);

        $response->assertSessionDoesntHaveErrors('current_password');
    }
}
