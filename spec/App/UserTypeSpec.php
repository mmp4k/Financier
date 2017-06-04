<?php

namespace spec\App;

use App\UserType;
use App\WalletType;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Youshido\GraphQL\Config\Object\ObjectTypeConfig;
use Youshido\GraphQL\Type\ListType\ListType;
use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\StringType;

class UserTypeSpec extends ObjectBehavior
{
    function let()
    {
        $this->shouldBeAnInstanceOf(AbstractObjectType::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UserType::class);
    }

    function it_returns_identify_and_uuid_and_wallets(ObjectTypeConfig $objectTypeConfig)
    {
        $objectTypeConfig->addField('identify', new StringType())->shouldBeCalled();
        $objectTypeConfig->addField('uuid', new StringType())->shouldBeCalled();
        $objectTypeConfig->addField('wallets', new ListType(new WalletType()))->shouldBeCalled();

        $this->build($objectTypeConfig);
    }
}
