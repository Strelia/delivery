<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210217151213 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE request_cargo_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE request_cargo (id INT NOT NULL, cargo_id INT NOT NULL, executor_id INT NOT NULL, status VARCHAR(40) NOT NULL, price INT DEFAULT NULL, weight INT DEFAULT NULL, volume INT DEFAULT NULL, note TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_66F9EB54813AC380 ON request_cargo (cargo_id)');
        $this->addSql('CREATE INDEX IDX_66F9EB548ABD09BB ON request_cargo (executor_id)');
        $this->addSql('ALTER TABLE request_cargo ADD CONSTRAINT FK_66F9EB54813AC380 FOREIGN KEY (cargo_id) REFERENCES cargo (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE request_cargo ADD CONSTRAINT FK_66F9EB548ABD09BB FOREIGN KEY (executor_id) REFERENCES businesses (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE request_cargo_id_seq CASCADE');
        $this->addSql('DROP TABLE request_cargo');
    }
}
