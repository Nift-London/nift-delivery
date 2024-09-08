<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240826135400 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quote CHANGE pickup_street pickup_street LONGTEXT DEFAULT NULL, CHANGE pickup_postal_code pickup_postal_code LONGTEXT DEFAULT NULL, CHANGE pickup_city pickup_city LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quote CHANGE pickup_street pickup_street LONGTEXT NOT NULL, CHANGE pickup_postal_code pickup_postal_code LONGTEXT NOT NULL, CHANGE pickup_city pickup_city LONGTEXT NOT NULL');
    }
}
