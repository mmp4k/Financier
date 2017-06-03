<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170603103536 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('CREATE TABLE `wallet_transaction` (
  `uuid` BINARY(16) NOT NULL,
  `wallet_uuid` BINARY(16) NULL,
  `asset` VARCHAR(10) NULL,
  `commission_in` DECIMAL(5,3) NULL,
  `date` DATE NULL,
  `price_single_asset` DECIMAL(10,5) NULL,
  `bought_assets` INT NULL,
  PRIMARY KEY (`uuid`));');

        $this->addSql('CREATE TABLE `wallet` (
  `uuid` binary(16) NOT NULL,
  PRIMARY KEY (`uuid`)
) ENGINE=InnoDB');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('drop table `wallet_transaction`');
        $this->addSql('drop table `wallet`');
    }
}
