<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240908091731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE delivery_order (id BLOB NOT NULL --(DC2Type:uuid)
        , external_id CLOB NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetimetz_immutable)
        , PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE quote (id BLOB NOT NULL --(DC2Type:uuid)
        , store_id BLOB NOT NULL --(DC2Type:uuid)
        , delivery_order_id BLOB DEFAULT NULL --(DC2Type:uuid)
        , group_id BLOB NOT NULL --(DC2Type:uuid)
        , external_id CLOB NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetimetz_immutable)
        , price INTEGER NOT NULL, currency CLOB NOT NULL, pickup_street CLOB DEFAULT NULL, pickup_postal_code CLOB DEFAULT NULL, pickup_city CLOB DEFAULT NULL, delivery_street CLOB NOT NULL, delivery_postal_code CLOB NOT NULL, delivery_city CLOB NOT NULL, pickup_date_from DATETIME NOT NULL --(DC2Type:datetimetz_immutable)
        , pickup_date_to DATETIME NOT NULL --(DC2Type:datetimetz_immutable)
        , delivery_date_from DATETIME NOT NULL --(DC2Type:datetimetz_immutable)
        , delivery_date_to DATETIME NOT NULL --(DC2Type:datetimetz_immutable)
        , type VARCHAR(255) NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_6B71CBF4B092A811 FOREIGN KEY (store_id) REFERENCES store (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6B71CBF4ECFE8C54 FOREIGN KEY (delivery_order_id) REFERENCES delivery_order (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_6B71CBF4B092A811 ON quote (store_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6B71CBF4ECFE8C54 ON quote (delivery_order_id)');
        $this->addSql('CREATE TABLE store (id BLOB NOT NULL --(DC2Type:uuid)
        , created_at DATETIME NOT NULL --(DC2Type:datetimetz_immutable)
        , name CLOB NOT NULL, street CLOB NOT NULL, postal_code CLOB NOT NULL, city CLOB NOT NULL, evermile_location_id CLOB NOT NULL, shopify_token CLOB NOT NULL, shopify_name CLOB NOT NULL, shopify_domain CLOB NOT NULL, enabled BOOLEAN DEFAULT false, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE delivery_order');
        $this->addSql('DROP TABLE quote');
        $this->addSql('DROP TABLE store');
    }
}
