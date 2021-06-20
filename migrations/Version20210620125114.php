<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210620125114 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cargo_request ALTER status TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE cargo_request ALTER status DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN cargo_request.status IS NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE cargo_request ALTER status TYPE JSONB');
        $this->addSql('ALTER TABLE cargo_request ALTER status DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN cargo_request.status IS \'(DC2Type:jsonb)\'');
    }
}
