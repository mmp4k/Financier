<?php

namespace Architecture\GPW\Importer;

use Domain\GPW\Asset;
use Domain\GPW\ClosingPrice;
use Domain\GPW\Importer\ImportSource;
use GuzzleHttp\Client;

class Stooq implements ImportSource
{
    private const URL_DAILY_SINCE_BEGINNING = 'https://stooq.pl/q/g/?s=%s';

    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function importAsset(Asset $asset): ClosingPrice
    {
        $url = sprintf(self::URL_DAILY_SINCE_BEGINNING, strtolower($asset->code()).'.pl');

        $request = $this->client->request('GET', $url);

        preg_match('#<td id=t03>Kurs</td><td><b>([0-9\.]+)</b></td>#', $request->getBody(), $sharePrice);

        return new ClosingPrice($asset, new \DateTime(), (float) $sharePrice[1]);
    }
}
