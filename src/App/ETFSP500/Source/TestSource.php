<?php

namespace App\ETFSP500\Source;

use App\ETFSP500\Source;

class TestSource implements Source
{
    public function monthlyAverageFromBeginning(): string
    {
        $csv = <<<SOURCE
2016-11-30,86.608,94.667,81.324,94.27,70541
2016-12-30,93.785,98.39,92.536,95,72591
2017-01-31,99.99,99.99,92.78,92.78,66799
2017-02-28,93.61,98.8,91.85,98,63013
2017-03-31,98.8,100.09,92.62,96.23,112439
2017-04-28,96.19,97.9,94.24,96.49,50386
SOURCE;

        return $csv;
    }
}