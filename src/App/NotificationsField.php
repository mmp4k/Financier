<?php

namespace App;

use Domain\Notifier\Fetcher;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Field\AbstractField;
use Youshido\GraphQL\Type\AbstractType;
use Youshido\GraphQL\Type\Enum\EnumType;
use Youshido\GraphQL\Type\ListType\ListType;
use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\StringType;

class NotificationsField extends AbstractField
{
    /**
     * @var Fetcher
     */
    private $fetcher;

    public function __construct(Fetcher $fetcher, array $config = [])
    {
        parent::__construct($config);
        $this->fetcher = $fetcher;
        $this->addArgument('type', new EnumType(['name' => 'TestEnumType', 'values' => [
            ['name' => 'Daily', 'value' => 'Daily'],
            ['name' => 'LessThan', 'value' => 'LessThan'],
            ['name' => 'LessThanAverage', 'value' => 'LessThanAverage'],
            ]
        ]));
    }

    /**
     * @return AbstractObjectType|AbstractType
     */
    public function getType()
    {
        return new ListType(new NotificationType());
    }

    public function resolve($value, array $args, ResolveInfo $info)
    {
        $names = [];

        foreach ($this->fetcher->getNotifierRules() as $i => $rule) {
            if (isset($args['type']) && strpos(get_class($rule), $args['type'], -1 * (strlen($args['type']))) === false) {
                continue;
            }

            $names[$i]['name'] = get_class($rule);
            $names[$i]['config'] = json_encode($rule->persistConfig());
        }
        return $names;
    }
}