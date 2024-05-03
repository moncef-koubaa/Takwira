<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240503205548 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, stadium_id INT NOT NULL, date DATE NOT NULL, start_time TIME NOT NULL, end_time TIME NOT NULL, INDEX IDX_42C84955A76ED395 (user_id), INDEX IDX_42C849557E860E36 (stadium_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849557E860E36 FOREIGN KEY (stadium_id) REFERENCES stadium (id)');
        $this->addSql('ALTER TABLE stadium ADD CONSTRAINT FK_E604044F7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E604044F7E3C61F9 ON stadium (owner_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A76ED395');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849557E860E36');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('ALTER TABLE stadium DROP FOREIGN KEY FK_E604044F7E3C61F9');
        $this->addSql('DROP INDEX IDX_E604044F7E3C61F9 ON stadium');
    }
}
