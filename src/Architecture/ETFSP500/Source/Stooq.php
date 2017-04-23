<?php

namespace Architecture\ETFSP500\Source;

use App\ETFSP500\Source;
use GuzzleHttp\Client;

class Stooq implements Source
{
    private const URL_AVERAGE_FROM_BEGINNING = 'https://stooq.pl/q/d/l/?s=etfsp500.pl&i=m';
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function monthlyAverageFromBeginning(): string
    {
        $request = $this->client->request('GET', self::URL_AVERAGE_FROM_BEGINNING);

        return substr($request->getBody(), strpos($request->getBody(), "\n") + 1);
    }
}