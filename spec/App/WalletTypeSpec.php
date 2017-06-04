<?php

namespace spec\App;

use App\WalletType;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Youshido\GraphQL\Config\Object\ObjectTypeConfig;
use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\FloatType;

class WalletTypeSpec extends ObjectBehavior
{
    function let()
    {
        $this->shouldBeAnInstanceOf(AbstractObjectType::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(WalletType::class);
    }

    function it_returns_profit(ObjectTypeConfig $objectTypeConfig)
    {
        $objectTypeConfig->addField('profit', new FloatType());

        $this->build($objectTypeConfig);
    }
}
