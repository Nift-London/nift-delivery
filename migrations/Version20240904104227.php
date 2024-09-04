<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240904104227 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE delivery_order (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', quote_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', external_id LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', UNIQUE INDEX UNIQ_E522750ADB805178 (quote_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE delivery_order ADD CONSTRAINT FK_E522750ADB805178 FOREIGN KEY (quote_id) REFERENCES quote (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE delivery_order DROP FOREIGN KEY FK_E522750ADB805178');
        $this->addSql('DROP TABLE delivery_order');
    }
}
