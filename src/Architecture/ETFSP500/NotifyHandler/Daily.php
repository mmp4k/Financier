<?php

namespace Architecture\ETFSP500\NotifyHandler;

use Domain\ETFSP500\BusinessDay;
use Domain\ETFSP500\Storage;
use Domain\ETFSP500\Wallet;
use Domain\NotifierRule;
use Domain\NotifyHandler;

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
        $businessDay = new BusinessDay(new \DateTime());

        $body = 'Bought assets: ' . $this->wallet->boughtAssets() . "\n";
        $body .= 'Value of assets: ' . $this->wallet->boughtValue() . "\n";
        $body .= 'Spent money: ' . $this->wallet->valueOfInvestment() . "\n";
        $body .= 'Current value: ' . $this->wallet->currentValue($this->storage->getCurrentValue($businessDay), 5.0) . "\n";
        $body .= 'Profit: ' . $this->wallet->profit($this->storage->getCurrentValue($businessDay), 5.0);

        return $body;
    }

    public function isSupported(NotifierRule $notifierRule)
    {
        return get_class($notifierRule) === \Domain\ETFSP500\NotifierRule\Daily::class;
    }
}