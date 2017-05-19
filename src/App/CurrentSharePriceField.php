<?php

namespace App;

use Domain\ETFSP500\BusinessDay;
use Domain\ETFSP500\Storage;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Field\AbstractField;
use Youshido\GraphQL\Type\AbstractType;
use Youshido\GraphQL\Type\Object\AbstractObjectType;

class CurrentSharePriceField extends AbstractField
{
    /**
     * @var Storage
     */
    private $storage;

    /**
     * @param Storage $storage
     */
    public function setStorage(Storage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @return AbstractObjectType|AbstractType
     */
    public function getType()
    {
        return new CurrentSharePriceType();
    }

    /**
     * @inheritdoc
     */
    public function resolve($value, array $args, ResolveInfo $info)
    {
        $businessDay = new BusinessDay(new \DateTime());

        return [
            'value' => $this->storage->getCurrentValue($businessDay),
            'business_day' => $businessDay->isBusinessDay(),
        ];
    }
}