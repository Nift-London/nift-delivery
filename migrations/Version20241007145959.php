<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241007145959 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location ADD today_first_range_from INT NOT NULL, ADD tonight_first_range_to INT NOT NULL, ADD today_first_range_enabled BOOLEAN DEFAULT false, ADD tonight_first_range_enabled BOOLEAN DEFAULT false, ADD today_first_range_price INT NOT NULL, ADD tonight_first_range_price INT NOT NULL, ADD today_second_range_from INT NOT NULL, ADD tonight_second_range_to INT NOT NULL, ADD today_second_range_enabled BOOLEAN DEFAULT false, ADD tonight_second_range_enabled BOOLEAN DEFAULT false, ADD today_second_range_price INT NOT NULL, ADD tonight_second_range_price INT NOT NULL, ADD today_third_range_from INT NOT NULL, ADD tonight_third_range_to INT NOT NULL, ADD today_third_range_enabled BOOLEAN DEFAULT false, ADD tonight_third_range_enabled BOOLEAN DEFAULT false, ADD today_third_range_price INT NOT NULL, ADD tonight_third_range_price INT NOT NULL, ADD today_fourth_range_from INT NOT NULL, ADD tonight_fourth_range_to INT NOT NULL, ADD today_fourth_range_enabled BOOLEAN DEFAULT false, ADD tonight_fourth_range_enabled BOOLEAN DEFAULT false, ADD today_fourth_range_price INT NOT NULL, ADD tonight_fourth_range_price INT NOT NULL, ADD today_fifth_range_from INT NOT NULL, ADD tonight_fifth_range_to INT NOT NULL, ADD today_fifth_range_enabled BOOLEAN DEFAULT false, ADD tonight_fifth_range_enabled BOOLEAN DEFAULT false, ADD today_fifth_range_price INT NOT NULL, ADD tonight_fifth_range_price INT NOT NULL, DROP today_enabled, DROP tonight_enabled, DROP today_price, DROP tonight_price, CHANGE enabled enabled BOOLEAN DEFAULT false, CHANGE tomorrow_enabled tomorrow_enabled BOOLEAN DEFAULT false');
        $this->addSql('ALTER TABLE store CHANGE enabled enabled BOOLEAN DEFAULT false, CHANGE shopify_webhooks_configured shopify_webhooks_configured BOOLEAN DEFAULT false, CHANGE shopify_carrier_service_configured shopify_carrier_service_configured BOOLEAN DEFAULT false');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE store CHANGE enabled enabled TINYINT(1) DEFAULT 0, CHANGE shopify_webhooks_configured shopify_webhooks_configured TINYINT(1) DEFAULT 0, CHANGE shopify_carrier_service_configured shopify_carrier_service_configured TINYINT(1) DEFAULT 0');
        $this->addSql('ALTER TABLE location ADD today_enabled TINYINT(1) DEFAULT 0, ADD tonight_enabled TINYINT(1) DEFAULT 0, ADD today_price INT NOT NULL, ADD tonight_price INT NOT NULL, DROP today_first_range_from, DROP tonight_first_range_to, DROP today_first_range_enabled, DROP tonight_first_range_enabled, DROP today_first_range_price, DROP tonight_first_range_price, DROP today_second_range_from, DROP tonight_second_range_to, DROP today_second_range_enabled, DROP tonight_second_range_enabled, DROP today_second_range_price, DROP tonight_second_range_price, DROP today_third_range_from, DROP tonight_third_range_to, DROP today_third_range_enabled, DROP tonight_third_range_enabled, DROP today_third_range_price, DROP tonight_third_range_price, DROP today_fourth_range_from, DROP tonight_fourth_range_to, DROP today_fourth_range_enabled, DROP tonight_fourth_range_enabled, DROP today_fourth_range_price, DROP tonight_fourth_range_price, DROP today_fifth_range_from, DROP tonight_fifth_range_to, DROP today_fifth_range_enabled, DROP tonight_fifth_range_enabled, DROP today_fifth_range_price, DROP tonight_fifth_range_price, CHANGE enabled enabled TINYINT(1) DEFAULT 0, CHANGE tomorrow_enabled tomorrow_enabled TINYINT(1) DEFAULT 0');
    }
}
