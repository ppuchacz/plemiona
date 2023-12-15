<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231215110433 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE resource (id INT AUTO_INCREMENT NOT NULL, village_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, amount DOUBLE PRECISION NOT NULL, datetime DATETIME NOT NULL, INDEX IDX_BC91F4165E0D5582 (village_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE resource ADD CONSTRAINT FK_BC91F4165E0D5582 FOREIGN KEY (village_id) REFERENCES village (id)');
        $this->addSql('ALTER TABLE materials DROP FOREIGN KEY FK_9B1716B599E6F5DF');
        $this->addSql('DROP TABLE materials');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE materials (id INT AUTO_INCREMENT NOT NULL, player_id INT DEFAULT NULL, type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, amount INT NOT NULL, INDEX IDX_9B1716B599E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE materials ADD CONSTRAINT FK_9B1716B599E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE resource DROP FOREIGN KEY FK_BC91F4165E0D5582');
        $this->addSql('DROP TABLE resource');
    }
}
