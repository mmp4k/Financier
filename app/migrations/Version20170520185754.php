<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170520185754 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('CREATE TABLE notifier_rules (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
`class` VARCHAR(255) NOT NULL,
`options` TEXT NOT NULL
)ENGINE=InnoDB;
');

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('DROP table notifier_rules');
    }
}
