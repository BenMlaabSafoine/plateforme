<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210519223110 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE grille_tarifaire ADD date_debut DATE NOT NULL, ADD date_fin DATE NOT NULL');
        $this->addSql('ALTER TABLE randonnee ADD description VARCHAR(255) NOT NULL, DROP date_debut, DROP date_fin');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE grille_tarifaire DROP date_debut, DROP date_fin');
        $this->addSql('ALTER TABLE randonnee ADD date_debut DATE NOT NULL, ADD date_fin DATE NOT NULL, DROP description');
    }
}
