<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240503205103 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stadium ADD opening_time TIME NOT NULL, ADD closing_time TIME NOT NULL, ADD price_per_hour DOUBLE PRECISION NOT NULL, ADD city VARCHAR(50) NOT NULL, ADD zip_code INT NOT NULL, ADD address VARCHAR(255) NOT NULL, ADD has_shower TINYINT(1) NOT NULL, ADD has_park TINYINT(1) NOT NULL, ADD owner_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stadium DROP opening_time, DROP closing_time, DROP price_per_hour, DROP city, DROP zip_code, DROP address, DROP has_shower, DROP has_park, DROP owner_id');
    }
}
