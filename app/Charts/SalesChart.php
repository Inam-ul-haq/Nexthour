<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class SalesChart extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->options(['legend' => [ 'display' => false ], 'scales' => ['xAxes' => ['display' => false], 'yAxes' => ['scaleLabel' => ['display' => false], 'display' => false]]]);
    }
}
