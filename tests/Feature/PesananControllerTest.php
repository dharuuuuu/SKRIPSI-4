<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\Invoice;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Database\Seeders\PermissionsSeeder;

class PesananControllerTest extends TestCase
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
    public function test_pesanan_index_view()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->get('/invoice');
        $response->assertStatus(200);
        $response->assertViewIs('transaksi.invoice.index');
    }

    /** @test */
    public function test_pesanan_index_authorization()
    {
        $this->user->assignRole('Pegawai');
        $this->actingAs($this->user);

        $response = $this->get('/invoice');
        $response->assertStatus(403);
    }

    /** @test */
    public function test_pesanan_create_view()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->get('/invoice/create');
        $response->assertStatus(200);
    }

    /** @test */
    public function test_pesanan_create_view_authorization()
    {
        $this->user->assignRole('Pegawai');
        $this->actingAs($this->user);

        $response = $this->get('/invoice/create');
        $response->assertStatus(403);
    }

    /** @test */
    public function test_store_pesanan()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $user = User::create([
            'nama' => 'test 123',
            'alamat' => 'Indonesia',
            'email' => 'test123@example.com',
            'password' => bcrypt('password123'),
            'no_telepon' => '1234567890',
            'jenis_kelamin' => 'Laki-Laki',
            'tanggal_lahir' => now(),
        ]);
        $user->assignRole('Sales');

        $produk_1 = Produk::create([
            'nama_produk' => 'tes1',
            'stok_produk' => '100',
            'harga_produk_1' => '1000',
            'harga_produk_2' => '2000',
            'harga_produk_3' => '3000',
            'harga_produk_4' => '4000',
            'deskripsi_produk' => 'tes',
        ]);

        $produk_2 = Produk::create([
            'nama_produk' => 'tes2',
            'stok_produk' => '100',
            'harga_produk_1' => '1000',
            'harga_produk_2' => '2000',
            'harga_produk_3' => '3000',
            'harga_produk_4' => '4000',
            'deskripsi_produk' => 'tes',
        ]);
    
        $invoice = Invoice::create([
            'customer_id' => $user->id,
            'invoice' => 'IVC-1',
            'sub_total' => '1000',
            'tagihan_sebelumnya' => '1000',
            'tagihan_total' => '1000',
            'jumlah_bayar' => null,
            'tagihan_sisa' => null,
        ]);

        $response = $this->post('/invoice', [
            'customer_id' => $user->id,
            'produk_id' => [$produk_1->id, $produk_2->id],
            'jumlah_pesanan' => [10, 5],
            'harga' => [$produk_1->harga_produk_1, $produk_2->harga_produk_1],
        ]);

        $response->assertRedirect('/invoice/' . $produk_2->id . '/edit');
        $this->assertDatabaseHas('invoices', [
            'invoice' => 'IVC-1',
        ]);
    }

    /** @test */
    public function test_store_pesanan_authorization()
    {
        $this->user->assignRole('Pegawai');
        $this->actingAs($this->user);

        $user = User::create([
            'nama' => 'test 123',
            'alamat' => 'Indonesia',
            'email' => 'test123@example.com',
            'password' => bcrypt('password123'),
            'no_telepon' => '1234567890',
            'jenis_kelamin' => 'Laki-Laki',
            'tanggal_lahir' => now(),
        ]);
        $user->assignRole('Sales');

        $produk_1 = Produk::create([
            'nama_produk' => 'tes1',
            'stok_produk' => '100',
            'harga_produk_1' => '1000',
            'harga_produk_2' => '2000',
            'harga_produk_3' => '3000',
            'harga_produk_4' => '4000',
            'deskripsi_produk' => 'tes',
        ]);

        $produk_2 = Produk::create([
            'nama_produk' => 'tes2',
            'stok_produk' => '100',
            'harga_produk_1' => '1000',
            'harga_produk_2' => '2000',
            'harga_produk_3' => '3000',
            'harga_produk_4' => '4000',
            'deskripsi_produk' => 'tes',
        ]);
    
        $invoice = Invoice::create([
            'customer_id' => $user->id,
            'invoice' => 'IVC-1',
            'sub_total' => '1000',
            'tagihan_sebelumnya' => '1000',
            'tagihan_total' => '1000',
            'jumlah_bayar' => null,
            'tagihan_sisa' => null,
        ]);

        $response = $this->post('/invoice', [
            'customer_id' => $user->id,
            'produk_id' => [$produk_1->id, $produk_2->id],
            'jumlah_pesanan' => [10, 5],
            'harga' => [$produk_1->harga_produk_1, $produk_2->harga_produk_1],
        ]);

        $response->assertStatus(403);
    }

   /** @test */
    public function test_show_pesanan()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $user = User::create([
            'nama' => 'test 123',
            'alamat' => 'Indonesia',
            'email' => 'test123@example.com',
            'password' => bcrypt('password123'),
            'no_telepon' => '1234567890',
            'jenis_kelamin' => 'Laki-Laki',
            'tanggal_lahir' => now(),
        ]);
        $user->assignRole('Sales');

        $produk_1 = Produk::create([
            'nama_produk' => 'tes1',
            'stok_produk' => '100',
            'harga_produk_1' => 1000,
            'harga_produk_2' => 2000,
            'harga_produk_3' => 3000,
            'harga_produk_4' => 4000,
            'deskripsi_produk' => 'tes',
        ]);

        $produk_2 = Produk::create([
            'nama_produk' => 'tes2',
            'stok_produk' => '100',
            'harga_produk_1' => 1000,
            'harga_produk_2' => 2000,
            'harga_produk_3' => 3000,
            'harga_produk_4' => 4000,
            'deskripsi_produk' => 'tes',
        ]);

        $invoice = Invoice::create([
            'customer_id' => $user->id,
            'invoice' => 'IVC-1',
            'sub_total' => 1000,
            'tagihan_sebelumnya' => 1000,
            'tagihan_total' => 1000,
            'jumlah_bayar' => 1000,
            'tagihan_sisa' => 1000,
        ]);

        $pesanan_1 = Pesanan::create([
            'invoice_id' => $invoice->id,
            'customer_id' => $user->id,
            'produk_id' => $produk_1->id,
            'jumlah_pesanan' => 10,
            'harga' => $produk_1->harga_produk_1,
        ]);

        $pesanan_2 = Pesanan::create([
            'invoice_id' => $invoice->id,
            'customer_id' => $user->id,
            'produk_id' => $produk_2->id,
            'jumlah_pesanan' => 5,
            'harga' => $produk_2->harga_produk_1,
        ]);

        $response = $this->get('/invoice/' . $invoice->id);
        $response->assertStatus(200);
        $response->assertViewHas('invoice', $invoice);
    }


    /** @test */
    public function test_show_pesanan_authorization()
    {
        $this->user->assignRole('Pegawai');
        $this->actingAs($this->user);

        $user = User::create([
            'nama' => 'test 123',
            'alamat' => 'Indonesia',
            'email' => 'test123@example.com',
            'password' => bcrypt('password123'),
            'no_telepon' => '1234567890',
            'jenis_kelamin' => 'Laki-Laki',
            'tanggal_lahir' => now(),
        ]);
        $user->assignRole('Sales');

        $produk_1 = Produk::create([
            'nama_produk' => 'tes1',
            'stok_produk' => '100',
            'harga_produk_1' => 1000,
            'harga_produk_2' => 2000,
            'harga_produk_3' => 3000,
            'harga_produk_4' => 4000,
            'deskripsi_produk' => 'tes',
        ]);

        $produk_2 = Produk::create([
            'nama_produk' => 'tes2',
            'stok_produk' => '100',
            'harga_produk_1' => 1000,
            'harga_produk_2' => 2000,
            'harga_produk_3' => 3000,
            'harga_produk_4' => 4000,
            'deskripsi_produk' => 'tes',
        ]);

        $invoice = Invoice::create([
            'customer_id' => $user->id,
            'invoice' => 'IVC-1',
            'sub_total' => 1000,
            'tagihan_sebelumnya' => 1000,
            'tagihan_total' => 1000,
            'jumlah_bayar' => 1000,
            'tagihan_sisa' => 1000,
        ]);

        $pesanan_1 = Pesanan::create([
            'invoice_id' => $invoice->id,
            'customer_id' => $user->id,
            'produk_id' => $produk_1->id,
            'jumlah_pesanan' => 10,
            'harga' => $produk_1->harga_produk_1,
        ]);

        $pesanan_2 = Pesanan::create([
            'invoice_id' => $invoice->id,
            'customer_id' => $user->id,
            'produk_id' => $produk_2->id,
            'jumlah_pesanan' => 5,
            'harga' => $produk_2->harga_produk_1,
        ]);

        $response = $this->get('/invoice/' . $invoice->id);
        $response->assertStatus(403);
    }

    /** @test */
    public function test_update_pesanan()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $user = User::create([
            'nama' => 'test 123',
            'alamat' => 'Indonesia',
            'email' => 'test123@example.com',
            'password' => bcrypt('password123'),
            'no_telepon' => '1234567890',
            'jenis_kelamin' => 'Laki-Laki',
            'tanggal_lahir' => now(),
        ]);
        $user->assignRole('Sales');

        $produk_1 = Produk::create([
            'nama_produk' => 'tes1',
            'stok_produk' => '100',
            'harga_produk_1' => 1000,
            'harga_produk_2' => 2000,
            'harga_produk_3' => 3000,
            'harga_produk_4' => 4000,
            'deskripsi_produk' => 'tes',
        ]);

        $produk_2 = Produk::create([
            'nama_produk' => 'tes2',
            'stok_produk' => '100',
            'harga_produk_1' => 1000,
            'harga_produk_2' => 2000,
            'harga_produk_3' => 3000,
            'harga_produk_4' => 4000,
            'deskripsi_produk' => 'tes',
        ]);

        $invoice = Invoice::create([
            'customer_id' => $user->id,
            'invoice' => 'IVC-1',
            'sub_total' => 1000,
            'tagihan_sebelumnya' => 1000,
            'tagihan_total' => 1000,
            'jumlah_bayar' => 1000,
            'tagihan_sisa' => 1000,
        ]);

        $pesanan_1 = Pesanan::create([
            'invoice_id' => $invoice->id,
            'customer_id' => $user->id,
            'produk_id' => $produk_1->id,
            'jumlah_pesanan' => 10,
            'harga' => $produk_1->harga_produk_1,
        ]);

        $pesanan_2 = Pesanan::create([
            'invoice_id' => $invoice->id,
            'customer_id' => $user->id,
            'produk_id' => $produk_2->id,
            'jumlah_pesanan' => 5,
            'harga' => $produk_2->harga_produk_1,
        ]);

        $response = $this->put('/invoice/' . $invoice->id, [
            'jumlah_bayar' => 2000,
        ]);

        $response->assertRedirect('/invoice');
        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'jumlah_bayar' => 2000,
        ]);
    }

    /** @test */
    public function test_update_kegiatan_authorization()
    {
        $this->user->assignRole('Pegawai');
        $this->actingAs($this->user);

        $user = User::create([
            'nama' => 'test 123',
            'alamat' => 'Indonesia',
            'email' => 'test123@example.com',
            'password' => bcrypt('password123'),
            'no_telepon' => '1234567890',
            'jenis_kelamin' => 'Laki-Laki',
            'tanggal_lahir' => now(),
        ]);
        $user->assignRole('Sales');

        $produk_1 = Produk::create([
            'nama_produk' => 'tes1',
            'stok_produk' => '100',
            'harga_produk_1' => 1000,
            'harga_produk_2' => 2000,
            'harga_produk_3' => 3000,
            'harga_produk_4' => 4000,
            'deskripsi_produk' => 'tes',
        ]);

        $produk_2 = Produk::create([
            'nama_produk' => 'tes2',
            'stok_produk' => '100',
            'harga_produk_1' => 1000,
            'harga_produk_2' => 2000,
            'harga_produk_3' => 3000,
            'harga_produk_4' => 4000,
            'deskripsi_produk' => 'tes',
        ]);

        $invoice = Invoice::create([
            'customer_id' => $user->id,
            'invoice' => 'IVC-1',
            'sub_total' => 1000,
            'tagihan_sebelumnya' => 1000,
            'tagihan_total' => 1000,
            'jumlah_bayar' => 1000,
            'tagihan_sisa' => 1000,
        ]);

        $pesanan_1 = Pesanan::create([
            'invoice_id' => $invoice->id,
            'customer_id' => $user->id,
            'produk_id' => $produk_1->id,
            'jumlah_pesanan' => 10,
            'harga' => $produk_1->harga_produk_1,
        ]);

        $pesanan_2 = Pesanan::create([
            'invoice_id' => $invoice->id,
            'customer_id' => $user->id,
            'produk_id' => $produk_2->id,
            'jumlah_pesanan' => 5,
            'harga' => $produk_2->harga_produk_1,
        ]);

        $response = $this->put('/invoice/' . $invoice->id, [
            'jumlah_bayar' => 2000,
        ]);

        $response->assertStatus(302);
    }

    /** @test */
    public function test_destroy_kegiatan()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);
    
        $user = User::create([
            'nama' => 'test 123',
            'alamat' => 'Indonesia',
            'email' => 'test123@example.com',
            'password' => bcrypt('password123'),
            'no_telepon' => '1234567890',
            'jenis_kelamin' => 'Laki-Laki',
            'tanggal_lahir' => now(),
        ]);
        $user->assignRole('Sales');

        $produk = Produk::create([
            'nama_produk' => 'tes1',
            'stok_produk' => '100',
            'harga_produk_1' => 1000,
            'harga_produk_2' => 2000,
            'harga_produk_3' => 3000,
            'harga_produk_4' => 4000,
            'deskripsi_produk' => 'tes',
        ]);

        $invoice = Invoice::create([
            'customer_id' => $user->id,
            'invoice' => 'IVC-1',
            'sub_total' => 1000,
            'tagihan_sebelumnya' => 1000,
            'tagihan_total' => 1000,
            'jumlah_bayar' => 1000,
            'tagihan_sisa' => 1000,
        ]);

        $pesanan = Pesanan::create([
            'invoice_id' => $invoice->id,
            'customer_id' => $user->id,
            'produk_id' => $produk->id,
            'jumlah_pesanan' => 10,
            'harga' => $produk->harga_produk_1,
        ]);

        $response = $this->delete('/invoice/' . $invoice->id);
        $response->assertRedirect('/invoice');
    
        $this->assertDatabaseMissing('invoices', ['id' => $invoice->id]);
    }

    /** @test */
    public function test_destroy_kegiatan_authorization()
    {
        $this->user->assignRole('Pegawai');
        $this->actingAs($this->user);

        $user = User::create([
            'nama' => 'test 123',
            'alamat' => 'Indonesia',
            'email' => 'test123@example.com',
            'password' => bcrypt('password123'),
            'no_telepon' => '1234567890',
            'jenis_kelamin' => 'Laki-Laki',
            'tanggal_lahir' => now(),
        ]);
        $user->assignRole('Sales');

        $produk = Produk::create([
            'nama_produk' => 'tes1',
            'stok_produk' => '100',
            'harga_produk_1' => 1000,
            'harga_produk_2' => 2000,
            'harga_produk_3' => 3000,
            'harga_produk_4' => 4000,
            'deskripsi_produk' => 'tes',
        ]);

        $invoice = Invoice::create([
            'customer_id' => $user->id,
            'invoice' => 'IVC-1',
            'sub_total' => 1000,
            'tagihan_sebelumnya' => 1000,
            'tagihan_total' => 1000,
            'jumlah_bayar' => 1000,
            'tagihan_sisa' => 1000,
        ]);

        $pesanan = Pesanan::create([
            'invoice_id' => $invoice->id,
            'customer_id' => $user->id,
            'produk_id' => $produk->id,
            'jumlah_pesanan' => 10,
            'harga' => $produk->harga_produk_1,
        ]);

        $response = $this->delete('/invoice/' . $invoice->id);
        $response->assertStatus(403);
    }
}
