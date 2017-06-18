<?php

namespace Domain\GPW\NotifierRule;

use Domain\GPW\Asset;
use Domain\Notifier\NotifierRule;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class LessThanAverage implements NotifierRule
{
    const ASSET_NAME = 'assetName';

    /**
     * @var Asset
     */
    private $asset;

    /**
     * @var UuidInterface
     */
    private $uuid;

    public function __construct(Asset $asset)
    {
        $this->asset = $asset;
        $this->uuid = Uuid::uuid4();
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
            self::ASSET_NAME => $this->asset->code(),
        ];
    }

    public function asset() : Asset
    {
        return $this->asset;
    }
}
