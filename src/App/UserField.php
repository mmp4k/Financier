<?php

namespace App;

use Architecture\Wallet\UserResource\UserWalletFinder;
use Domain\User\Fetcher;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Field\AbstractField;
use Youshido\GraphQL\Type\AbstractType;
use Youshido\GraphQL\Type\NonNullType;
use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\StringType;

class UserField extends AbstractField
{
    /**
     * @var Fetcher
     */
    private $userFetcher;
    /**
     * @var UserWalletFinder
     */
    private $userWalletFinder;

    public function __construct(Fetcher $userFetcher, UserWalletFinder $userWalletFinder)
    {
        parent::__construct([]);
        $this->userFetcher = $userFetcher;
        $this->addArgument('identify', new NonNullType(new StringType()));
        $this->userWalletFinder = $userWalletFinder;
    }

    /**
     * @return AbstractObjectType|AbstractType
     */
    public function getType()
    {
        return new UserType();
    }

    public function resolve($value, array $args, ResolveInfo $info)
    {
        $user = $this->userFetcher->findUserByIdentify($args['identify']);
        $wallets = [];

        $currentValue = '100';

        foreach ($this->userWalletFinder->findWallets($user) as $wallet) {
            $wallets[] = [
                'profit' => $wallet->profit($currentValue, 5.0)
            ];
        }

        return [
            'identify' => $user->identifier(),
            'uuid' => $user->id()->toString(),
            'wallets' => $wallets,
        ];
    }
}
