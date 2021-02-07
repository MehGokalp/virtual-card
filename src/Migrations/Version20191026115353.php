<?php

declare(strict_types=1);

namespace VirtualCard\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191026115353 extends AbstractMigration
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

        $this->addSql('ALTER TABLE bucket ADD base_id INT DEFAULT NULL');
        $this->addSql(
            'ALTER TABLE bucket ADD CONSTRAINT FK_E73F36A66967DF41 FOREIGN KEY (base_id) REFERENCES bucket (id)'
        );
        $this->addSql('CREATE INDEX IDX_E73F36A66967DF41 ON bucket (base_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('ALTER TABLE bucket DROP FOREIGN KEY FK_E73F36A66967DF41');
        $this->addSql('DROP INDEX IDX_E73F36A66967DF41 ON bucket');
        $this->addSql('ALTER TABLE bucket DROP base_id');
    }
}
