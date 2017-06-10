<?php

namespace App;

use App\Resolver\TransactionTypeResolver;
use Domain\Wallet\WalletTransaction;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class TransactionType extends ObjectType
{
    static private $instance = null;

    /**
     * @var TransactionTypeResolver
     */
    private $resolver;

    public function setResolver(TransactionTypeResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    static public function instance(TransactionTypeResolver $resolver = null)
    {
        self::$instance = self::$instance ?: new TransactionType();

        if ($resolver) {
            self::$instance->setResolver($resolver);
        }

        return self::$instance;
    }

    public function __construct()
    {
        $config = [
            'fields' => [
                'currentValue' => [
                    'type' => Type::float(),
                    'args' => [
                        'commission' => Type::float()
                    ],
                    'resolve' => function (WalletTransaction $transaction, $args) {
                        $commission = isset($args['commission']) ? $args['commission'] : 0;
                        return $transaction->currentValue($this->resolver->getCurrentETFSP500Value(), $commission);
                    }
                ],
                'valueOfInvestment' => [
                    'type' => Type::float(),
                    'resolve' => function(WalletTransaction $transaction) {
                        return $transaction->valueOfInvestment();
                    }
                ],
                'profit' => [
                    'type' => Type::float(),
                    'args' => [
                        'commission' => Type::float()
                    ],
                    'resolve' => function (WalletTransaction $transaction, $args) {
                        $commission = isset($args['commission']) ? $args['commission'] : 0;
                        return $transaction->profit($this->resolver->getCurrentETFSP500Value(), $commission);
                    }
                ],
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
        ];
        parent::__construct($config);
    }
}