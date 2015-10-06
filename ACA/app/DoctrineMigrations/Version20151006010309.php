<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151006010309 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE bid (id INT AUTO_INCREMENT NOT NULL, userid INT NOT NULL, houseid INT NOT NULL, bidamount INT NOT NULL, biddate DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE house DROP bath_number, CHANGE zipcode zipcode VARCHAR(255) NOT NULL, CHANGE main_image main_image VARCHAR(255) NOT NULL, CHANGE bed_number bed_number VARCHAR(255) NOT NULL, CHANGE extras extras VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user DROP authkey, DROP password');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE bid');
        $this->addSql('ALTER TABLE house ADD bath_number NUMERIC(10, 0) NOT NULL, CHANGE zipcode zipcode NUMERIC(5, 0) NOT NULL, CHANGE main_image main_image VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE utf8_unicode_ci, CHANGE bed_number bed_number NUMERIC(10, 0) NOT NULL, CHANGE extras extras TEXT NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE user ADD authkey VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD password VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
