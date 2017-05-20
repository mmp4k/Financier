<?php

include_once 'vendor/autoload.php';
$config = include 'config.php';
$wallet = include 'transactions.php';

$businessDay = new \Domain\ETFSP500\BusinessDay(new \DateTime());

$storage = new \Architecture\ETFSP500\Storage\Doctrine($config['database']);

$notifierSwiftmailer = new \Architecture\NotifierProvider\Swiftmailer(
        $config['notifier']['swiftmailer.host'],
        $config['notifier']['swiftmailer.user'],
        $config['notifier']['swiftmailer.pass'],
        $config['notifier']['swiftmailer.send_to']);
$notifier = new \Domain\Notifier\Notifier($notifierSwiftmailer);
$notifier->collect(new \Domain\ETFSP500\LessThan($storage, 90, $businessDay));
$notifier->collect(new \Domain\ETFSP500\LessThanAverage($storage, $businessDay));
$notifier->collect(new \Domain\ETFSP500\NotifierRule\Daily());
$notifier->addNotifyHandler(new \Architecture\ETFSP500\NotifyHandler\Daily($wallet, $storage));
$notifier->addNotifyHandler(new \Architecture\ETFSP500\NotifyHandler\LessThan());
$notifier->addNotifyHandler(new \Architecture\ETFSP500\NotifyHandler\LessThanAverage());
$notifier->notify();