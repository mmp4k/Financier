<?php

namespace spec\App;

use App\UserField;
use App\UserType;
use Architecture\Wallet\UserResource\UserWallet;
use Architecture\Wallet\UserResource\UserWalletFinder;
use Domain\User\Fetcher;
use Domain\User\User;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Ramsey\Uuid\Uuid;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Field\AbstractField;

class UserFieldSpec extends ObjectBehavior
{
    function let(Fetcher $userFetcher, UserWalletFinder $userWalletFinder)
    {
        $this->beConstructedWith($userFetcher, $userWalletFinder);
        $this->shouldBeAnInstanceOf(AbstractField::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UserField::class);
    }

    function it_is_user_type()
    {
        $this->getType()->shouldBeAnInstanceOf(UserType::class);
    }

    function it_resolves_arguments_to_array(Fetcher $userFetcher, UserWalletFinder $userWalletFinder, ResolveInfo $info, UserWallet $userWallet)
    {
        $userToFind = 'm@p.com';
        $uuid = Uuid::uuid4();

        $user = new User($userToFind);
        $user->setId($uuid);

        $userFetcher->findUserByIdentify($userToFind)->willReturn($user);
        $userFetcher->findUserByIdentify($userToFind)->shouldBeCalled();

        $userWalletFinder->findWallets($user)->willReturn([$userWallet]);
        $userWalletFinder->findWallets($user)->shouldBeCalled();

        $userWallet->profit('100', '5.0')->willReturn(5.12);

        $value = null;
        $args = ['identify' => 'm@p.com'];

        $array = $this->resolve($value, $args, $info);

        $array['identify']->shouldBe($userToFind);
        $array['uuid']->shouldBe($uuid->toString());
        $array['wallets']->shouldBeArray();
        $array['wallets'][0]['profit']->shouldBe(5.12);
    }
}
