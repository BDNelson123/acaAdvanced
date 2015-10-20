<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151020013832 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bid ADD user_id INT NOT NULL, ADD house_id INT NOT NULL, ADD bid_amount INT NOT NULL, DROP userid, DROP houseid, DROP bidamount, CHANGE biddate bid_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE house CHANGE city city VARCHAR(50) NOT NULL, CHANGE state state VARCHAR(2) NOT NULL, CHANGE zipcode zipcode INT NOT NULL, CHANGE bed_number bed_number NUMERIC(10, 1) NOT NULL, CHANGE bath_number bath_number NUMERIC(10, 1) NOT NULL, CHANGE asking_price asking_price NUMERIC(10, 2) NOT NULL, CHANGE extras extras LONGTEXT NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bid ADD userid INT NOT NULL, ADD houseid INT NOT NULL, ADD bidamount INT NOT NULL, DROP user_id, DROP house_id, DROP bid_amount, CHANGE bid_date biddate DATETIME NOT NULL');
        $this->addSql('ALTER TABLE house CHANGE city city VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE state state VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE zipcode zipcode VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE bed_number bed_number VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE bath_number bath_number VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE asking_price asking_price VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE extras extras VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
