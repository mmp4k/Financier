<?php

namespace Domain\GPW\NotifierRule;

use Domain\GPW\Asset;
use Domain\Notifier\NotifierRule;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class LessThan implements NotifierRule
{
    const MIN_VALUE = 'minValue';
    const ASSET_NAME = 'assetName';

    /**
     * @var Asset
     */
    private $asset;

    /**
     * @var float
     */
    private $minValue;

    /**
     * @var UuidInterface
     */
    private $uuid;

    public function __construct(Asset $asset, float $minValue)
    {
        $this->uuid = Uuid::uuid4();
        $this->asset = $asset;
        $this->minValue = $minValue;
    }

    public function id(): UuidInterface
    {
        return $this->uuid;
    }

    public function setId(UuidInterface $id)
    {
        $this->uuid = $id;
    }

    public function persistConfig(): array
    {
        return [
            self::MIN_VALUE => $this->minValue,
            self::ASSET_NAME => $this->asset->code(),
        ];
    }

    public function minValue()
    {
        return $this->minValue;
    }

    public function asset()
    {
        return $this->asset;
    }
}
