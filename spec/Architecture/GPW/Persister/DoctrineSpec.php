<?php

namespace spec\Architecture\GPW\Persister;

use Architecture\GPW\Persister\Doctrine;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Domain\GPW\ClosingPrice;
use Domain\GPW\Fetcher;
use Domain\GPW\Persister\PersistStorage;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DoctrineSpec extends ObjectBehavior
{
    function let(Connection $connection, Fetcher $fetcher, QueryBuilder $queryBuilder)
    {
        $connection->createQueryBuilder()->willReturn($queryBuilder);
        $queryBuilder->insert(Argument::any())->willReturn($queryBuilder);
        $queryBuilder->values(Argument::any())->willReturn($queryBuilder);
        $queryBuilder->setParameters(Argument::any())->willReturn($queryBuilder);
        $queryBuilder->execute(Argument::any())->willReturn($queryBuilder);

        $this->beConstructedWith($connection, $fetcher);
        $this->shouldImplement(PersistStorage::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Doctrine::class);
    }

    function it_persists_closing_price(ClosingPrice $closingPrice, Fetcher $fetcher)
    {
        $closingPrice->asset()->shouldBeCalled();
        $closingPrice->uuid()->shouldBeCalled();
        $closingPrice->price()->shouldBeCalled();
        $closingPrice->date()->shouldBeCalled();

        $fetcher->findDuplicate($closingPrice)->shouldBeCalled();
        $fetcher->findDuplicate($closingPrice)->willReturn(false);

        $this->persist($closingPrice);
    }

    function it_does_not_persist_if_exists(QueryBuilder $queryBuilder, ClosingPrice $closingPrice, Fetcher $fetcher)
    {
        $fetcher->findDuplicate($closingPrice)->shouldBeCalled();
        $fetcher->findDuplicate($closingPrice)->willReturn(true);

        $queryBuilder->insert(Argument::any())->shouldNotBeCalled();

        $this->persist($closingPrice);
    }
}
