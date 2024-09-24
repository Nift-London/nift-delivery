<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240904105028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE delivery_order DROP FOREIGN KEY FK_E522750ADB805178');
        $this->addSql('DROP INDEX UNIQ_E522750ADB805178 ON delivery_order');
        $this->addSql('ALTER TABLE delivery_order DROP quote_id');
        $this->addSql('ALTER TABLE quote ADD delivery_order_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE quote ADD CONSTRAINT FK_6B71CBF4ECFE8C54 FOREIGN KEY (delivery_order_id) REFERENCES delivery_order (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6B71CBF4ECFE8C54 ON quote (delivery_order_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE delivery_order ADD quote_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE delivery_order ADD CONSTRAINT FK_E522750ADB805178 FOREIGN KEY (quote_id) REFERENCES quote (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E522750ADB805178 ON delivery_order (quote_id)');
        $this->addSql('ALTER TABLE store CHANGE enabled enabled TINYINT(1) DEFAULT 0');
        $this->addSql('ALTER TABLE quote DROP FOREIGN KEY FK_6B71CBF4ECFE8C54');
        $this->addSql('DROP INDEX UNIQ_6B71CBF4ECFE8C54 ON quote');
    }
}
