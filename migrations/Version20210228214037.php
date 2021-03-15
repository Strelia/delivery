<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210228214037 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE request_cargo_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE cargo_request_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE cargo_request (id INT NOT NULL, cargo_id INT NOT NULL, executor_id INT NOT NULL, status VARCHAR(40) DEFAULT \'STATUS_PUBLISHED\' NOT NULL, price INT DEFAULT NULL, weight INT DEFAULT NULL, volume INT DEFAULT NULL, note TEXT DEFAULT NULL, is_editable BOOLEAN DEFAULT \'false\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_33E8DBB0813AC380 ON cargo_request (cargo_id)');
        $this->addSql('CREATE INDEX IDX_33E8DBB08ABD09BB ON cargo_request (executor_id)');
        $this->addSql('ALTER TABLE cargo_request ADD CONSTRAINT FK_33E8DBB0813AC380 FOREIGN KEY (cargo_id) REFERENCES cargo (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cargo_request ADD CONSTRAINT FK_33E8DBB08ABD09BB FOREIGN KEY (executor_id) REFERENCES businesses (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE request_cargo');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE cargo_request_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE request_cargo_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE request_cargo (id INT NOT NULL, cargo_id INT NOT NULL, executor_id INT NOT NULL, status VARCHAR(40) DEFAULT \'STATUS_PUBLISHED\' NOT NULL, price INT DEFAULT NULL, weight INT DEFAULT NULL, volume INT DEFAULT NULL, note TEXT DEFAULT NULL, is_editable BOOLEAN DEFAULT \'false\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_66f9eb548abd09bb ON request_cargo (executor_id)');
        $this->addSql('CREATE INDEX idx_66f9eb54813ac380 ON request_cargo (cargo_id)');
        $this->addSql('ALTER TABLE request_cargo ADD CONSTRAINT fk_66f9eb54813ac380 FOREIGN KEY (cargo_id) REFERENCES cargo (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE request_cargo ADD CONSTRAINT fk_66f9eb548abd09bb FOREIGN KEY (executor_id) REFERENCES businesses (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE cargo_request');
    }
}