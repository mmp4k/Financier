<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170603154926 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('CREATE TABLE `user` (
  `uuid` BINARY(16) NOT NULL,
  `identify` VARCHAR(255) NULL,
  PRIMARY KEY (`uuid`),
  UNIQUE INDEX `identify_UNIQUE` (`identify` ASC));');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('drop table `user`');
    }
}
