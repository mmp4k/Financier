<?php

namespace AppGraphQL;

use App\NotificationsType;
use App\QueryType;
use App\Resolver\NotificationsTypeResolver;
use App\Resolver\TransactionTypeResolver;
use App\Resolver\UserNewTypeResolver;
use App\Resolver\WalletNewTypeResolver;
use App\TransactionType;
use App\Types;
use App\UserNewType;
use App\WalletNewType;
use Architecture\Notifier\UserResource\UserNotifierFinder;
use Architecture\User\FetcherStorage\Doctrine;
use Architecture\Wallet\UserResource\UserWalletFinder;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Domain\ETFSP500\BusinessDay;
use Domain\ETFSP500\NotifierRule\Factory\LessThan;
use Domain\ETFSP500\NotifierRule\Factory\LessThanAverage;
use Domain\User\Fetcher;
use Domain\User\UserResourceFinder;
use Domain\Wallet\NotifierRule\Factory\Daily;
use GraphQL\GraphQL;
use GraphQL\Schema;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;


include 'vendor/autoload.php';

try {
    $config = include 'config.php';
    $connection = DriverManager::getConnection($config['database'], new Configuration());

    $fetcher = new Fetcher(new Doctrine($connection));

    $etfSP500 = new \Architecture\ETFSP500\Storage\Doctrine($connection);

    $notifyFetcher = new \Domain\Notifier\Fetcher(new \Architecture\Notifier\FetcherStorage\Doctrine($connection), $etfSP500);
    $notifyFetcher->addFactory(new LessThan($etfSP500, new BusinessDay(new \DateTime())));
    $notifyFetcher->addFactory(new LessThanAverage($etfSP500, new BusinessDay(new \DateTime())));
    $notifyFetcher->addFactory(new Daily());

    $finderWallet = new UserWalletFinder(
        new UserResourceFinder(
            new \Architecture\User\FinderStorage\Doctrine($connection)),
        new \Domain\Wallet\Fetcher(
            new \Architecture\Wallet\FetcherStorage\Doctrine($connection)));

    $finderNotifierRules = new UserNotifierFinder(
        new UserResourceFinder(new \Architecture\User\FinderStorage\Doctrine($connection)),
        $notifyFetcher);


    UserNewType::instance(new UserNewTypeResolver($fetcher, $finderWallet, $finderNotifierRules));

    $walletFetcher = new \Domain\Wallet\Fetcher(new \Architecture\Wallet\FetcherStorage\Doctrine($connection));

    WalletNewType::instance(new WalletNewTypeResolver($etfSP500, $walletFetcher, $finderWallet));

    TransactionType::instance(new TransactionTypeResolver($etfSP500));

    NotificationsType::instance(new NotificationsTypeResolver($notifyFetcher));

    $schema = new Schema([
        'query' => new QueryType(),
        'mutation' => null,
    ]);

    $rawInput = file_get_contents('php://input');
    $input = json_decode($rawInput, true);
    $query = $input['query'];
    $variableValues = isset($input['variables']) ? $input['variables'] : null;
    $result = GraphQL::execute($schema, $query, null, null, $variableValues);

} catch (\Exception $e) {
    $result = [
        'error' => [
            'message' => $e->getMessage(),
        ]
    ];
}
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST,GET');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
//header('Content-type: application/json;charset=UTF-8');
echo \GuzzleHttp\json_encode($result);