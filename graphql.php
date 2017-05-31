<?php

namespace AppGraphQL;

use App\AbcField;
use App\CreateETFSP500LessThanNotificationField;
use App\CurrentSharePriceField;
use App\NotificationsField;
use Architecture\ETFSP500\Storage\Doctrine;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Domain\ETFSP500\BusinessDay;
use Domain\ETFSP500\NotifierRule\Factory\Daily;
use Domain\ETFSP500\NotifierRule\Factory\LessThanAverage;
use Domain\ETFSP500\NotifierRule\LessThan;
use Domain\Notifier\Fetcher;
use Domain\Notifier\Persister;
use Youshido\GraphQL\Execution\Processor;
use Youshido\GraphQL\Schema\Schema;
use Youshido\GraphQL\Type\NonNullType;
use Youshido\GraphQL\Type\Object\ObjectType;
use Youshido\GraphQL\Type\Scalar\BooleanType;
use Youshido\GraphQL\Type\Scalar\FloatType;
use Youshido\GraphQL\Type\Scalar\IntType;

include 'vendor/autoload.php';
$config = include 'config.php';

$connection = DriverManager::getConnection($config['database'], new Configuration());

$storage = new Doctrine($connection);
$businessDay = new BusinessDay(new \DateTime());
$persister = new Persister(new \Architecture\Notifier\PersisterStorage\Doctrine($config['database']));

$currentSharePrice = new CurrentSharePriceField();
$currentSharePrice->setStorage($storage);

$notifierLessThan = new CreateETFSP500LessThanNotificationField($storage, $businessDay, $persister);

$fetcher = new Fetcher(new \Architecture\Notifier\FetcherStorage\Doctrine($connection), $storage);
$notifications = new NotificationsField($fetcher);
$fetcher->addFactory(new Daily());
$fetcher->addFactory(new \Domain\ETFSP500\NotifierRule\Factory\LessThan($storage, $businessDay));
$fetcher->addFactory(new LessThanAverage($storage, $businessDay));

$processor = new Processor(new Schema([
    'mutation' => new ObjectType([
        'name' => 'RootMutationType',
        'fields' => [
            'CreateETFSP500LessThanNotification2' => [
                'type' => new BooleanType(),
                'args' => [
                    LessThan::CONFIG_MIN_VALUE => new NonNullType(new IntType())
                ],
                'resolve' => function() {
                    return true;
                },
            ],
            $notifierLessThan,
        ]
    ]),
    'query' => new ObjectType([
        'name' => 'RootQueryType',
        'fields' => [
            $notifications,
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