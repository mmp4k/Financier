<?php

namespace Architecture\Wallet\UserResource;

use Domain\User\User;
use Domain\User\UserResource;
use Domain\Wallet\Wallet;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UserWallet implements UserResource
{
    /**
     * @var Wallet
     */
    private $wallet;

    /**
     * @var UuidInterface
     */
    private $id;

    /**
     * @var User
     */
    private $user;

    public function __construct(Wallet $wallet, User $user)
    {
        $this->wallet = $wallet;
        $this->id = $wallet->id();
        $this->user = $user;
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function resourceType(): string
    {
        return get_class($this);
    }

    public function user(): User
    {
        return $this->user;
    }

    public function getTransactions()
    {
        return $this->wallet->getTransactions();
    }

    public function profit(float $currentPriceOfSingleAsset, float $commissionOut)
    {
        return $this->wallet->profit($currentPriceOfSingleAsset, $commissionOut);
    }

    public function currentValue(float $currentPriceOfSingleAsset, float $commissionOut) : float
    {
        return $this->wallet->currentValue($currentPriceOfSingleAsset, $commissionOut);
    }
}
