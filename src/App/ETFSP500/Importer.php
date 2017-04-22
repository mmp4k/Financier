<?php

namespace App\ETFSP500;

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

    public function parseAverage()
    {
        $collections = new MonthlyAverageCollection();

        foreach (explode("\n", trim($this->source->monthlyAverageFromBeginning())) as $line) {
            list($date, $open, $topPick, $downPick, $close, $volume) = explode(',', $line);
            list($year, $month, $day) = explode('-', $date);
            $collections->add(new MonthlyAverage((int) $month, (int) $year, (float) $close));
        }
        return $collections;
    }
}
