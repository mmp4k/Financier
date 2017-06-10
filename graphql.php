<?php

namespace AppGraphQL;

use App\QueryType;
use App\Resolver\UserNewTypeResolver;
use App\Resolver\WalletNewTypeResolver;
use App\Types;
use App\UserNewType;
use App\WalletNewType;
use Architecture\User\FetcherStorage\Doctrine;
use Architecture\Wallet\UserResource\UserWalletFinder;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Domain\User\Fetcher;
use Domain\User\UserResourceFinder;
use GraphQL\GraphQL;
use GraphQL\Schema;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;


include 'vendor/autoload.php';

try {
    $config = include 'config.php';
    $connection = DriverManager::getConnection($config['database'], new Configuration());

    $fetcher = new Fetcher(new Doctrine($connection));

    $finder = new UserWalletFinder(
        new UserResourceFinder(
            new \Architecture\User\FinderStorage\Doctrine($connection)),
        new \Domain\Wallet\Fetcher(
            new \Architecture\Wallet\FetcherStorage\Doctrine($connection)));

    $etfSP500 = new \Architecture\ETFSP500\Storage\Doctrine($connection);

    UserNewType::instance(new UserNewTypeResolver($fetcher, $finder));

    $walletFetcher = new \Domain\Wallet\Fetcher(new \Architecture\Wallet\FetcherStorage\Doctrine($connection));

    WalletNewType::instance(new WalletNewTypeResolver($etfSP500, $walletFetcher, $finder));

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

header('Content-type: application/json;charset=UTF-8');
echo \GuzzleHttp\json_encode($result);