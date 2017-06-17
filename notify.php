<?php

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

include_once 'vendor/autoload.php';
$config = include 'config.php';
$wallet = include 'transactions.php';

$connection = DriverManager::getConnection($config['database'], new Configuration());

$response = new \Architecture\Notifier\NotifierProvider\ArrayProvider\Response();
$arrayProvider = new \Architecture\Notifier\NotifierProvider\ArrayProvider($response);
$notifier = new \Domain\Notifier\Notifier($arrayProvider);

$fetcher = new \Domain\GPW\Fetcher(new \Architecture\GPW\Fetcher\Doctrine($connection));

$rule = new \Domain\GPW\NotifierRule\LessThan(new \Domain\GPW\Asset('ETFSP500'), 400);
$notifier->collect($rule);
$notifier->addNotifyHandler(new \Domain\GPW\NotifyHandler\LessThan($fetcher));
$notifier->notify();

print_r($response->getBody());

//$persister = new \Domain\Notifier\Persister(new \Architecture\Notifier\PersisterStorage\Doctrine($connection));
//$persister->persist($rule);

$fetcherUser = new \Domain\User\Fetcher(new \Architecture\User\FetcherStorage\Doctrine($connection));
$user = $fetcherUser->findUserByIdentify('m@pilsniak.com');

//$assigner = new \Domain\User\Assigner(new \Architecture\User\AssignerStorage\Doctrine($connection));
//$assigner->assign(new \Architecture\Notifier\UserResource\UserNotifierRule($rule, $user));

$notifierFetcher = new \Domain\Notifier\Fetcher(new \Architecture\Notifier\FetcherStorage\Doctrine($connection));
$notifierFetcher->addFactory(new \Domain\GPW\NotifierRule\Factory\LessThanFactory());

$userRulesFinder = new \Architecture\Notifier\UserResource\UserNotifierFinder(
    new \Domain\User\UserResourceFinder(new \Architecture\User\FinderStorage\Doctrine($connection)),
    $notifierFetcher
);

$notifier = new \Domain\Notifier\Notifier($arrayProvider);
$notifier->addNotifyHandler(new \Domain\GPW\NotifyHandler\LessThan($fetcher));
foreach ($userRulesFinder->findRules($user) as $rule) {
    $notifier->collect($rule->rule());
}
$notifier->notify();
print_r($response->getBody());
return;
/*
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
$fetcher->addFactory(new \Domain\Wallet\NotifierRule\Factory\Daily());
$fetcher->addFactory(new \Domain\ETFSP500\NotifierRule\Factory\LessThan($storage, $businessDay));
$fetcher->addFactory(new \Domain\ETFSP500\NotifierRule\Factory\LessThanAverage($storage, $businessDay));
foreach ($fetcher->getNotifierRules() as $rule) {
    $notifier->collect($rule);
}

$notifier->addNotifyHandler(new \Domain\Wallet\NotifyHandler\Daily($wallet, $storage, $businessDay));
$notifier->addNotifyHandler(new \Domain\ETFSP500\NotifyHandler\LessThan());
$notifier->addNotifyHandler(new \Domain\ETFSP500\NotifyHandler\LessThanAverage());
$notifier->notify();


//$persister = new \Domain\Notifier\Persister(new Architecture\Notifier\PersisterStorage\Doctrine($connection));
//$persister->persist(new \Domain\Wallet\NotifierRule\Daily());
print_r($response->getBody());
*/