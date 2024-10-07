<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241007150515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location ADD tomorrow_min_price INT NOT NULL, ADD today_min_price INT NOT NULL, ADD tonight_min_price INT NOT NULL, CHANGE enabled enabled BOOLEAN DEFAULT false, CHANGE tomorrow_enabled tomorrow_enabled BOOLEAN DEFAULT false, CHANGE today_first_range_enabled today_first_range_enabled BOOLEAN DEFAULT false, CHANGE tonight_first_range_enabled tonight_first_range_enabled BOOLEAN DEFAULT false, CHANGE today_second_range_enabled today_second_range_enabled BOOLEAN DEFAULT false, CHANGE tonight_second_range_enabled tonight_second_range_enabled BOOLEAN DEFAULT false, CHANGE today_third_range_enabled today_third_range_enabled BOOLEAN DEFAULT false, CHANGE tonight_third_range_enabled tonight_third_range_enabled BOOLEAN DEFAULT false, CHANGE today_fourth_range_enabled today_fourth_range_enabled BOOLEAN DEFAULT false, CHANGE tonight_fourth_range_enabled tonight_fourth_range_enabled BOOLEAN DEFAULT false, CHANGE today_fifth_range_enabled today_fifth_range_enabled BOOLEAN DEFAULT false, CHANGE tonight_fifth_range_enabled tonight_fifth_range_enabled BOOLEAN DEFAULT false');
        $this->addSql('ALTER TABLE store CHANGE enabled enabled BOOLEAN DEFAULT false, CHANGE shopify_webhooks_configured shopify_webhooks_configured BOOLEAN DEFAULT false, CHANGE shopify_carrier_service_configured shopify_carrier_service_configured BOOLEAN DEFAULT false');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE store CHANGE enabled enabled TINYINT(1) DEFAULT 0, CHANGE shopify_webhooks_configured shopify_webhooks_configured TINYINT(1) DEFAULT 0, CHANGE shopify_carrier_service_configured shopify_carrier_service_configured TINYINT(1) DEFAULT 0');
        $this->addSql('ALTER TABLE location DROP tomorrow_min_price, DROP today_min_price, DROP tonight_min_price, CHANGE enabled enabled TINYINT(1) DEFAULT 0, CHANGE tomorrow_enabled tomorrow_enabled TINYINT(1) DEFAULT 0, CHANGE today_first_range_enabled today_first_range_enabled TINYINT(1) DEFAULT 0, CHANGE tonight_first_range_enabled tonight_first_range_enabled TINYINT(1) DEFAULT 0, CHANGE today_second_range_enabled today_second_range_enabled TINYINT(1) DEFAULT 0, CHANGE tonight_second_range_enabled tonight_second_range_enabled TINYINT(1) DEFAULT 0, CHANGE today_third_range_enabled today_third_range_enabled TINYINT(1) DEFAULT 0, CHANGE tonight_third_range_enabled tonight_third_range_enabled TINYINT(1) DEFAULT 0, CHANGE today_fourth_range_enabled today_fourth_range_enabled TINYINT(1) DEFAULT 0, CHANGE tonight_fourth_range_enabled tonight_fourth_range_enabled TINYINT(1) DEFAULT 0, CHANGE today_fifth_range_enabled today_fifth_range_enabled TINYINT(1) DEFAULT 0, CHANGE tonight_fifth_range_enabled tonight_fifth_range_enabled TINYINT(1) DEFAULT 0');
    }
}
