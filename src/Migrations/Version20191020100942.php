<?php

declare(strict_types=1);

namespace VirtualCard\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191020100942 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql(
            'CREATE TABLE virtual_card (id INT AUTO_INCREMENT NOT NULL, currency_id INT NOT NULL, vendor_id INT NOT NULL, balance INT NOT NULL, activation_date DATE NOT NULL, expire_date DATE NOT NULL, notes VARCHAR(2048) DEFAULT NULL, process_id VARCHAR(255) NOT NULL, reference VARCHAR(255) NOT NULL, card_number VARCHAR(255) NOT NULL, cvc VARCHAR(255) NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_FF9C85EB38248176 (currency_id), INDEX IDX_FF9C85EBF603EE73 (vendor_id), PRIMARY KEY(id))'
        );
        $this->addSql(
            'CREATE TABLE vendor (id INT AUTO_INCREMENT NOT NULL, slug VARCHAR(32) NOT NULL, bucket_limit INT NOT NULL, bucket_date_delta INT NOT NULL, PRIMARY KEY(id))'
        );
        $this->addSql(
            'CREATE TABLE currency (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(4) NOT NULL, PRIMARY KEY(id))'
        );
        $this->addSql(
            'CREATE TABLE bucket (id INT AUTO_INCREMENT NOT NULL, currency_id INT NOT NULL, vendor_id INT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, balance INT NOT NULL, INDEX IDX_E73F36A638248176 (currency_id), INDEX IDX_E73F36A6F603EE73 (vendor_id), PRIMARY KEY(id))'
        );
        $this->addSql(
            'ALTER TABLE virtual_card ADD CONSTRAINT FK_FF9C85EB38248176 FOREIGN KEY (currency_id) REFERENCES currency (id)'
        );
        $this->addSql(
            'ALTER TABLE virtual_card ADD CONSTRAINT FK_FF9C85EBF603EE73 FOREIGN KEY (vendor_id) REFERENCES vendor (id)'
        );
        $this->addSql(
            'ALTER TABLE bucket ADD CONSTRAINT FK_E73F36A638248176 FOREIGN KEY (currency_id) REFERENCES currency (id)'
        );
        $this->addSql(
            'ALTER TABLE bucket ADD CONSTRAINT FK_E73F36A6F603EE73 FOREIGN KEY (vendor_id) REFERENCES vendor (id)'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('ALTER TABLE virtual_card DROP FOREIGN KEY FK_FF9C85EBF603EE73');
        $this->addSql('ALTER TABLE bucket DROP FOREIGN KEY FK_E73F36A6F603EE73');
        $this->addSql('ALTER TABLE virtual_card DROP FOREIGN KEY FK_FF9C85EB38248176');
        $this->addSql('ALTER TABLE bucket DROP FOREIGN KEY FK_E73F36A638248176');
        $this->addSql('DROP TABLE virtual_card');
        $this->addSql('DROP TABLE vendor');
        $this->addSql('DROP TABLE currency');
        $this->addSql('DROP TABLE bucket');
    }
}
