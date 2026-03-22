<?php

declare(strict_types=1);

namespace Programari\SyliusPifactPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260318230150 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pifact_plugin_invoice (id BIGINT AUTO_INCREMENT NOT NULL, invoice_id VARCHAR(255) NOT NULL, pdfUrl VARCHAR(255) NOT NULL, customerTaxId VARCHAR(20) DEFAULT NULL, number VARCHAR(20) DEFAULT NULL, email VARCHAR(255) NOT NULL, paymentMethod VARCHAR(255) NULL, moneyBase INT NOT NULL, INDEX IDX_32FD60E12989F1FD (invoice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pifact_plugin_invoice ADD CONSTRAINT FK_32FD60E12989F1FD FOREIGN KEY (invoice_id) REFERENCES sylius_invoicing_plugin_invoice (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pifact_plugin_invoice DROP FOREIGN KEY FK_32FD60E12989F1FD');
        $this->addSql('DROP TABLE pifact_plugin_invoice');
    }
}
