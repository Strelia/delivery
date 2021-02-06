<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210206130309 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE adr_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE businesses_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE car_body_kinds_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE cargo_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "loading_kinds_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE packagin_kinds_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reset_password_request_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE road_train_kinds_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "users_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE adr (id INT NOT NULL, name VARCHAR(150) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9CEC6B65E237E06 ON adr (name)');
        $this->addSql('CREATE TABLE businesses (id INT NOT NULL, name VARCHAR(255) NOT NULL, international_name VARCHAR(255) DEFAULT NULL, brand VARCHAR(150) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, web_url VARCHAR(255) DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, status VARCHAR(50) NOT NULL, occupations JSONB NOT NULL, agency_type VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2DCA55EC5E237E06 ON businesses (name)');
        $this->addSql('COMMENT ON COLUMN businesses.occupations IS \'(DC2Type:jsonb)\'');
        $this->addSql('CREATE TABLE car_body_kinds (id INT NOT NULL, name VARCHAR(150) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_750C6B1E5E237E06 ON car_body_kinds (name)');
        $this->addSql('CREATE TABLE cargo (id INT NOT NULL, owner_id INT NOT NULL, adr_id INT DEFAULT NULL, packaging_kind_id INT DEFAULT NULL, name VARCHAR(150) NOT NULL, weight INT NOT NULL, volume INT DEFAULT NULL, length INT DEFAULT NULL, width INT DEFAULT NULL, diameter INT DEFAULT NULL, count_belt INT DEFAULT NULL, address_from VARCHAR(255) NOT NULL, address_to VARCHAR(255) NOT NULL, has_hitch BOOLEAN NOT NULL, has_ruber_tyres BOOLEAN NOT NULL, has_hook BOOLEAN NOT NULL, is_tir BOOLEAN NOT NULL, is_cmr BOOLEAN NOT NULL, is_t1 BOOLEAN NOT NULL, count_cars INT NOT NULL, date_start_min DATE NOT NULL, date_start_max DATE NOT NULL, price INT NOT NULL, payment_kind VARCHAR(150) NOT NULL, is_vat BOOLEAN NOT NULL, prepayment_kind VARCHAR(150) DEFAULT NULL, prepayment INT DEFAULT NULL, is_hidden_user_request BOOLEAN NOT NULL, status VARCHAR(15) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3BEE57717E3C61F9 ON cargo (owner_id)');
        $this->addSql('CREATE INDEX IDX_3BEE577146EED8E4 ON cargo (adr_id)');
        $this->addSql('CREATE INDEX IDX_3BEE5771D8C45C74 ON cargo (packaging_kind_id)');
        $this->addSql('CREATE TABLE cargo_car_body_kind (cargo_id INT NOT NULL, car_body_kind_id INT NOT NULL, PRIMARY KEY(cargo_id, car_body_kind_id))');
        $this->addSql('CREATE INDEX IDX_6F84CD0D813AC380 ON cargo_car_body_kind (cargo_id)');
        $this->addSql('CREATE INDEX IDX_6F84CD0D804F2AD7 ON cargo_car_body_kind (car_body_kind_id)');
        $this->addSql('CREATE TABLE cargo_loading_kinds (load_kind_id INT NOT NULL, cargo_id INT NOT NULL, PRIMARY KEY(load_kind_id, cargo_id))');
        $this->addSql('CREATE INDEX IDX_2AFBDFD38B012843 ON cargo_loading_kinds (load_kind_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2AFBDFD3813AC380 ON cargo_loading_kinds (cargo_id)');
        $this->addSql('CREATE TABLE cargo_unloading_kinds (load_kind_id INT NOT NULL, cargo_id INT NOT NULL, PRIMARY KEY(load_kind_id, cargo_id))');
        $this->addSql('CREATE INDEX IDX_BB2F52298B012843 ON cargo_unloading_kinds (load_kind_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BB2F5229813AC380 ON cargo_unloading_kinds (cargo_id)');
        $this->addSql('CREATE TABLE "loading_kinds" (id INT NOT NULL, name VARCHAR(150) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2CDDE0495E237E06 ON "loading_kinds" (name)');
        $this->addSql('CREATE TABLE packagin_kinds (id INT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(150) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_942452E5E237E06 ON packagin_kinds (name)');
        $this->addSql('CREATE INDEX IDX_942452E727ACA70 ON packagin_kinds (parent_id)');
        $this->addSql('CREATE TABLE reset_password_request (id INT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, expires_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7CE748AA76ED395 ON reset_password_request (user_id)');
        $this->addSql('COMMENT ON COLUMN reset_password_request.requested_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN reset_password_request.expires_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE road_train_kinds (id INT NOT NULL, name VARCHAR(150) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F0E01585E237E06 ON road_train_kinds (name)');
        $this->addSql('CREATE TABLE "users" (id INT NOT NULL, company_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, roles JSONB NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, name VARCHAR(50) NOT NULL, surname VARCHAR(50) NOT NULL, phone VARCHAR(20) NOT NULL, is_verified BOOLEAN NOT NULL, status VARCHAR(50) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9F85E0677 ON "users" (username)');
        $this->addSql('CREATE INDEX IDX_1483A5E9979B1AD6 ON "users" (company_id)');
        $this->addSql('COMMENT ON COLUMN "users".roles IS \'(DC2Type:jsonb)\'');
        $this->addSql('ALTER TABLE cargo ADD CONSTRAINT FK_3BEE57717E3C61F9 FOREIGN KEY (owner_id) REFERENCES businesses (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cargo ADD CONSTRAINT FK_3BEE577146EED8E4 FOREIGN KEY (adr_id) REFERENCES adr (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cargo ADD CONSTRAINT FK_3BEE5771D8C45C74 FOREIGN KEY (packaging_kind_id) REFERENCES packagin_kinds (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cargo_car_body_kind ADD CONSTRAINT FK_6F84CD0D813AC380 FOREIGN KEY (cargo_id) REFERENCES cargo (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cargo_car_body_kind ADD CONSTRAINT FK_6F84CD0D804F2AD7 FOREIGN KEY (car_body_kind_id) REFERENCES car_body_kinds (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cargo_loading_kinds ADD CONSTRAINT FK_2AFBDFD38B012843 FOREIGN KEY (load_kind_id) REFERENCES cargo (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cargo_loading_kinds ADD CONSTRAINT FK_2AFBDFD3813AC380 FOREIGN KEY (cargo_id) REFERENCES "loading_kinds" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cargo_unloading_kinds ADD CONSTRAINT FK_BB2F52298B012843 FOREIGN KEY (load_kind_id) REFERENCES cargo (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cargo_unloading_kinds ADD CONSTRAINT FK_BB2F5229813AC380 FOREIGN KEY (cargo_id) REFERENCES "loading_kinds" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE packagin_kinds ADD CONSTRAINT FK_942452E727ACA70 FOREIGN KEY (parent_id) REFERENCES packagin_kinds (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES "users" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "users" ADD CONSTRAINT FK_1483A5E9979B1AD6 FOREIGN KEY (company_id) REFERENCES businesses (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE cargo DROP CONSTRAINT FK_3BEE577146EED8E4');
        $this->addSql('ALTER TABLE cargo DROP CONSTRAINT FK_3BEE57717E3C61F9');
        $this->addSql('ALTER TABLE "users" DROP CONSTRAINT FK_1483A5E9979B1AD6');
        $this->addSql('ALTER TABLE cargo_car_body_kind DROP CONSTRAINT FK_6F84CD0D804F2AD7');
        $this->addSql('ALTER TABLE cargo_car_body_kind DROP CONSTRAINT FK_6F84CD0D813AC380');
        $this->addSql('ALTER TABLE cargo_loading_kinds DROP CONSTRAINT FK_2AFBDFD38B012843');
        $this->addSql('ALTER TABLE cargo_unloading_kinds DROP CONSTRAINT FK_BB2F52298B012843');
        $this->addSql('ALTER TABLE cargo_loading_kinds DROP CONSTRAINT FK_2AFBDFD3813AC380');
        $this->addSql('ALTER TABLE cargo_unloading_kinds DROP CONSTRAINT FK_BB2F5229813AC380');
        $this->addSql('ALTER TABLE cargo DROP CONSTRAINT FK_3BEE5771D8C45C74');
        $this->addSql('ALTER TABLE packagin_kinds DROP CONSTRAINT FK_942452E727ACA70');
        $this->addSql('ALTER TABLE reset_password_request DROP CONSTRAINT FK_7CE748AA76ED395');
        $this->addSql('DROP SEQUENCE adr_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE businesses_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE car_body_kinds_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE cargo_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "loading_kinds_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE packagin_kinds_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reset_password_request_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE road_train_kinds_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "users_id_seq" CASCADE');
        $this->addSql('DROP TABLE adr');
        $this->addSql('DROP TABLE businesses');
        $this->addSql('DROP TABLE car_body_kinds');
        $this->addSql('DROP TABLE cargo');
        $this->addSql('DROP TABLE cargo_car_body_kind');
        $this->addSql('DROP TABLE cargo_loading_kinds');
        $this->addSql('DROP TABLE cargo_unloading_kinds');
        $this->addSql('DROP TABLE "loading_kinds"');
        $this->addSql('DROP TABLE packagin_kinds');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE road_train_kinds');
        $this->addSql('DROP TABLE "users"');
    }
}
