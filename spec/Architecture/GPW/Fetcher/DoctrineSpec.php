<?php

namespace spec\Architecture\GPW\Fetcher;

use Architecture\GPW\Fetcher\Doctrine;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\Statement;
use Domain\GPW\ClosingPrice;
use Domain\GPW\Fetcher\FetchStorage;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Ramsey\Uuid\Uuid;

class DoctrineSpec extends ObjectBehavior
{
    function let(Connection $connection, QueryBuilder $queryBuilder, Statement $statement)
    {
        $connection->createQueryBuilder()->willReturn($queryBuilder);
        $queryBuilder->select(Argument::any())->willReturn($queryBuilder);
        $queryBuilder->from(Argument::any())->willReturn($queryBuilder);
        $queryBuilder->where(Argument::any())->willReturn($queryBuilder);
        $queryBuilder->setParameters(Argument::any())->willReturn($queryBuilder);
        $queryBuilder->execute()->willReturn($statement);

        $this->beConstructedWith($connection);
        $this->shouldImplement(FetchStorage::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Doctrine::class);
    }

    function it_finds_by_asset_and_date(Statement $statement)
    {
        $uuid = Uuid::uuid4();
        $assetName = 'ETFSP500';
        $date = new \DateTime();

        $statement->fetch()->willReturn([
            'uuid' => $uuid->getBytes(),
            'asset_code' => $assetName,
            'date' => $date->format('Y-m-d'),
            'closing_price' => '2.15',
        ]);

        $closingPrice = $this->findByAssetAndDate($assetName, $date);

        $closingPrice->shouldBeAnInstanceOf(ClosingPrice::class);
        $closingPrice->date()->format('Y-m-d')->shouldBe($date->format('Y-m-d'));
        $closingPrice->asset()->shouldBe($assetName);
        $closingPrice->price()->shouldBe(2.15);
        $closingPrice->uuid()->getBytes()->shouldBe($uuid->getBytes());
    }
}
