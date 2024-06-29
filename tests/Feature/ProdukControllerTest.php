<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Produk;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Database\Seeders\PermissionsSeeder;

class ProdukControllerTest extends TestCase
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
    public function test_produk_index_view()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->get('/produks');
        $response->assertStatus(200);
        $response->assertViewIs('masterdata.produks.index');
    }

    /** @test */
    public function test_produk_index_authorization()
    {
        $this->user->assignRole('Pegawai');
        $this->actingAs($this->user);

        $response = $this->get('/produks');
        $response->assertStatus(403);
    }

    /** @test */
    public function test_produk_create_view()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->get('/produks/create');
        $response->assertStatus(200);
    }

    /** @test */
    public function test_store_produk()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->post('/produks', [
            'nama_produk' => 'tes',
            'stok_produk' => '100',
            'harga_produk_1' => '1000',
            'harga_produk_2' => '2000',
            'harga_produk_3' => '3000',
            'harga_produk_4' => '4000',
            'deskripsi_produk' => 'tes',
        ]);

        $response->assertRedirect('/produks');
        $this->assertDatabaseHas('produks', [
            'nama_produk' => 'tes',
        ]);
    }

    /** @test */
    public function test_store_produk_authorization()
    {
        $this->user->assignRole('Pegawai');
        $this->actingAs($this->user);

        $response = $this->post('/produks', [
            'nama_produk' => 'tes',
            'stok_produk' => '100',
            'harga_produk_1' => '1000',
            'harga_produk_2' => '2000',
            'harga_produk_3' => '3000',
            'harga_produk_4' => '4000',
            'deskripsi_produk' => 'tes',
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function test_show_produk()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $produk = Produk::create([
            'nama_produk' => 'tes',
            'stok_produk' => '100',
            'harga_produk_1' => '1000',
            'harga_produk_2' => '2000',
            'harga_produk_3' => '3000',
            'harga_produk_4' => '4000',
            'deskripsi_produk' => 'tes',
        ]);

        $response = $this->get('/produks/' . $produk->id);
        $response->assertStatus(200);
        $response->assertViewHas('produk', $produk);
    }

    /** @test */
    public function test_show_produk_authorization()
    {
        $this->user->assignRole('Pegawai');
        $this->actingAs($this->user);

        $produk = Produk::create([
            'nama_produk' => 'tes',
            'stok_produk' => '100',
            'harga_produk_1' => '1000',
            'harga_produk_2' => '2000',
            'harga_produk_3' => '3000',
            'harga_produk_4' => '4000',
            'deskripsi_produk' => 'tes',
        ]);

        $response = $this->get('/produks/' . $produk->id);
        $response->assertStatus(403);
    }

    /** @test */
    public function test_update_produk()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $produk = Produk::create([
            'nama_produk' => 'tes',
            'stok_produk' => '100',
            'harga_produk_1' => '1000',
            'harga_produk_2' => '2000',
            'harga_produk_3' => '3000',
            'harga_produk_4' => '4000',
            'deskripsi_produk' => 'tes',
        ]);

        $response = $this->put('/produks/' . $produk->id, [
            'nama_produk' => 'tes updated',
            'stok_produk' => $produk->stok_produk,
            'harga_produk_1' => $produk->harga_produk_1,
            'harga_produk_2' => $produk->harga_produk_2,
            'harga_produk_3' => $produk->harga_produk_3,
            'harga_produk_4' => $produk->harga_produk_4,
            'deskripsi_produk' => $produk->deskripsi_produk,
        ]);

        $response->assertRedirect('/produks/' . $produk->id . '/edit');
        $this->assertDatabaseHas('produks', [
            'id' => $produk->id,
            'nama_produk' => 'tes updated',
        ]);
    }

    /** @test */
    public function test_update_produk_authorization()
    {
        $this->user->assignRole('Pegawai');
        $this->actingAs($this->user);

        $produk = Produk::create([
            'nama_produk' => 'tes',
            'stok_produk' => '100',
            'harga_produk_1' => '1000',
            'harga_produk_2' => '2000',
            'harga_produk_3' => '3000',
            'harga_produk_4' => '4000',
            'deskripsi_produk' => 'tes',
        ]);

        $response = $this->put('/produks/' . $produk->id, [
            'nama_produk' => 'tes updated',
            'stok_produk' => $produk->stok_produk,
            'harga_produk_1' => $produk->harga_produk_1,
            'harga_produk_2' => $produk->harga_produk_2,
            'harga_produk_3' => $produk->harga_produk_3,
            'harga_produk_4' => $produk->harga_produk_4,
            'deskripsi_produk' => $produk->deskripsi_produk,
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function test_destroy_produk()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);
    
        $produk = Produk::create([
            'nama_produk' => 'tes',
            'stok_produk' => '100',
            'harga_produk_1' => '1000',
            'harga_produk_2' => '2000',
            'harga_produk_3' => '3000',
            'harga_produk_4' => '4000',
            'deskripsi_produk' => 'tes',
        ]);

        $response = $this->delete('/produks/' . $produk->id);
        $response->assertRedirect('/produks');
    
        $this->assertDatabaseMissing('produks', ['id' => $produk->id]);
    }

    /** @test */
    public function test_destroy_produk_authorization()
    {
        $this->user->assignRole('Pegawai');
        $this->actingAs($this->user);

        $produk = Produk::create([
            'nama_produk' => 'tes',
            'stok_produk' => '100',
            'harga_produk_1' => '1000',
            'harga_produk_2' => '2000',
            'harga_produk_3' => '3000',
            'harga_produk_4' => '4000',
            'deskripsi_produk' => 'tes',
        ]);

        $response = $this->delete('/produks/' . $produk->id);
        $response->assertStatus(403);
    }
}
