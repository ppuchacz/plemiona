<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231204200516 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE building (id INT AUTO_INCREMENT NOT NULL, village_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, level INT NOT NULL, INDEX IDX_E16F61D45E0D5582 (village_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE materials (id INT AUTO_INCREMENT NOT NULL, player_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, amount INT NOT NULL, INDEX IDX_9B1716B599E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE village (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE building ADD CONSTRAINT FK_E16F61D45E0D5582 FOREIGN KEY (village_id) REFERENCES village (id)');
        $this->addSql('ALTER TABLE materials ADD CONSTRAINT FK_9B1716B599E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE building DROP FOREIGN KEY FK_E16F61D45E0D5582');
        $this->addSql('ALTER TABLE materials DROP FOREIGN KEY FK_9B1716B599E6F5DF');
        $this->addSql('DROP TABLE building');
        $this->addSql('DROP TABLE materials');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE village');
    }
}
