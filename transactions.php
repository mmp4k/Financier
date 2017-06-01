<?php

include_once 'vendor/autoload.php';

$wallet = new \Domain\Wallet\Wallet();

$transaction = new \Domain\Wallet\WalletTransaction(
    new \Domain\ETFSP500\ETFSP500(),
    DateTime::createFromFormat('d.m.Y', '10.04.2017'),
    8, 96.7, 5.0);
$wallet->addTransaction($transaction);

$transaction = new \Domain\Wallet\WalletTransaction(
    new \Domain\ETFSP500\ETFSP500(),
    DateTime::createFromFormat('d.m.Y', '19.04.2017'),
    9, 95.0, 5.0
);
$wallet->addTransaction($transaction);

$transaction = new \Domain\Wallet\WalletTransaction(
    new \Domain\ETFSP500\ETFSP500(),
    DateTime::createFromFormat('d.m.Y', '12.05.2017'),
    13, 94.9, 5.0
);
$wallet->addTransaction($transaction);

return $wallet;