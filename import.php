<?php

include 'vendor/autoload.php';

$connectionParams = array(
    'dbname' => 'financier',
    'user' => 'root',
    'password' => '',
    'host' => 'localhost',
    'driver' => 'pdo_mysql',
);

$importer = new \App\ETFSP500\Importer(new \Architecture\ETFSP500\Source\Stooq());

$persister = new \Architecture\ETFSP500\Persister(new \Architecture\ETFSP500\PersisterStorage\Doctrine($connectionParams));
$persister->saveMonthlyAverage($importer->parseAverage());

foreach ($importer->parseDaily() as $day) {
    $persister->saveDailyAverage($day);
}