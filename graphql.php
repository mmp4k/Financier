<?php

namespace AppGraphQL;

use App\CurrentSharePriceField;
use Architecture\ETFSP500\Storage\Doctrine;
use Youshido\GraphQL\Execution\Processor;
use Youshido\GraphQL\Schema\Schema;
use Youshido\GraphQL\Type\Object\ObjectType;
use Youshido\GraphQL\Type\Scalar\FloatType;

include 'vendor/autoload.php';
$config = include 'config.php';

$storage = new Doctrine($config['database']);

$currentSharePrice = new CurrentSharePriceField();
$currentSharePrice->setStorage($storage);

$processor = new Processor(new Schema([
    'query' => new ObjectType([
        'name' => 'RootQueryType',
        'fields' => [
            $currentSharePrice,
            'averageSharePriceFromLastTenMonths' => [
                'type' => new FloatType(),
                'resolve' => function() use ($storage) {
                    return $storage->getAverageFromLastTenMonths();
                }
            ]
        ]
    ])
]));

//$processor->processPayload('{ currentSharePrice{value, business_day}, averageSharePriceFromLastTenMonths }');
$requestData = json_decode(file_get_contents('php://input'), true);
$payload   = isset($requestData['query']) ? $requestData['query'] : null;
$variables = isset($requestData['variables']) ? $requestData['variables'] : null;
$processor->processPayload($payload, $variables);
//var_dump(file_get_contents('php://input'));
header('Content-Type: application/json');
echo json_encode($processor->getResponseData()) . "\n";

//echo file_get_contents('php://input');