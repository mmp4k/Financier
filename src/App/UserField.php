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
        $this->userWalletFinder = $userWalletFinder;
        $this->userFetcher = $userFetcher;
        parent::__construct([]);
        $this->addArgument('identify', new NonNullType(new StringType()));
    }

    /**
     * @return AbstractObjectType|AbstractType
     */
    public function getType()
    {
        return new UserType($this->userWalletFinder);
    }

    public function resolve($value, array $args, ResolveInfo $info)
    {
        $user = $this->userFetcher->findUserByIdentify($args['identify']);

        return $user;
    }
}
