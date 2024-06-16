<?php

namespace App\Charts\Pesanan;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Invoice;

class PemasukanChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\areaChart
    {
        $invoices = Invoice::all();
        
        $tanggal = [];
        $pemasukan = [];

        foreach ($invoices as $invoice) {
            $tanggal[] = $invoice->created_at->format('Y-m-d');
            $pemasukan[] = $invoice->tagihan_saat_pesan;
        }

        return $this->chart->areaChart()
            ->addData('Pemasukan', $pemasukan)
            ->setXAxis($tanggal);
    }
}
