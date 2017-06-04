<?php

namespace App;

use Youshido\GraphQL\Config\Object\ObjectTypeConfig;
use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\FloatType;

class WalletType extends AbstractObjectType
{
    /**
     * @param ObjectTypeConfig $config
     */
    public function build($config)
    {
        $config->addField('profit', new FloatType());
    }
}
