<?php

namespace spec\Architecture\GPW\Importer;

use Architecture\GPW\Importer\Stooq;
use Domain\GPW\Asset;
use Domain\GPW\Importer\ImportSource;
use Guzzle\Stream\StreamInterface;
use GuzzleHttp\Client;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;

class StooqSpec extends ObjectBehavior
{
    function let(Client $client, ResponseInterface $response, StreamInterface $stream)
    {
        $client->request(Argument::any(), Argument::any())->willReturn($response);
        $response->getBody()->willReturn($stream);

        $this->beConstructedWith($client);
        $this->shouldImplement(ImportSource::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Stooq::class);
    }

    function it_imports_asset(Asset $asset, StreamInterface $stream)
    {
        $html = '<tr id=f13><td id=t03>Kurs</td><td><b>93.35</b></td></tr><tr id=f13>';

        $stream->__toString()->willReturn($html);
        $asset->code()->willReturn('ETFSP500');
        $asset->code()->shouldBeCalled();

        $closingPrice = $this->importAsset($asset);
        $closingPrice->price()->shouldBe(93.35);
    }
}
