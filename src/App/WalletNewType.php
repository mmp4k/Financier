<?php

namespace App;

use App\Resolver\WalletNewTypeResolver;
use Architecture\Wallet\UserResource\UserWallet;
use Domain\Wallet\WalletTransaction;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class WalletNewType extends ObjectType
{
    static private $instance = null;

    /**
     * @var WalletNewTypeResolver
     */
    private $resolver;

    static public function instance(WalletNewTypeResolver $resolver = null)
    {
        $instance = self::$instance ?: (self::$instance = new WalletNewType());

        if ($resolver) {
            $instance->setResolver($resolver);
        }

        return $instance;
    }

    public function setResolver(WalletNewTypeResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    public function __construct()
    {
        $config = [
            'fields' => function() {
                return [
                    'id' => [
                        'type' => Type::string(),
                        'resolve' => function(UserWallet $wallet) {
                            return $wallet->id()->toString();
                        }
                    ],
                    'transactions' => [
                        'type' => Type::listOf(new ObjectType([
                            'name' => 'transaction',
                            'fields' => [
                                'date' => [
                                    'type' => Type::string(),
                                    'resolve' => function(WalletTransaction $transaction) {
                                        return $transaction->date()->format('d.m.Y');
                                    }
                                ],
                                'name' => [
                                    'type' => Type::string(),
                                    'resolve' => function(WalletTransaction $transaction) {
                                        return $transaction->assetName();
                                    }
                                ]
                            ]
                        ])),
                        'resolve' => function(UserWallet $wallet) {
                            return $wallet->getTransactions();
                        }
                    ],
                    'valueOfInvestment' => [
                        'type' => Type::float(),
                        'resolve' => function(UserWallet $wallet) {
                            return $wallet->valueOfInvestment();
                        }
                    ],
                    'currentValue' => [
                        'type' => Type::float(),
                        'args' => [
                            'commission' => Type::float()
                        ],
                        'resolve' => function (UserWallet $wallet, $args) {
                            $commission = isset($args['commission']) ? $args['commission'] : 0;
                            return $wallet->currentValue($this->resolver->getCurrentETFSP500Value(), $commission);
                        }
                    ],
                    'profit' => [
                        'type' => Type::float(),
                        'args' => [
                            'commission' => Type::float()
                        ],
                        'resolve' => function (UserWallet $wallet, $args) {
                            $commission = isset($args['commission']) ? $args['commission'] : 0;
                            return $wallet->profit($this->resolver->getCurrentETFSP500Value(), $commission);
                        }
                    ],
                    'user' => [
                        'type' => UserNewType::instance(),
                        'resolve' => function (UserWallet $wallet) {
                            return $wallet->user();
                        }
                    ]
                ];
            }
        ];
        parent::__construct($config);
    }

    public function configArray()
    {
        return [
            'wallet' => [
                'type' => WalletNewType::instance(),
                'args' => [
                    'id' => Type::nonNull(Type::string())
                ],
                'resolve' => function($root, $args) {
                    return $this->resolver->findWallet($args['id']);
                }
            ]
        ];
    }
}