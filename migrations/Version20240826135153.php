<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240826135153 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quote ADD pickup_street LONGTEXT NOT NULL, ADD pickup_postal_code LONGTEXT NOT NULL, ADD pickup_city LONGTEXT NOT NULL, ADD delivery_street LONGTEXT NOT NULL, ADD delivery_postal_code LONGTEXT NOT NULL, ADD delivery_city LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quote DROP pickup_street, DROP pickup_postal_code, DROP pickup_city, DROP delivery_street, DROP delivery_postal_code, DROP delivery_city');
    }
}
