<?php

include 'vendor/autoload.php';
$config = include 'config.php';

$importer = new \Architecture\ETFSP500\Importer(new \Architecture\ETFSP500\Source\Stooq());

$persister = new \Architecture\ETFSP500\Persister(new \Architecture\ETFSP500\PersisterStorage\Doctrine($config['database']));
$persister->saveMonthlyAverage($importer->parseAverage());

foreach ($importer->parseDaily() as $day) {
    $persister->saveDailyAverage($day);
}