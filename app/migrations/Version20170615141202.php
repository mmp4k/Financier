<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170615141202 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('CREATE TABLE `gpw_closing_prices` (
  `uuid` BINARY(16) NOT NULL,
  `asset_code` VARCHAR(15) NOT NULL,
  `date` DATE NOT NULL,
  `closing_price` DOUBLE(10,2),
  PRIMARY KEY (`uuid`),
  UNIQUE INDEX `asset_date` (`asset_code` ASC, `date` ASC));');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE `gpw_closing_prices`;');
    }
}
