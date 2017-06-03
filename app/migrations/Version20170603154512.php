<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170603154512 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('CREATE TABLE `user_resource` (
  `user` BINARY(16) NOT NULL,
  `resource` BINARY(16) NOT NULL,
  `type` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`user`, `resource`, `type`));');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('drop table `user_resource`');
    }
}
