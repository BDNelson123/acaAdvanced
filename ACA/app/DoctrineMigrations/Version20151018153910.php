<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151018153910 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE house ADD mainimage LONGBLOB NOT NULL, ADD bednumber NUMERIC(10, 1) NOT NULL, ADD bathnumber NUMERIC(10, 1) NOT NULL, ADD askingprice NUMERIC(10, 2) NOT NULL, DROP main_image, DROP bed_number, DROP bath_number, DROP asking_price, CHANGE city city VARCHAR(50) NOT NULL, CHANGE state state VARCHAR(2) NOT NULL, CHANGE zipcode zipcode INT NOT NULL, CHANGE extras extras LONGTEXT NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE house ADD main_image VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD bed_number VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD bath_number VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD asking_price VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, DROP mainimage, DROP bednumber, DROP bathnumber, DROP askingprice, CHANGE city city VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE state state VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE zipcode zipcode VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE extras extras VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
