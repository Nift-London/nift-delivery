<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240924125143 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location CHANGE enabled enabled BOOLEAN DEFAULT false');
        $this->addSql('ALTER TABLE quote DROP FOREIGN KEY FK_6B71CBF4B092A811');
        $this->addSql('DROP INDEX IDX_6B71CBF4B092A811 ON quote');
        $this->addSql('DELETE FROM quote');
        $this->addSql('DELETE FROM delivery_order');
        $this->addSql('ALTER TABLE quote CHANGE store_id location_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE quote ADD CONSTRAINT FK_6B71CBF464D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('CREATE INDEX IDX_6B71CBF464D218E ON quote (location_id)');
        $this->addSql('ALTER TABLE store CHANGE enabled enabled BOOLEAN DEFAULT false');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quote DROP FOREIGN KEY FK_6B71CBF464D218E');
        $this->addSql('DROP INDEX IDX_6B71CBF464D218E ON quote');
        $this->addSql('ALTER TABLE quote CHANGE location_id store_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE quote ADD CONSTRAINT FK_6B71CBF4B092A811 FOREIGN KEY (store_id) REFERENCES store (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_6B71CBF4B092A811 ON quote (store_id)');
        $this->addSql('ALTER TABLE store CHANGE enabled enabled TINYINT(1) DEFAULT 0');
        $this->addSql('ALTER TABLE location CHANGE enabled enabled TINYINT(1) DEFAULT 0');
    }
}
