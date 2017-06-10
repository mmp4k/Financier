<?php

namespace App;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

class QueryType extends ObjectType
{
    public function __construct()
    {
        $fields = array_merge(
            UserNewType::instance()->configArray(),
            WalletNewType::instance()->configArray(),
            NotificationsType::instance()->configArray()
        );
        $config = [
            'name' => 'Query',
            'fields' => $fields,

        ];
        return parent::__construct($config);
    }
}