<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170514092930 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('DROP TABLE IF EXISTS `etfsp500_daily_average`;');
        $this->addSql('CREATE TABLE `etfsp500_daily_average` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `average` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1417 DEFAULT CHARSET=utf8;');

        $this->addSql('DROP TABLE IF EXISTS `etfsp500_monthly_average`;');
        $this->addSql('CREATE TABLE `etfsp500_monthly_average` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `month` tinyint(1) NOT NULL,
  `year` mediumint(2) NOT NULL,
  `average` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8;');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE IF EXISTS `etfsp500_daily_average`;');
        $this->addSql('DROP TABLE IF EXISTS `etfsp500_monthly_average`;');
    }
}
