<?php

$currentValue = 94.9;
$commissionOut = 5.0;

include 'vendor/autoload.php';

$wallet = new \App\ETFSP500\Wallet();

$transaction = new \App\ETFSP500\WalletTransaction(
    DateTime::createFromFormat('d.m.Y', '10.04.2017'),
        8, 96.7, 5.0);
$wallet->addTransaction($transaction);

echo "--- First transaction ---\n";
echo "Profit: " . $transaction->profit($currentValue, $commissionOut) . "\n";
echo "Bought value: " . $transaction->boughtValue() . "\n";
echo "Current value: " . $transaction->currentValue($currentValue, $commissionOut) . "\n";

$transaction = new \App\ETFSP500\WalletTransaction(
    DateTime::createFromFormat('d.m.Y', '19.04.2017'),
    9, 95.0, 5.0
);
$wallet->addTransaction($transaction);

echo "--- Second transaction ---\n";
echo "Profit: " . $transaction->profit($currentValue, $commissionOut) . "\n";
echo "Bought value: " . $transaction->boughtValue() . "\n";
echo "Current value: " . $transaction->currentValue($currentValue, $commissionOut) . "\n";

$transaction = new \App\ETFSP500\WalletTransaction(
    DateTime::createFromFormat('d.m.Y', '12.05.2017'),
    13, 94.9, 5.0
);
$wallet->addTransaction($transaction);

echo "--- Third transaction ---\n";
echo "Profit: " . $transaction->profit($currentValue, $commissionOut) . "\n";
echo "Bought value: " . $transaction->boughtValue() . "\n";
echo "Current value: " . $transaction->currentValue($currentValue, $commissionOut) . "\n";

echo "--- Summary ---\n";
echo "Profit: " . $wallet->profit($currentValue, $commissionOut) . "\n";
echo "Value: " . $wallet->currentValue($currentValue, $commissionOut) . "\n";

