<?php

namespace App\Charts\RiwayatPenarikanGaji;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\PenarikanGaji;
use Carbon\Carbon;

class RiwayatPenarikanGajiChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\areaChart
    {

        // Fetch activities with status 'Selesai' for the authenticated user
        $penarikan_gajis = PenarikanGaji::where('status', 'Diterima')
                    ->with('user') // Ensure we fetch related item data
                    ->get();

        // Initialize arrays to hold dates and item activities
        $dates = [];
        $itemActivities = [];

        // Group activities by date and item
        foreach ($penarikan_gajis as $penarikan_gaji) {
            $date = Carbon::parse($penarikan_gaji->gaji_diberikan)->format('Y-m-d');
            $user_name = $penarikan_gaji->user->nama;

            // Ensure the date entry exists
            if (!isset($dates[$date])) {
                $dates[$date] = [];
            }

            // Ensure the item entry exists for the date
            if (!isset($dates[$date][$user_name])) {
                $dates[$date][$user_name] = 0;
            }

            // Sum the activities for each item on each date
            $dates[$date][$user_name] += $penarikan_gaji->gaji_yang_diajukan;
        }

        // Extract unique dates and sort them
        $uniqueDates = array_keys($dates);
        sort($uniqueDates);

        // Prepare the chart data
        $chart = $this->chart->areaChart()
            ->setXAxis($uniqueDates);

        // Initialize an array to hold the items
        $items = [];

        // Fill item activity data for each date
        foreach ($uniqueDates as $date) {
            foreach ($dates[$date] as $user_name => $activityCount) {
                if (!isset($itemActivities[$user_name])) {
                    $itemActivities[$user_name] = [];
                }
                $itemActivities[$user_name][$date] = $activityCount;
                if (!in_array($user_name, $items)) {
                    $items[] = $user_name;
                }
            }
        }

        // Align data for each item according to unique dates
        foreach ($items as $item) {
            $seriesData = [];
            foreach ($uniqueDates as $date) {
                $seriesData[] = $itemActivities[$item][$date] ?? 0;
            }
            $chart->addData($item, $seriesData);
        }

        return $chart;
    }
}
