<?php

include_once 'vendor/autoload.php';
$config = include 'config.php';
$wallet = include 'transactions.php';

$storage = new \Architecture\ETFSP500\Storage\Doctrine($config['database']);

$notifierSwiftmailer = new \Architecture\NotifierProvider\Swiftmailer(
        $config['notifier']['swiftmailer.host'],
        $config['notifier']['swiftmailer.user'],
        $config['notifier']['swiftmailer.pass'],
        $config['notifier']['swiftmailer.send_to']);
$notifier = new \App\Notifier($notifierSwiftmailer);
$notifier->collect(new \App\ETFSP500\LessThan($storage, 90));
$notifier->collect(new \App\ETFSP500\LessThanAverage($storage));
$notifier->collect(new \App\ETFSP500\NotifierRule\Daily());
$notifier->addNotifyHandler(new \Architecture\ETFSP500\NotifyHandler\Daily($wallet, $storage));
$notifier->addNotifyHandler(new \Architecture\ETFSP500\NotifyHandler\LessThan());
$notifier->addNotifyHandler(new \Architecture\ETFSP500\NotifyHandler\LessThanAverage());
$notifier->notify();