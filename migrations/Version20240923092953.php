<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240923092953 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location DROP shopify_id, DROP shopify_name, CHANGE enabled enabled BOOLEAN DEFAULT false');
        $this->addSql('ALTER TABLE store CHANGE enabled enabled BOOLEAN DEFAULT false');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE store CHANGE enabled enabled TINYINT(1) DEFAULT 0');
        $this->addSql('ALTER TABLE location ADD shopify_id LONGTEXT DEFAULT NULL, ADD shopify_name LONGTEXT NOT NULL, CHANGE enabled enabled TINYINT(1) DEFAULT 0');
    }
}
