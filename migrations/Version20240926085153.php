<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240926085153 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location ADD today_enabled BOOLEAN DEFAULT false, ADD tonight_enabled BOOLEAN DEFAULT false, ADD tomorrow_enabled BOOLEAN DEFAULT false, ADD today_price INT NOT NULL, ADD tonight_price INT NOT NULL, ADD tomorrow_price INT NOT NULL, CHANGE enabled enabled BOOLEAN DEFAULT false');
        $this->addSql('ALTER TABLE store CHANGE enabled enabled BOOLEAN DEFAULT false');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location DROP today_enabled, DROP tonight_enabled, DROP tomorrow_enabled, DROP today_price, DROP tonight_price, DROP tomorrow_price, CHANGE enabled enabled TINYINT(1) DEFAULT 0');
        $this->addSql('ALTER TABLE store CHANGE enabled enabled TINYINT(1) DEFAULT 0');
    }
}
