<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\GajiPegawai;
use App\Models\Kegiatan;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Database\Seeders\PermissionsSeeder;

class KegiatanControllerTest extends TestCase
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
    public function test_kegiatan_index_view()
    {
        $this->user->assignRole('Pegawai');
        $this->actingAs($this->user);

        $response = $this->get('/kegiatan');
        $response->assertStatus(200);
        $response->assertViewIs('transaksi.kegiatan.index');
    }

    /** @test */
    public function test_kegiatan_index_authorization()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->get('/kegiatan');
        $response->assertStatus(403);
    }

    /** @test */
    public function test_kegiatan_create_view()
    {
        $this->user->assignRole('Pegawai');
        $this->actingAs($this->user);

        $response = $this->get('/kegiatan/create');
        $response->assertStatus(200);
    }

    /** @test */
    public function test_kegiatan_create_view_authorization()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->get('/kegiatan/create');
        $response->assertStatus(403);
    }

    /** @test */
    public function test_store_kegiatan()
    {
        $this->user->assignRole('Pegawai');
        $this->actingAs($this->user);

        $item = Item::create([
            'nama_item' => 'tes',
            'gaji_per_item' => '1000',
            'deskripsi_item' => 'tes',
        ]);

        $kegiatan = [
            'item_id' => $item->id,
            'user_id' => $this->user->id,
            'status_kegiatan' => 'Belum Ditarik',
            'jumlah_kegiatan' => 10,
            'catatan' => 'test',
            'kegiatan_dibuat' => now(),
        ];

        $gaji_pegawai = GajiPegawai::create([
            'pegawai_id' => $this->user->id,
            'total_gaji_yang_bisa_diajukan' => $kegiatan['jumlah_kegiatan'] * $item->gaji_per_item,
        ]);
    
        $response = $this->post('/kegiatan', $kegiatan);

        $response->assertRedirect('/kegiatan');
        $this->assertDatabaseHas('kegiatans', [
            'item_id' => $item->id,
        ]);
    }

    /** @test */
    public function test_store_kegiatan_authorization()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $item = Item::create([
            'nama_item' => 'tes',
            'gaji_per_item' => '1000',
            'deskripsi_item' => 'tes',
        ]);

        $kegiatan = [
            'item_id' => $item->id,
            'user_id' => $this->user->id,
            'status_kegiatan' => 'Belum Ditarik',
            'jumlah_kegiatan' => 10,
            'catatan' => 'test',
            'kegiatan_dibuat' => now(),
        ];

        $gaji_pegawai = GajiPegawai::create([
            'pegawai_id' => $this->user->id,
            'total_gaji_yang_bisa_diajukan' => $kegiatan['jumlah_kegiatan'] * $item->gaji_per_item,
        ]);
    
        $response = $this->post('/kegiatan', $kegiatan);

        $response->assertStatus(403);
    }

    /** @test */
    public function test_show_kegiatan()
    {
        $this->user->assignRole('Pegawai');
        $this->actingAs($this->user);

        $item = Item::create([
            'nama_item' => 'tes',
            'gaji_per_item' => '1000',
            'deskripsi_item' => 'tes',
        ]);

        $kegiatan = Kegiatan::create([
            'item_id' => $item->id,
            'user_id' => $this->user->id,
            'status_kegiatan' => 'Belum Ditarik',
            'jumlah_kegiatan' => 10,
            'catatan' => 'test',
            'kegiatan_dibuat' => now(),
        ]);

        $gaji_pegawai = GajiPegawai::create([
            'pegawai_id' => $this->user->id,
            'total_gaji_yang_bisa_diajukan' => $kegiatan['jumlah_kegiatan'] * $item->gaji_per_item,
        ]);

        $response = $this->get('/kegiatan/' . $kegiatan->id);
        $response->assertStatus(200);
        $response->assertViewHas('kegiatan', $kegiatan);
    }

    /** @test */
    public function test_show_kegiatan_authorization()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $item = Item::create([
            'nama_item' => 'tes',
            'gaji_per_item' => '1000',
            'deskripsi_item' => 'tes',
        ]);

        $kegiatan = Kegiatan::create([
            'item_id' => $item->id,
            'user_id' => $this->user->id,
            'status_kegiatan' => 'Belum Ditarik',
            'jumlah_kegiatan' => 10,
            'catatan' => 'test',
            'kegiatan_dibuat' => now(),
        ]);

        $gaji_pegawai = GajiPegawai::create([
            'pegawai_id' => $this->user->id,
            'total_gaji_yang_bisa_diajukan' => $kegiatan['jumlah_kegiatan'] * $item->gaji_per_item,
        ]);

        $response = $this->get('/kegiatan/' . $kegiatan->id);
        $response->assertStatus(403);
    }

    /** @test */
    public function test_update_kegiatan()
    {
        $this->user->assignRole('Pegawai');
        $this->actingAs($this->user);

        $item = Item::create([
            'nama_item' => 'tes',
            'gaji_per_item' => '1000',
            'deskripsi_item' => 'tes',
        ]);

        $kegiatan = Kegiatan::create([
            'item_id' => $item->id,
            'user_id' => $this->user->id,
            'status_kegiatan' => 'Belum Ditarik',
            'jumlah_kegiatan' => 10,
            'catatan' => 'test',
            'kegiatan_dibuat' => now(),
        ]);

        $gaji_pegawai = GajiPegawai::create([
            'pegawai_id' => $this->user->id,
            'total_gaji_yang_bisa_diajukan' => $kegiatan['jumlah_kegiatan'] * $item->gaji_per_item,
        ]);

        $response = $this->put('/kegiatan/' . $kegiatan->id, [
            'item_id' => $item->id,
            'user_id' => $this->user->id,
            'status_kegiatan' => 'Belum Ditarik',
            'jumlah_kegiatan' => 10,
            'catatan' => 'test updated',
            'kegiatan_dibuat' => now(),
        ]);

        $response->assertRedirect('/kegiatan/' . $kegiatan->id . '/edit');
        $this->assertDatabaseHas('kegiatans', [
            'id' => $kegiatan->id,
            'catatan' => 'test updated',
        ]);
    }

    /** @test */
    public function test_update_kegiatan_authorization()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $item = Item::create([
            'nama_item' => 'tes',
            'gaji_per_item' => '1000',
            'deskripsi_item' => 'tes',
        ]);

        $kegiatan = Kegiatan::create([
            'item_id' => $item->id,
            'user_id' => $this->user->id,
            'status_kegiatan' => 'Belum Ditarik',
            'jumlah_kegiatan' => 10,
            'catatan' => 'test',
            'kegiatan_dibuat' => now(),
        ]);

        $gaji_pegawai = GajiPegawai::create([
            'pegawai_id' => $this->user->id,
            'total_gaji_yang_bisa_diajukan' => $kegiatan['jumlah_kegiatan'] * $item->gaji_per_item,
        ]);

        $response = $this->put('/kegiatan/' . $kegiatan->id, [
            'item_id' => $item->id,
            'user_id' => $this->user->id,
            'status_kegiatan' => 'Belum Ditarik',
            'jumlah_kegiatan' => 10,
            'catatan' => 'test updated',
            'kegiatan_dibuat' => now(),
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function test_destroy_kegiatan()
    {
        $this->user->assignRole('Pegawai');
        $this->actingAs($this->user);
    
        $item = Item::create([
            'nama_item' => 'tes',
            'gaji_per_item' => '1000',
            'deskripsi_item' => 'tes',
        ]);

        $kegiatan = Kegiatan::create([
            'item_id' => $item->id,
            'user_id' => $this->user->id,
            'status_kegiatan' => 'Belum Ditarik',
            'jumlah_kegiatan' => 10,
            'catatan' => 'test',
            'kegiatan_dibuat' => now(),
        ]);

        $gaji_pegawai = GajiPegawai::create([
            'pegawai_id' => $this->user->id,
            'total_gaji_yang_bisa_diajukan' => $kegiatan['jumlah_kegiatan'] * $item->gaji_per_item,
        ]);

        $response = $this->delete('/kegiatan/' . $kegiatan->id);
        $response->assertRedirect('/kegiatan');
    
        $this->assertDatabaseMissing('kegiatans', ['id' => $kegiatan->id]);
    }

    /** @test */
    public function test_destroy_kegiatan_authorization()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $item = Item::create([
            'nama_item' => 'tes',
            'gaji_per_item' => '1000',
            'deskripsi_item' => 'tes',
        ]);

        $kegiatan = Kegiatan::create([
            'item_id' => $item->id,
            'user_id' => $this->user->id,
            'status_kegiatan' => 'Belum Ditarik',
            'jumlah_kegiatan' => 10,
            'catatan' => 'test',
            'kegiatan_dibuat' => now(),
        ]);

        $gaji_pegawai = GajiPegawai::create([
            'pegawai_id' => $this->user->id,
            'total_gaji_yang_bisa_diajukan' => $kegiatan['jumlah_kegiatan'] * $item->gaji_per_item,
        ]);

        $response = $this->delete('/kegiatan/' . $kegiatan->id);
        $response->assertStatus(403);
    }
}
