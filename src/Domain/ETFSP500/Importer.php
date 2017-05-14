<?php

namespace Domain\ETFSP500;

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

    public function parseDaily()
    {
        $collections = new DailyAverageCollection();

        foreach (explode("\n", trim($this->source->dailyAverageFromBeginning())) as $line) {
            list($date, $open, $topPick, $downPick, $close, $volume) = explode(',', $line);
            $collections->add(new DailyAverage(\DateTime::createFromFormat('Y-m-d', $date), (float) $close));
        }
        return $collections;
    }
}
