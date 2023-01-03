<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230103135436 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking ADD management_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE80D51D0E FOREIGN KEY (management_id) REFERENCES restaurant (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE80D51D0E ON booking (management_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE80D51D0E');
        $this->addSql('DROP INDEX IDX_E00CEDDE80D51D0E ON booking');
        $this->addSql('ALTER TABLE booking DROP management_id');
    }
}
