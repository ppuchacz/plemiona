<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231204211033 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE village ADD player_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE village ADD CONSTRAINT FK_4E6C7FAA99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('CREATE INDEX IDX_4E6C7FAA99E6F5DF ON village (player_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE village DROP FOREIGN KEY FK_4E6C7FAA99E6F5DF');
        $this->addSql('DROP INDEX IDX_4E6C7FAA99E6F5DF ON village');
        $this->addSql('ALTER TABLE village DROP player_id');
    }
}
