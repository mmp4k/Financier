<?php

namespace App;

use Architecture\Wallet\UserResource\UserWalletFinder;
use Domain\User\User;
use Youshido\GraphQL\Config\Object\ObjectTypeConfig;
use Youshido\GraphQL\Type\ListType\ListType;
use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\StringType;

class UserType extends AbstractObjectType
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
        $config->addField('identifier', new StringType());
        $config->addField('id', new StringType());
        $config->addField('wallets', [
            'type' => new ListType(new WalletType($this->userWalletFinder)),
            'resolve' => function(User $user) {
                $wallets = $this->userWalletFinder->findWallets($user);
                $returnWallets = [];

                foreach ($wallets as $wallet) {
                    $returnWallets[] = [
                        'profit' => $wallet->profit(100, 5.0),
                        'user' => $wallet->user(),
                    ];
                }

                return $returnWallets;
            }
        ]);
    }
}
