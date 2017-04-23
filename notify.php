<?php

include 'vendor/autoload.php';

$connectionParams = array(
    'dbname' => 'financier',
    'user' => 'root',
    'password' => '',
    'host' => 'localhost',
    'driver' => 'pdo_mysql',
);

$storage = new \Architecture\ETFSP500\Storage\Doctrine();

$notifier = new \App\Notifier();
$notifier->collect(new \App\ETFSP500\LessThan($storage, 86.4));
$notifier->collect(new \App\ETFSP500\LessThanAverage($storage));
$notifier->notify();