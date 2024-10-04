<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240924133905 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location CHANGE enabled enabled BOOLEAN DEFAULT false');
        $this->addSql('ALTER TABLE quote DROP pickup_street, DROP pickup_postal_code, DROP pickup_city');
        $this->addSql('ALTER TABLE store CHANGE enabled enabled BOOLEAN DEFAULT false');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quote ADD pickup_street LONGTEXT DEFAULT NULL, ADD pickup_postal_code LONGTEXT DEFAULT NULL, ADD pickup_city LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE store CHANGE enabled enabled TINYINT(1) DEFAULT 0');
        $this->addSql('ALTER TABLE location CHANGE enabled enabled TINYINT(1) DEFAULT 0');
    }
}
