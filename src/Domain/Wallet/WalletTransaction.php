<?php

namespace Domain\Wallet;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class WalletTransaction
{
    /**
     * @var \DateTime
     */
    private $dateTransaction;
    /**
     * @var int
     */
    private $boughtAssets;
    /**
     * @var float
     */
    private $priceSingleAsset;
    /**
     * @var float
     */
    private $commissionIn;

    /**
     * @var Asset
     */
    private $asset;

    /**
     * @var UuidInterface
     */
    private $uuid;

    public function __construct(Asset $asset, \DateTime $dateTransaction, int $boughtAssets, float $priceSingleAsset, float $commissionIn)
    {
        $this->dateTransaction = $dateTransaction;
        $this->boughtAssets = $boughtAssets;
        $this->priceSingleAsset = $priceSingleAsset;
        $this->commissionIn = $commissionIn;
        $this->asset = $asset;
        $this->uuid = Uuid::uuid4();
    }

    public function date() : \DateTime
    {
        return $this->dateTransaction;
    }

    public function assets() : int
    {
        return $this->boughtAssets;
    }

    public function priceSingleAsset() : float
    {
        return $this->priceSingleAsset;
    }

    public function valueOfInvestment() : float
    {
        return $this->assets() * $this->priceSingleAsset + $this->commissionIn();
    }

    public function boughtValue() : float
    {
        return $this->assets() * $this->priceSingleAsset;
    }

    public function commissionIn() : float
    {
        return $this->commissionIn;
    }

    /**
     * @param float $currentPriceOfSingleAsset
     * @param float $commissionOut
     * @return float percent of change
     */
    public function profit(float $currentPriceOfSingleAsset, float $commissionOut) : float
    {
        $currentValue = $this->currentValue($currentPriceOfSingleAsset, $commissionOut);

        return number_format($currentValue/$this->boughtValue(), 4);
    }

    public function currentValue(float $currentPriceOfSingleAsset, float $commissionOut) : float
    {
        return $this->assets() * $currentPriceOfSingleAsset - $commissionOut - $this->commissionIn();
    }

    public function assetName()
    {
        return $this->asset->getName();
    }

    public function id()
    {
        return $this->uuid;
    }

    /**
     * @param UuidInterface $uuid
     *
     * @return $this
     */
    public function setUuid(UuidInterface $uuid)
    {
        $this->uuid = $uuid;

        return $this;
    }
}
