<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151020024219 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bid ADD user_id INT NOT NULL, ADD house_id INT NOT NULL, ADD bid_amount INT NOT NULL, DROP userid, DROP houseid, DROP bidamount, CHANGE biddate bid_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE house ADD main_image VARCHAR(255) NOT NULL, ADD bed_number NUMERIC(10, 1) NOT NULL, ADD bath_number NUMERIC(10, 1) NOT NULL, DROP mainimage, DROP bednumber, DROP bathnumber, CHANGE askingprice asking_price NUMERIC(10, 2) NOT NULL');
        $this->addSql('ALTER TABLE user ADD first_name VARCHAR(255) NOT NULL, ADD last_name VARCHAR(255) NOT NULL, DROP firstname, DROP lastname');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bid ADD userid INT NOT NULL, ADD houseid INT NOT NULL, ADD bidamount INT NOT NULL, DROP user_id, DROP house_id, DROP bid_amount, CHANGE bid_date biddate DATETIME NOT NULL');
        $this->addSql('ALTER TABLE house ADD mainimage LONGBLOB NOT NULL, ADD bednumber NUMERIC(10, 1) NOT NULL, ADD bathnumber NUMERIC(10, 1) NOT NULL, DROP main_image, DROP bed_number, DROP bath_number, CHANGE asking_price askingprice NUMERIC(10, 2) NOT NULL');
        $this->addSql('ALTER TABLE user ADD firstname VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD lastname VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, DROP first_name, DROP last_name');
    }
}
