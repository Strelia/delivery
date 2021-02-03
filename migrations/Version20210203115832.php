<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210203115832 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // alter table users alter column roles type jsonb using roles::jsonb;
        $this->addSql('ALTER TABLE business ALTER occupations TYPE JSONB USING occupations::JSONB');
        $this->addSql('ALTER TABLE business ALTER occupations DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN business.occupations IS NULL');
        $this->addSql('ALTER TABLE users ALTER roles TYPE JSONB USING roles::JSONB');
        $this->addSql('ALTER TABLE users ALTER roles DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN users.roles IS NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE business ALTER occupations TYPE TEXT');
        $this->addSql('ALTER TABLE business ALTER occupations DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN business.occupations IS \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE "users" ALTER roles TYPE TEXT');
        $this->addSql('ALTER TABLE "users" ALTER roles DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN "users".roles IS \'(DC2Type:array)\'');
    }
}
