<?php

namespace App;

use Youshido\GraphQL\Config\Object\ObjectTypeConfig;
use Youshido\GraphQL\Type\ListType\ListType;
use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\StringType;

class UserType extends AbstractObjectType
{
    /**
     * @param ObjectTypeConfig $config
     */
    public function build($config)
    {
        $config->addField('identify', new StringType());
        $config->addField('uuid', new StringType());
        $config->addField('wallets', new ListType(new WalletType()));
    }
}
