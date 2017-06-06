<?php

namespace App;

use Architecture\Wallet\UserResource\UserWalletFinder;
use Youshido\GraphQL\Config\Object\ObjectTypeConfig;
use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\FloatType;
use Youshido\GraphQL\Type\Scalar\StringType;

class WalletType extends AbstractObjectType
{
    /**
     * @var UserWalletFinder
     */
    private $userWalletFinder;

    public function __construct(UserWalletFinder $userWalletFinder, array $config = [])
    {
        parent::__construct($config);
        $this->userWalletFinder = $userWalletFinder;
    }

    /**
     * @param ObjectTypeConfig $config
     */
    public function build($config)
    {
        $config->addField('profit', new FloatType());
        $config->addField('comment', new StringType());
        $config->addField('user', new UserType($this->userWalletFinder));
    }
}
