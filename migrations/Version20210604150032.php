<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210604150032 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE grille_tarifaire_hotel (grille_tarifaire_id INT NOT NULL, hotel_id INT NOT NULL, INDEX IDX_AE68DB6D2C47CC22 (grille_tarifaire_id), INDEX IDX_AE68DB6D3243BB18 (hotel_id), PRIMARY KEY(grille_tarifaire_id, hotel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE grille_tarifaire_hotel ADD CONSTRAINT FK_AE68DB6D2C47CC22 FOREIGN KEY (grille_tarifaire_id) REFERENCES grille_tarifaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE grille_tarifaire_hotel ADD CONSTRAINT FK_AE68DB6D3243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE grille_tarifaire_hotel');
    }
}
