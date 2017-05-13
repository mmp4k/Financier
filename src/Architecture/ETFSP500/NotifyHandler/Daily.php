<?php

namespace Architecture\ETFSP500\NotifyHandler;

use App\ETFSP500\Storage;
use App\ETFSP500\Wallet;
use App\NotifierRule;
use App\NotifyHandler;

class Daily implements NotifyHandler
{
    /**
     * @var Wallet
     */
    private $wallet;

    /**
     * @var Storage
     */
    private $storage;

    public function __construct(Wallet $wallet, Storage $storage)
    {
        $this->wallet = $wallet;
        $this->storage = $storage;
    }

    public function prepareBody(NotifierRule $notifierRule)
    {
        $body = 'Bought assets: ' . $this->wallet->boughtAssets() . "\n";
        $body .= 'Value of assets: ' . $this->wallet->boughtValue() . "\n";
        $body .= 'Spent money: ' . $this->wallet->valueOfInvestment() . "\n";
        $body .= 'Current value: ' . $this->wallet->currentValue($this->storage->getCurrentValue(), 5.0) . "\n";
        $body .= 'Profit: ' . $this->wallet->profit($this->storage->getCurrentValue(), 5.0);

        return $body;
    }

    public function isSupported(NotifierRule $notifierRule)
    {
        return get_class($notifierRule) === \App\ETFSP500\NotifierRule\Daily::class;
    }
}