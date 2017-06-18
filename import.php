<?php

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

include 'vendor/autoload.php';
$config = include 'config.php';

$connection = DriverManager::getConnection($config['database'], new Configuration());

$fetcher = new \Domain\GPW\Fetcher(new \Architecture\GPW\Fetcher\Doctrine($connection));
$persister = new \Domain\GPW\Persister(new \Architecture\GPW\Persister\Doctrine($connection, $fetcher));
$importer = new \Domain\GPW\Importer(new \Architecture\GPW\Importer\Stooq(new \GuzzleHttp\Client()), $persister);

foreach (\Domain\GPW\GPW::$assets as $assetCode) {
    $importer->importAsset(new \Domain\GPW\Asset($assetCode));
}