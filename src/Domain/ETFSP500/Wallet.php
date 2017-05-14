<?php

namespace Domain\ETFSP500;

class Wallet
{
    /**
     * @var WalletTransaction[]
     */
    protected $transactions = [];

    public function boughtAssets() : int
    {
        $assets = 0;

        foreach ($this->transactions as $transaction) {
            $assets += $transaction->assets();
        }

        return $assets;
    }

    public function valueOfInvestment() : float
    {
        $value = 0.0;

        foreach ($this->transactions as $transaction) {
            $value += $transaction->valueOfInvestment();
        }

        return $value;
    }

    public function boughtValue() : float
    {
        $value = 0.0;

        foreach ($this->transactions as $transaction) {
            $value += $transaction->boughtValue();
        }

        return $value;
    }

    public function addTransaction(WalletTransaction $transaction) : void
    {
        $this->transactions[] = $transaction;
    }

    public function profit(float $currentPriceOfSingleAsset, float $commissionOut) : float
    {
        $boughtValues = 0;

        foreach ($this->transactions as $transaction) {
            $boughtValues += $transaction->boughtValue();
        }

        return $this->currentValue($currentPriceOfSingleAsset, $commissionOut)/$boughtValues;
    }

    public function currentValue(float $currentPriceOfSingleAsset, float $commissionOut) : float
    {
        $values = 0;

        foreach ($this->transactions as $transaction) {
            $values += $transaction->currentValue($currentPriceOfSingleAsset, $commissionOut/count($this->transactions));
        }

        return $values;
    }

    public function getTransactions()
    {
        $sortedTransactions = $this->transactions; // copy to usort, usort uses reference

        usort($sortedTransactions, function($a, $b) {
            /** @var WalletTransaction $a */
            /** @var WalletTransaction $b */
            return $a->date() > $b->date() ? 1 : -1;
        });

        return $sortedTransactions;
    }
}
