<?php

namespace App\Charts\Produk;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Produk;

class StokChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\barChart
    {
        $produks = Produk::all();
    
        $nama_produk = [];
        $stok = [];

        foreach ($produks as $produk) {
            $nama_produk[] = $produk->nama_produk;
            $stok_produk[] = $produk->stok_produk;
        }

        return $this->chart->barChart()
            ->addData('Stok', $stok_produk)
            ->setXAxis($nama_produk);
    }
}
