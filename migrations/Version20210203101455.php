<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210203101455 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE business_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE business (id INT NOT NULL, name VARCHAR(255) NOT NULL, international_name VARCHAR(255) DEFAULT NULL, brand VARCHAR(150) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, web_url VARCHAR(255) DEFAULT NULL, logo VARCHAR(255) NOT NULL, status VARCHAR(50) NOT NULL, occupations TEXT NOT NULL, agency_type VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN business.occupations IS \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE users ADD company_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9979B1AD6 FOREIGN KEY (company_id) REFERENCES business (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_1483A5E9979B1AD6 ON users (company_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "users" DROP CONSTRAINT FK_1483A5E9979B1AD6');
        $this->addSql('DROP SEQUENCE business_id_seq CASCADE');
        $this->addSql('DROP TABLE business');
        $this->addSql('DROP INDEX IDX_1483A5E9979B1AD6');
        $this->addSql('ALTER TABLE "users" DROP company_id');
    }
}
