<?php

namespace App;

use Domain\ETFSP500\BusinessDay;
use Domain\ETFSP500\NotifierRule\LessThan;
use Domain\ETFSP500\Storage;
use Domain\Notifier\Persister;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Field\AbstractField;
use Youshido\GraphQL\Type\AbstractType;
use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\BooleanType;
use Youshido\GraphQL\Type\Scalar\IntType;

class CreateETFSP500LessThanNotificationField extends AbstractField
{
    /**
     * @var Storage
     */
    private $storage;
    /**
     * @var BusinessDay
     */
    private $businessDay;
    /**
     * @var Persister
     */
    private $persister;

    public function __construct(Storage $storage, BusinessDay $businessDay, Persister $persister, array $config = [])
    {
        parent::__construct($config);

        $this->addArgument(LessThan::CONFIG_MIN_VALUE, new IntType());
        $this->storage = $storage;
        $this->businessDay = $businessDay;
        $this->persister = $persister;
    }

    /**
     * @return AbstractObjectType|AbstractType
     */
    public function getType()
    {
        return new BooleanType();
    }


    public function resolve($value, array $args, ResolveInfo $info)
    {
        try {
            $lessThan = new LessThan($this->storage, $args[LessThan::CONFIG_MIN_VALUE], $this->businessDay);

            $this->persister->persist($lessThan);

            return true;
        }
        catch (\Exception $e) {
            return false;
        }
    }
}