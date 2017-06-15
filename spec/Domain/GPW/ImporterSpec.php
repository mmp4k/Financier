<?php

namespace spec\Domain\GPW;

use Domain\GPW\Importer;
use Domain\GPW\Persister;
use Domain\GPW\Asset;
use Domain\GPW\ClosingPrice;
use Domain\GPW\Importer\ImportSource;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ImporterSpec extends ObjectBehavior
{
    function let(ImportSource $source, Persister $persister)
    {
        $this->beConstructedWith($source, $persister);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Importer::class);
    }

    function it_imports_asset(ImportSource $source, Persister $persister, Asset $asset, ClosingPrice $closingPrice)
    {
        $source->importAsset($asset)->shouldBeCalled();
        $source->importAsset($asset)->willReturn($closingPrice);
        $persister->persist($closingPrice)->shouldBeCalled();
        $this->importAsset($asset);
    }
}
