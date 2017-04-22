<?php

namespace spec\App\ETFSP500;

use App\ETFSP500\Importer;
use App\ETFSP500\Source;
use App\ETFSP500\MonthlyAverageCollection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ImporterSpec extends ObjectBehavior
{
    function let(Source $source)
    {
        $this->beConstructedWith($source);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Importer::class);
    }

    function it_parses_average_table_in_csv_format(Source $source)
    {
        $csv = <<<SOURCE
2016-11-30,86.608,94.667,81.324,94.27,70541
2016-12-30,93.785,98.39,92.536,95,72591
2017-01-31,99.99,99.99,92.78,92.78,66799
2017-02-28,93.61,98.8,91.85,98,63013
2017-03-31,98.8,100.09,92.62,96.23,112439
2017-04-28,96.19,97.9,94.24,96.49,50386
SOURCE;
        $source->monthlyAverageFromBeginning()->willReturn($csv);
        $source->monthlyAverageFromBeginning()->shouldBeCalled();

        /** @var MonthlyAverageCollection $collection */
        $collection = $this->parseAverage()->shouldBeAnInstanceOf(MonthlyAverageCollection::class);
        $this->parseAverage()->shouldImplement(\Iterator::class);

        assert($collection->count() === 6);
    }
}
