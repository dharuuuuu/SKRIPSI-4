<?php

namespace App\Charts\User;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class JenisKelaminChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        return $this->chart->pieChart()
            ->addData([
                \App\Models\User::where('jenis_kelamin', '=', 'Laki-Laki')->count(),
                \App\Models\User::where('jenis_kelamin', '=', 'Perempuan')->count()
            ])
            ->setLabels(['Laki-Laki', 'Perempuan'])
            ->setColors(['#44bbf7', '#f3519a']);
    }
}
