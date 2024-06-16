<?php

namespace App\Charts\StokMasuk;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\RiwayatStokProduk;
use Illuminate\Support\Facades\DB;
use App\Models\Produk;

class StokMasukChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\barChart
    {
         // Fetch all products
        $products = Produk::all();

        // Initialize array to hold unique dates
        $uniqueDates = [];

        // Data sets for each product
        $dataSets = [];

        // Loop through each product
        foreach ($products as $product) {
            // Fetch stock entries for the current product grouped by date
            $stokMasukData = RiwayatStokProduk::where('id_produk', $product->id)
                ->select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('SUM(stok_masuk) as total_stok')
                )
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get();

            // Initialize arrays to hold dates and total stocks for the current product
            $productDates = [];
            $productTotalStoks = [];

            // Loop through each record to get the date and total stock
            foreach ($stokMasukData as $data) {
                $productDates[] = $data->date;
                $productTotalStoks[] = $data->total_stok;
                if (!in_array($data->date, $uniqueDates)) {
                    $uniqueDates[] = $data->date;
                }
            }

            // Add dataset for the current product
            $dataSets[$product->nama_produk] = [
                'dates' => $productDates,
                'totals' => $productTotalStoks
            ];
        }

        // Ensure unique dates are sorted
        sort($uniqueDates);

        // Align data for each product according to unique dates
        $finalDataSets = [];
        foreach ($dataSets as $productName => $data) {
            $alignedData = [];
            foreach ($uniqueDates as $date) {
                $key = array_search($date, $data['dates']);
                $alignedData[] = $key !== false ? $data['totals'][$key] : 0;
            }
            $finalDataSets[] = [
                'name' => $productName,
                'data' => $alignedData
            ];
        }

        // Create the line chart
        $barChart = $this->chart->barChart()
            ->setXAxis($uniqueDates);

        // Add data for each product
        foreach ($finalDataSets as $dataSet) {
            $barChart->addData($dataSet['name'], $dataSet['data']);
        }

        return $barChart;
    }
}
