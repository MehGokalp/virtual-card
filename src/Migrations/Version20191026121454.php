<?php

declare(strict_types=1);

namespace VirtualCard\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191026121454 extends AbstractMigration
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

        $this->addSql('ALTER TABLE virtual_card ADD bucket_id INT NOT NULL');
        $this->addSql(
            'ALTER TABLE virtual_card ADD CONSTRAINT FK_FF9C85EB84CE584D FOREIGN KEY (bucket_id) REFERENCES bucket (id)'
        );
        $this->addSql('CREATE INDEX IDX_FF9C85EB84CE584D ON virtual_card (bucket_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('ALTER TABLE virtual_card DROP FOREIGN KEY FK_FF9C85EB84CE584D');
        $this->addSql('DROP INDEX IDX_FF9C85EB84CE584D ON virtual_card');
        $this->addSql('ALTER TABLE virtual_card DROP bucket_id');
    }
}
