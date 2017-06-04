<?php

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

$currentValue = 92.7;
$commissionOut = 5.0;

include_once 'vendor/autoload.php';

/** @var \Domain\Wallet\Wallet $wallet */
$wallet = include 'transactions.php';
$config = include 'config.php';

$connection = DriverManager::getConnection($config['database'], new Configuration());
//$persister = new \Domain\Wallet\Persister(new Architecture\Wallet\PersisterStorage\Doctrine($connection));
//$persister->persist($wallet);

$userFetcher = new \Domain\User\Fetcher(new \Architecture\User\FetcherStorage\Doctrine($connection));
$user = $userFetcher->findUserByIdentify('m@pilsniak.com');

$userWalletFinder = new \Architecture\Wallet\UserResource\UserWalletFinder(
    new \Domain\User\UserResourceFinder(new \Architecture\User\FinderStorage\Doctrine($connection)),
    new \Domain\Wallet\Fetcher(new \Architecture\Wallet\FetcherStorage\Doctrine($connection)));
$wallets = $userWalletFinder->findWallets($user);
var_dump($wallets);
$wallet = $wallets[0];

//$fetcher = new \Domain\Wallet\Fetcher(new \Architecture\Wallet\FetcherStorage\Doctrine($connection));

//$wallet = $fetcher->findWallets()[0];
//$wallet = $fetcher->findWallet(\Ramsey\Uuid\Uuid::fromString('069fb553-6c89-452d-a601-2f51375506be'));

foreach ($wallet->getTransactions() as $i => $transaction) {
    $numTransaction = $i+1;

    echo "--- {$numTransaction}. transaction # " . $transaction->id() . " ---\n";
    echo "Profit: " . $transaction->profit($currentValue, $commissionOut) . "\n";
    echo "Bought value: " . $transaction->boughtValue() . "\n";
    echo "Current value: " . $transaction->currentValue($currentValue, $commissionOut) . "\n";
}

echo "--- Summary ---\n";
echo "Profit: " . $wallet->profit($currentValue, $commissionOut) . "\n";
echo "Value: " . $wallet->currentValue($currentValue, $commissionOut) . "\n";

