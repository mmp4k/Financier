<?php

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

include_once 'vendor/autoload.php';
$config = include 'config.php';
$wallet = include 'transactions.php';

$connection = DriverManager::getConnection($config['database'], new Configuration());

$businessDay = new \Domain\ETFSP500\BusinessDay(new \DateTime());

$storage = new \Architecture\ETFSP500\Storage\Doctrine($connection);

$notifierSwiftmailer = new \Architecture\Notifier\NotifierProvider\Swiftmailer(
        $config['notifier']['swiftmailer.host'],
        $config['notifier']['swiftmailer.user'],
        $config['notifier']['swiftmailer.pass'],
        $config['notifier']['swiftmailer.send_to']);
$response = new \Architecture\Notifier\NotifierProvider\ArrayProvider\Response();
$arrayProvider = new \Architecture\Notifier\NotifierProvider\ArrayProvider($response);
$notifier = new \Domain\Notifier\Notifier($arrayProvider);

$fetcherStorage = new Architecture\Notifier\FetcherStorage\Doctrine($connection);
$fetcher = new \Domain\Notifier\Fetcher($fetcherStorage, $storage);
foreach ($fetcher->getNotifierRules() as $rule) {
    $notifier->collect($rule);
}

//$notifier->collect($n1 = new \Domain\ETFSP500\NotifierRule\LessThan($storage, 90, $businessDay));
//$notifier->collect($n2 = new \Domain\ETFSP500\NotifierRule\LessThanAverage($storage, $businessDay));
//$notifier->collect($n3 = new \Domain\ETFSP500\NotifierRule\Daily());
$notifier->addNotifyHandler(new \Domain\ETFSP500\NotifyHandler\Daily($wallet, $storage, $businessDay));
$notifier->addNotifyHandler(new \Domain\ETFSP500\NotifyHandler\LessThan());
$notifier->addNotifyHandler(new \Domain\ETFSP500\NotifyHandler\LessThanAverage());
$notifier->notify();

print_r($response->getBody());
/*
$persister = new \Domain\Notifier\Persister(new Architecture\Notifier\PersisterStorage\Doctrine($config['database']));
$persister->persist($n1);
$persister->persist($n2);
$persister->persist($n3);
*/