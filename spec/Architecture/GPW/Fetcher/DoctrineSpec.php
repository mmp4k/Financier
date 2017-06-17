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
        $queryBuilder->orderBy(Argument::any(), Argument::any())->willReturn($queryBuilder);
        $queryBuilder->setMaxResults(Argument::any())->willReturn($queryBuilder);
        $queryBuilder->execute()->willReturn($statement);

        $this->beConstructedWith($connection);
        $this->shouldImplement(FetchStorage::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Doctrine::class);
    }

    function it_finds_by_asset_and_date(Statement $statement, \DateTime $date)
    {
        $uuid = Uuid::uuid4();
        $assetName = 'ETFSP500';

        $date->format('z')->willReturn(133);
        $date->format('N')->willReturn(5);
        $date->format('Y-m-d')->willReturn('2015-07-06');

        $statement->fetch()->willReturn([
            'uuid' => $uuid->getBytes(),
            'asset_code' => $assetName,
            'date' => '2015-07-06',
            'closing_price' => '2.15',
        ]);

        $closingPrice = $this->findByAssetAndDate($assetName, $date);

        $closingPrice->shouldBeAnInstanceOf(ClosingPrice::class);
        $closingPrice->date()->format('Y-m-d')->shouldBe('2015-07-06');
        $closingPrice->asset()->shouldBe($assetName);
        $closingPrice->price()->shouldBe(2.15);
        $closingPrice->uuid()->getBytes()->shouldBe($uuid->getBytes());
    }

    function it_finds_last_asset_if_bussiness_day(Statement $statement, \DateTime $date)
    {
        $uuid = Uuid::uuid4();
        $assetName = 'ETFSP500';

        $date->format('z')->willReturn(133);
        $date->format('N')->willReturn(7);
        $date->format('Y-m-d')->willReturn('2015-07-06');

        $statement->fetch()->willReturn([
            'uuid' => $uuid->getBytes(),
            'asset_code' => $assetName,
            'date' => '2015-07-06',
            'closing_price' => '2.15',
        ]);

        $closingPrice = $this->findByAssetAndDate($assetName, $date);

        $closingPrice->shouldBeAnInstanceOf(ClosingPrice::class);
        $closingPrice->date()->format('Y-m-d')->shouldBe('2015-07-06');
        $closingPrice->asset()->shouldBe($assetName);
        $closingPrice->price()->shouldBe(2.15);
        $closingPrice->uuid()->getBytes()->shouldBe($uuid->getBytes());
    }
}
