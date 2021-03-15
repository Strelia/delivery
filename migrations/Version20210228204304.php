<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210228204304 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cargo ALTER has_hitch SET DEFAULT \'false\'');
        $this->addSql('ALTER TABLE cargo ALTER has_ruber_tyres SET DEFAULT \'false\'');
        $this->addSql('ALTER TABLE cargo ALTER has_hook SET DEFAULT \'false\'');
        $this->addSql('ALTER TABLE cargo ALTER is_tir SET DEFAULT \'false\'');
        $this->addSql('ALTER TABLE cargo ALTER is_cmr SET DEFAULT \'false\'');
        $this->addSql('ALTER TABLE cargo ALTER is_t1 SET DEFAULT \'false\'');
        $this->addSql('ALTER TABLE cargo ALTER is_vat SET DEFAULT \'false\'');
        $this->addSql('ALTER TABLE cargo ALTER is_hidden_user_request SET DEFAULT \'false\'');
        $this->addSql('ALTER TABLE cargo_request ADD is_editable BOOLEAN DEFAULT \'false\' NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE cargo ALTER has_hitch DROP DEFAULT');
        $this->addSql('ALTER TABLE cargo ALTER has_ruber_tyres DROP DEFAULT');
        $this->addSql('ALTER TABLE cargo ALTER has_hook DROP DEFAULT');
        $this->addSql('ALTER TABLE cargo ALTER is_tir DROP DEFAULT');
        $this->addSql('ALTER TABLE cargo ALTER is_cmr DROP DEFAULT');
        $this->addSql('ALTER TABLE cargo ALTER is_t1 DROP DEFAULT');
        $this->addSql('ALTER TABLE cargo ALTER is_vat DROP DEFAULT');
        $this->addSql('ALTER TABLE cargo ALTER is_hidden_user_request DROP DEFAULT');
        $this->addSql('ALTER TABLE cargo_request DROP is_editable');
    }
}
