<?php

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

include 'vendor/autoload.php';
$config = include 'config.php';

$connection = DriverManager::getConnection($config['database'], new Configuration());

$importer = new \Architecture\ETFSP500\Importer(new \Architecture\ETFSP500\Source\Stooq());

$persister = new \Architecture\ETFSP500\Persister(new \Architecture\ETFSP500\PersisterStorage\Doctrine($connection));
$persister->saveMonthlyAverage($importer->parseAverage());

foreach ($importer->parseDaily() as $day) {
    $persister->saveDailyAverage($day);
}