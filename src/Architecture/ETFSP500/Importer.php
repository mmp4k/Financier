<?php

namespace Architecture\ETFSP500;

use Domain\ETFSP500\DailyAverage;
use Domain\ETFSP500\DailyAverageCollection;
use Domain\ETFSP500\MonthlyAverage;
use Domain\ETFSP500\MonthlyAverageCollection;
use Architecture\ETFSP500\Source;

class Importer
{
    /**
     * @var Source
     */
    private $source;

    public function __construct(Source $source)
    {
        $this->source = $source;
    }

    public function parseAverage() : MonthlyAverageCollection
    {
        $collections = new MonthlyAverageCollection();

        foreach (explode("\n", trim($this->source->monthlyAverageFromBeginning())) as $line) {
            list($date, $open, $topPick, $downPick, $close, $volume) = explode(',', $line);
            list($year, $month, $day) = explode('-', $date);
            $collections->add(new MonthlyAverage((int) $month, (int) $year, (float) $close));
        }
        return $collections;
    }

    public function parseDaily() : DailyAverageCollection
    {
        $collections = new DailyAverageCollection();

        foreach (explode("\n", trim($this->source->dailyAverageFromBeginning())) as $line) {
            list($date, $open, $topPick, $downPick, $close, $volume) = explode(',', $line);
            $collections->add(new DailyAverage(\DateTime::createFromFormat('Y-m-d', $date), (float) $close));
        }
        return $collections;
    }
}
