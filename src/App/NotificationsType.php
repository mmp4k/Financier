<?php

namespace App;

use App\Resolver\NotificationsTypeResolver;
use Domain\Notifier\NotifierRule;
use Domain\Notifier\PersistableNotifierRule;
use GraphQL\Type\Definition\EnumType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class NotificationsType extends ObjectType
{
    static private $instance = null;

    static public function instance(NotificationsTypeResolver $resolver = null)
    {
        self::$instance = self::$instance ?: new NotificationsType();

        if ($resolver) {
            self::$instance->setResolver($resolver);
        }

        return self::$instance;
    }

    /**
     * @var NotificationsTypeResolver
     */
    private $resolver;

    public function setResolver(NotificationsTypeResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    public function __construct()
    {
        $config = [
            'fields' => [
                'config' => [
                    'type' => Type::string(),
                    'resolve' => function(NotifierRule $rule) {
                        /** @var PersistableNotifierRule|NotifierRule $rule */
                        return json_encode($rule->persistConfig());
                    }
                ],
                'name' => [
                    'type' => Type::string(),
                    'resolve' => function(NotifierRule $rule) {
                        return get_class($rule);
                    }
                ]
            ]
        ];
        parent::__construct($config);
    }

    public function configArray()
    {
        return [
            'notifications' => [
                'type' => Type::listOf(NotificationsType::instance()),
                'args' => [
                    'type' => new EnumType([
                        'name' => 'type',
                        'values' => [
                            'LESS_THAN' => [
                                'value' => 'LessThan',
                            ],
                            'LESS_THAN_AVERAGE' => [
                                'value' => 'LessThanAverage',
                            ],
                            'DAILY' => [
                                'value' => 'Daily',
                            ]
                        ]
                    ])
                ],
                'resolve' => function($root, $args) {
                    $notifications = $this->resolver->getNotifications();
                    if (!isset($args['type'])) {
                        return $notifications;
                    }

                    $toReturn = [];
                    foreach ($this->resolver->getNotifications() as $i => $rule) {
                        if (isset($args['type']) && strpos(get_class($rule), $args['type'], -1 * (strlen($args['type']))) === false) {
                            continue;
                        }

                        $toReturn[] = $rule;
                    }
                    return $toReturn;
                }
            ]
        ];
    }
}