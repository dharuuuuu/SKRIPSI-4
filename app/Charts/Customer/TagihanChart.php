<?php

namespace App\Charts\Customer;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Customer;

class TagihanChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\barChart
    {
        $customers = Customer::all();
        
        $nama_customer = [];
        $tagihan = [];

        foreach ($customers as $customer) {
            $nama_customer[] = $customer->nama;
            $tagihan[] = $customer->tagihan;
        }

        return $this->chart->barChart()
            ->addData('Tagihan', $tagihan)
            ->setXAxis($nama_customer);
    }
}
