<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class VisitorsChart extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->options(['legend' => [ 'display' => false ], 'gridLines' => [ 'display' => 'false']]);
    }
}
