<?php

$currentValue = 94.9;
$commissionOut = 5.0;

include_once 'vendor/autoload.php';

/** @var \Domain\ETFSP500\Wallet $wallet */
$wallet = include 'transactions.php';

foreach ($wallet->getTransactions() as $i => $transaction) {
    $numTransaction = $i+1;

    echo "--- {$numTransaction}. transaction ---\n";
    echo "Profit: " . $transaction->profit($currentValue, $commissionOut) . "\n";
    echo "Bought value: " . $transaction->boughtValue() . "\n";
    echo "Current value: " . $transaction->currentValue($currentValue, $commissionOut) . "\n";
}

echo "--- Summary ---\n";
echo "Profit: " . $wallet->profit($currentValue, $commissionOut) . "\n";
echo "Value: " . $wallet->currentValue($currentValue, $commissionOut) . "\n";

