<?php

namespace App;

use App\Resolver\UserNewTypeResolver;
use Architecture\Notifier\UserResource\UserNotifierRule;
use Architecture\Wallet\UserResource\UserWallet;
use Domain\User\User;
use Domain\Wallet\Wallet;
use Domain\Wallet\WalletTransaction;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class UserNewType extends ObjectType
{
    static private $instance = null;

    /**
     * @var UserNewTypeResolver
     */
    private $resolver;

    static public function instance(UserNewTypeResolver $resolver = null)
    {
        $instance = self::$instance ?: (self::$instance = new UserNewType());

        if ($resolver) {
            $instance->setResolver($resolver);
        }

        return $instance;
    }

    public function setResolver(UserNewTypeResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    public function __construct()
    {
        $config = [
            'fields' => [
                'notifications' => [
                    'type' => Type::listOf(new ObjectType([
                        'name' => 'notification',
                        'fields' => [
                            'id' => [
                                'type' => Type::string(),
                                'resolve' => function(UserNotifierRule $rule) {
                                    return $rule->id();
                                }
                            ],
                            'type' => [
                                'type' => Type::string(),
                                'resolve' => function(UserNotifierRule $rule) {
                                    return $rule->getType();
                                }
                            ]
                        ]
                    ])),
                    'resolve' => function (User $user) {
                        return $this->resolver->findNotifications($user);
                    }
                ],
                'identifier' => [
                    'type' => Type::string(),
                    'resolve' => function (User $user) {
                        return $user->identifier();
                    }
                ],
                'id' => [
                    'type' => Type::string(),
                    'resolve' => function (User $user) {
                        return $user->id();
                    }
                ],
                'wallets' => [
                    'type' => Type::listOf(WalletNewType::instance()),
                    'resolve' => function(User $user) {
                        return $this->resolver->findUserWallets($user);
                    }
                ],
            ]
        ];
        return parent::__construct($config);
    }

    public function configArray()
    {
        return ['user' =>
            [
                'type' => UserNewType::instance(),
                'args' => [
                    'email' => Type::nonNull(Type::string())
                ],
                'resolve' => function ($root, $args) {
                    return $this->resolver->findUser($args['email']);
                }
            ]
        ];
    }
}