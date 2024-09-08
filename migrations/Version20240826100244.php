<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240826100244 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quote (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', store_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', price INT NOT NULL, currency LONGTEXT NOT NULL, pickup_date_from DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', pickup_date_to DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', delivery_date_from DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', delivery_date_to DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', type VARCHAR(255) NOT NULL, INDEX IDX_6B71CBF4B092A811 (store_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quote ADD CONSTRAINT FK_6B71CBF4B092A811 FOREIGN KEY (store_id) REFERENCES store (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quote DROP FOREIGN KEY FK_6B71CBF4B092A811');
        $this->addSql('DROP TABLE quote');
    }
}
