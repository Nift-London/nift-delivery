<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241001103552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location CHANGE enabled enabled BOOLEAN DEFAULT false, CHANGE today_enabled today_enabled BOOLEAN DEFAULT false, CHANGE tonight_enabled tonight_enabled BOOLEAN DEFAULT false, CHANGE tomorrow_enabled tomorrow_enabled BOOLEAN DEFAULT false');
        $this->addSql('ALTER TABLE store ADD shopify_configured BOOLEAN DEFAULT false, CHANGE enabled enabled BOOLEAN DEFAULT false');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE store DROP shopify_configured, CHANGE enabled enabled TINYINT(1) DEFAULT 0');
        $this->addSql('ALTER TABLE location CHANGE enabled enabled TINYINT(1) DEFAULT 0, CHANGE today_enabled today_enabled TINYINT(1) DEFAULT 0, CHANGE tonight_enabled tonight_enabled TINYINT(1) DEFAULT 0, CHANGE tomorrow_enabled tomorrow_enabled TINYINT(1) DEFAULT 0');
    }
}
