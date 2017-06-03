<?php

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

include_once 'vendor/autoload.php';

$config = include 'config.php';

$connection = DriverManager::getConnection($config['database'], new Configuration());

//$user = new \Domain\User\User('m@pilsniak.com');
//$persister = new \Domain\User\Persister(new \Architecture\User\PersisterStorage\Doctrine($connection));
//$persister->persist($user);

$fetcherUser = new \Domain\User\Fetcher(new \Architecture\User\FetcherStorage\Doctrine($connection));
$user = $fetcherUser->findUserByIdentify('m@pilsniak.com');

var_dump($user);

$fetcherWallet = new \Domain\Wallet\Fetcher(new \Architecture\Wallet\FetcherStorage\Doctrine($connection));

$wallet = $fetcherWallet->findWallet(\Ramsey\Uuid\Uuid::fromString('069fb553-6c89-452d-a601-2f51375506be'));

$userWallet = new \Architecture\Wallet\UserResource\UserWallet($wallet, $user);

$assigner = new \Domain\User\Assigner(new \Architecture\User\AssignerStorage\Doctrine($connection));
$assigner->assign($userWallet);
