<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240923083937 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE location (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', store_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', name LONGTEXT NOT NULL, street LONGTEXT NOT NULL, postal_code LONGTEXT NOT NULL, city LONGTEXT NOT NULL, evermile_location_id LONGTEXT NOT NULL, shopify_id LONGTEXT DEFAULT NULL, shopify_name LONGTEXT NOT NULL, enabled BOOLEAN DEFAULT false, INDEX IDX_5E9E89CBB092A811 (store_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CBB092A811 FOREIGN KEY (store_id) REFERENCES store (id)');
        $this->addSql('ALTER TABLE store DROP street, DROP postal_code, DROP city, DROP evermile_location_id, CHANGE enabled enabled BOOLEAN DEFAULT false');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CBB092A811');
        $this->addSql('DROP TABLE location');
        $this->addSql('ALTER TABLE store ADD street LONGTEXT NOT NULL, ADD postal_code LONGTEXT NOT NULL, ADD city LONGTEXT NOT NULL, ADD evermile_location_id LONGTEXT NOT NULL, CHANGE enabled enabled TINYINT(1) DEFAULT 0');
    }
}
