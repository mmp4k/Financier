<?php

namespace Domain\ETFSP500\NotifyHandler;

use Domain\ETFSP500\BusinessDay;
use Domain\ETFSP500\Storage;
use Domain\ETFSP500\Wallet;
use Domain\Notifier\NotifierRule;
use Domain\Notifier\NotifyHandler;

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

    /**
     * @var BusinessDay
     */
    private $businessDay;

    public function __construct(Wallet $wallet, Storage $storage, BusinessDay $businessDay)
    {
        $this->wallet = $wallet;
        $this->storage = $storage;
        $this->businessDay = $businessDay;
    }

    public function prepareBody(NotifierRule $notifierRule)
    {
        $body = 'Bought assets: ' . $this->wallet->boughtAssets() . "\n";
        $body .= 'Value of assets: ' . $this->wallet->boughtValue() . "\n";
        $body .= 'Spent money: ' . $this->wallet->valueOfInvestment() . "\n";
        $body .= 'Current value: ' . $this->wallet->currentValue($this->storage->getCurrentValue($this->businessDay), 5.0) . "\n";
        $body .= 'Profit: ' . $this->wallet->profit($this->storage->getCurrentValue($this->businessDay), 5.0);

        return $body;
    }

    public function isSupported(NotifierRule $notifierRule)
    {
        return get_class($notifierRule) === \Domain\ETFSP500\NotifierRule\Daily::class;
    }
}