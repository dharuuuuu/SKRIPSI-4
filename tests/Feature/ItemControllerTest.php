<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Database\Seeders\PermissionsSeeder;

class ItemControllerTest extends TestCase
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
    public function test_item_index_view()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->get('/items');
        $response->assertStatus(200);
        $response->assertViewIs('masterdata.items.index');
    }

    /** @test */
    public function test_item_index_authorization()
    {
        $this->user->assignRole('Pegawai');
        $this->actingAs($this->user);

        $response = $this->get('/items');
        $response->assertStatus(403);
    }

    /** @test */
    public function test_item_create_view()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->get('/items/create');
        $response->assertStatus(200);
    }

    /** @test */
    public function test_store_item()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->post('/items', [
            'nama_item' => 'tes',
            'gaji_per_item' => '1000',
            'deskripsi_item' => 'tes',
        ]);

        $response->assertRedirect('/items');
        $this->assertDatabaseHas('items', [
            'nama_item' => 'tes',
        ]);
    }

    /** @test */
    public function test_store_item_authorization()
    {
        $this->user->assignRole('Pegawai');
        $this->actingAs($this->user);

        $response = $this->post('/items', [
            'nama_item' => 'tes',
            'gaji_per_item' => '1000',
            'deskripsi_item' => 'tes',
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function test_show_item()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $item = Item::create([
            'nama_item' => 'tes',
            'gaji_per_item' => '1000',
            'deskripsi_item' => 'tes',
        ]);

        $response = $this->get('/items/' . $item->id);
        $response->assertStatus(200);
        $response->assertViewHas('item', $item);
    }

    /** @test */
    public function test_show_item_authorization()
    {
        $this->user->assignRole('Pegawai');
        $this->actingAs($this->user);

        $item = Item::create([
            'nama_item' => 'tes',
            'gaji_per_item' => '1000',
            'deskripsi_item' => 'tes',
        ]);

        $response = $this->get('/items/' . $item->id);
        $response->assertStatus(403);
    }

    /** @test */
    public function test_update_item()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $item = Item::create([
            'nama_item' => 'tes',
            'gaji_per_item' => '1000',
            'deskripsi_item' => 'tes',
        ]);

        $response = $this->put('/items/' . $item->id, [
            'nama_item' => 'tes updated',
            'gaji_per_item' => $item->gaji_per_item,
            'deskripsi_item' => $item->deskripsi_item,
        ]);

        $response->assertRedirect('/items/' . $item->id . '/edit');
        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'nama_item' => 'tes updated',
        ]);
    }

    /** @test */
    public function test_update_item_authorization()
    {
        $this->user->assignRole('Pegawai');
        $this->actingAs($this->user);

        $item = Item::create([
            'nama_item' => 'tes',
            'gaji_per_item' => '1000',
            'deskripsi_item' => 'tes',
        ]);

        $response = $this->put('/items/' . $item->id, [
            'nama_item' => 'tes updated',
            'gaji_per_item' => $item->gaji_per_item,
            'deskripsi_item' => $item->deskripsi_item,
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function test_destroy_item()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);
    
        $item = Item::create([
            'nama_item' => 'tes',
            'gaji_per_item' => '1000',
            'deskripsi_item' => 'tes',
        ]);

        $response = $this->delete('/items/' . $item->id);
        $response->assertRedirect('/items');
    
        $this->assertDatabaseMissing('items', ['id' => $item->id]);
    }

    /** @test */
    public function test_destroy_item_authorization()
    {
        $this->user->assignRole('Pegawai');
        $this->actingAs($this->user);

        $item = Item::create([
            'nama_item' => 'tes',
            'gaji_per_item' => '1000',
            'deskripsi_item' => 'tes',
        ]);

        $response = $this->delete('/items/' . $item->id);
        $response->assertStatus(403);
    }
}
