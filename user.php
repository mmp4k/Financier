<?php

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

include_once 'vendor/autoload.php';
$wallet = include 'transactions.php';

$config = include 'config.php';

$connection = DriverManager::getConnection($config['database'], new Configuration());

//$user = new \Domain\User\User('m@pilsniak.com');
//$persister = new \Domain\User\Persister(new \Architecture\User\PersisterStorage\Doctrine($connection));
//$persister->persist($user);

$fetcherUser = new \Domain\User\Fetcher(new \Architecture\User\FetcherStorage\Doctrine($connection));
$user = $fetcherUser->findUserByIdentify('m@pilsniak.com');

var_dump($user);

$businessDay = new \Domain\ETFSP500\BusinessDay(new \DateTime());
$storage = new \Architecture\ETFSP500\Storage\Doctrine($connection);
$assigner = new \Domain\User\Assigner(new \Architecture\User\AssignerStorage\Doctrine($connection));
$fetcherStorage = new Architecture\Notifier\FetcherStorage\Doctrine($connection);
$fetcher = new \Domain\Notifier\Fetcher($fetcherStorage, $storage);
$fetcher->addFactory(new \Domain\Wallet\NotifierRule\Factory\Daily());
$fetcher->addFactory(new \Domain\ETFSP500\NotifierRule\Factory\LessThan($storage, $businessDay));
$fetcher->addFactory(new \Domain\ETFSP500\NotifierRule\Factory\LessThanAverage($storage, $businessDay));
$rulePersister = new \Domain\Notifier\Persister(new \Architecture\Notifier\PersisterStorage\Doctrine($connection));
//foreach ($fetcher->getNotifierRules() as $rule) {

$rule = new \Domain\Wallet\NotifierRule\Daily();
$rulePersister->persist($rule);

    $uerNotify = new \Architecture\Notifier\UserResource\UserNotifierRule($rule, $user);
    $assigner->assign($uerNotify);

//}
/*

$walletPersister = new \Domain\Wallet\Persister(new \Architecture\Wallet\PersisterStorage\Doctrine($connection));
$walletPersister->persist($wallet);

$assigner = new \Domain\User\Assigner(new \Architecture\User\AssignerStorage\Doctrine($connection));
$userWallet = new \Architecture\Wallet\UserResource\UserWallet($wallet, $user);
$assigner->assign($userWallet);
*/

/*

$fetcherWallet = new \Domain\Wallet\Fetcher(new \Architecture\Wallet\FetcherStorage\Doctrine($connection));

$wallet = $fetcherWallet->findWallet(\Ramsey\Uuid\Uuid::fromString('069fb553-6c89-452d-a601-2f51375506be'));

$userWallet = new \Architecture\Wallet\UserResource\UserWallet($wallet, $user);

//$assigner = new \Domain\User\Assigner(new \Architecture\User\AssignerStorage\Doctrine($connection));
//$assigner->assign($userWallet);
*/