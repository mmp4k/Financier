<?php

namespace Domain\GPW;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class ClosingPrice
{
    /**
     * @var Asset
     */
    private $asset;

    /**
     * @var \DateTime
     */
    private $dateTime;

    /**
     * @var float
     */
    private $price;

    /**
     * @var UuidInterface
     */
    private $uuid;

    /**
     * @param UuidInterface $uuid
     * @param Asset $asset
     * @param \DateTime $dateTime
     * @param float $price
     *
     * @return ClosingPrice
     */
    static public function createWithUuid(UuidInterface $uuid, Asset $asset, \DateTime $dateTime, float $price)
    {
        $self = new self($asset, $dateTime, $price);
        $self->updateUuid($uuid);

        return $self;
    }

    /**
     * @param UuidInterface $uuid
     */
    protected function updateUuid(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @param Asset $asset
     * @param \DateTime $dateTime
     * @param float $price
     */
    public function __construct(Asset $asset, \DateTime $dateTime, float $price)
    {
        $this->asset = $asset;
        $this->dateTime = $dateTime;
        $this->price = $price;
        $this->uuid = Uuid::uuid4();
    }

    /**
     * @return string
     */
    public function asset() : string
    {
        return $this->asset->code();
    }

    /**
     * @return \DateTime
     */
    public function date() : \DateTime
    {
        return $this->dateTime;
    }

    /**
     * @return float
     */
    public function price() : float
    {
        return $this->price;
    }

    /**
     * @return UuidInterface
     */
    public function uuid() : UuidInterface
    {
        return $this->uuid;
    }
}
