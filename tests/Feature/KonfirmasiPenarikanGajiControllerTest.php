<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\PenarikanGaji;
use App\Models\GajiPegawai;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Database\Seeders\PermissionsSeeder;

class KonfirmasiPenarikanGajiControllerTest extends TestCase
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
    public function test_konfirmasi_penarikan_gaji_index_view()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->get('/konfirmasi_penarikan_gaji');
        $response->assertStatus(200);
        $response->assertViewIs('gaji.konfirmasi_penarikan_gaji.index');
    }

    /** @test */
    public function test_konfirmasi_penarikan_gaji_index_authorization()
    {
        $this->user->assignRole('Pegawai');
        $this->actingAs($this->user);

        $response = $this->get('/konfirmasi_penarikan_gaji');
        $response->assertStatus(403);
    }

    /** @test */
    public function test_terima_ajukan_penarikan_gaji()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $gaji_pegawai = GajiPegawai::create([
            'pegawai_id' => $this->user->id,
            'total_gaji_yang_bisa_diajukan' => 1000,
            'terhitung_tanggal' => now(),
        ]);

        $penarikan_gaji = PenarikanGaji::create([
            'pegawai_id' => $this->user->id,
            'gaji_yang_diajukan' => 1000,
            'status' => 'Diajukan',
            'mulai_tanggal' => now(),
            'akhir_tanggal' => now(),
            'gaji_diberikan' => null,
        ]);

        $response = $this->patch(route('konfirmasi_penarikan_gaji.terima_ajuan', $penarikan_gaji->id), [
            'pegawai_id' => $this->user->id,
            'gaji_yang_diajukan' => 1000,
            'status' => 'Diterima',
            'mulai_tanggal' => now(),
            'akhir_tanggal' => now(),
            'gaji_diberikan' => null,
        ]);


        $response->assertRedirect(route('konfirmasi_penarikan_gaji.index'));
        $this->assertDatabaseHas('penarikan_gajis', [
            'pegawai_id' => $this->user->id,
            'status' => 'Diterima',
        ]);
    }

    /** @test */
    public function test_terima_ajukan_penarikan_gaji_authorization()
    {
        $this->user->assignRole('Pegawai');
        $this->actingAs($this->user);

        $gaji_pegawai = GajiPegawai::create([
            'pegawai_id' => $this->user->id,
            'total_gaji_yang_bisa_diajukan' => 1000,
            'terhitung_tanggal' => now(),
        ]);

        $penarikan_gaji = PenarikanGaji::create([
            'pegawai_id' => $this->user->id,
            'gaji_yang_diajukan' => 1000,
            'status' => 'Diajukan',
            'mulai_tanggal' => now(),
            'akhir_tanggal' => now(),
            'gaji_diberikan' => null,
        ]);

        $response = $this->patch(route('konfirmasi_penarikan_gaji.terima_ajuan', $penarikan_gaji->id), [
            'pegawai_id' => $this->user->id,
            'gaji_yang_diajukan' => 1000,
            'status' => 'Diterima',
            'mulai_tanggal' => now(),
            'akhir_tanggal' => now(),
            'gaji_diberikan' => null,
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function test_tolak_ajukan_penarikan_gaji()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $gaji_pegawai = GajiPegawai::create([
            'pegawai_id' => $this->user->id,
            'total_gaji_yang_bisa_diajukan' => 1000,
            'terhitung_tanggal' => now(),
        ]);

        $penarikan_gaji = PenarikanGaji::create([
            'pegawai_id' => $this->user->id,
            'gaji_yang_diajukan' => 1000,
            'status' => 'Diajukan',
            'mulai_tanggal' => now(),
            'akhir_tanggal' => now(),
            'gaji_diberikan' => null,
        ]);

        $response = $this->patch(route('konfirmasi_penarikan_gaji.tolak_ajuan', $penarikan_gaji->id), [
            'pegawai_id' => $this->user->id,
            'gaji_yang_diajukan' => 1000,
            'status' => 'Ditolak',
            'mulai_tanggal' => now(),
            'akhir_tanggal' => now(),
            'gaji_diberikan' => null,
        ]);


        $response->assertRedirect(route('konfirmasi_penarikan_gaji.index'));
        $this->assertDatabaseHas('penarikan_gajis', [
            'pegawai_id' => $this->user->id,
            'status' => 'Ditolak',
        ]);
    }

    /** @test */
    public function test_tolak_ajukan_penarikan_gaji_authorization()
    {
        $this->user->assignRole('Pegawai');
        $this->actingAs($this->user);

        $gaji_pegawai = GajiPegawai::create([
            'pegawai_id' => $this->user->id,
            'total_gaji_yang_bisa_diajukan' => 1000,
            'terhitung_tanggal' => now(),
        ]);

        $penarikan_gaji = PenarikanGaji::create([
            'pegawai_id' => $this->user->id,
            'gaji_yang_diajukan' => 1000,
            'status' => 'Diajukan',
            'mulai_tanggal' => now(),
            'akhir_tanggal' => now(),
            'gaji_diberikan' => null,
        ]);

        $response = $this->patch(route('konfirmasi_penarikan_gaji.tolak_ajuan', $penarikan_gaji->id), [
            'pegawai_id' => $this->user->id,
            'gaji_yang_diajukan' => 1000,
            'status' => 'Ditolak',
            'mulai_tanggal' => now(),
            'akhir_tanggal' => now(),
            'gaji_diberikan' => null,
        ]);

        $response->assertStatus(403);
    }
}
