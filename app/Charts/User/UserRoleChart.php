<?php

namespace App\Charts\User;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserRoleChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $roles = Role::all();
        
        $roleNames = [];
        $userCounts = [];

        foreach ($roles as $role) {
            $roleNames[] = $role->name;
            $userCounts[] = User::role($role->name)->count();
        }

        // Create the pie chart
        return $this->chart->pieChart()
            ->addData($userCounts)
            ->setLabels($roleNames);
    }
}
