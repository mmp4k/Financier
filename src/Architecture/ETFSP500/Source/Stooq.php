<?php

namespace Architecture\ETFSP500\Source;

use Architecture\ETFSP500\Source;
use GuzzleHttp\Client;

class Stooq implements Source
{
    private const URL_AVERAGE_FROM_BEGINNING = 'https://stooq.pl/q/d/l/?s=etfsp500.pl&i=m';
    private const URL_DAILY_SINCE_BEGINNING = 'https://stooq.pl/q/g/?s=etfsp500.pl';
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

    public function dailyAverageFromBeginning() : string
    {
        $request = $this->client->request('GET', self::URL_DAILY_SINCE_BEGINNING);

        preg_match('#<td id=t03>Kurs</td><td><b>([0-9\.]+)</b></td>#', $request->getBody(), $sharePrice);

        return date('Y-m-d') . ',,,,' . $sharePrice[1] . ',';
    }

}