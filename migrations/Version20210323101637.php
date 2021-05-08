<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210323101637 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ADD reservations_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455D9A7F869 FOREIGN KEY (reservations_id) REFERENCES reservation (id)');
        $this->addSql('CREATE INDEX IDX_C7440455D9A7F869 ON client (reservations_id)');
        $this->addSql('ALTER TABLE grille_tarifaire ADD offre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE grille_tarifaire ADD CONSTRAINT FK_63E2418B4CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id)');
        $this->addSql('CREATE INDEX IDX_63E2418B4CC8505A ON grille_tarifaire (offre_id)');
        $this->addSql('ALTER TABLE photo ADD offre_id INT DEFAULT NULL, ADD sites_id INT DEFAULT NULL, ADD hotel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784184CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784187838E496 FOREIGN KEY (sites_id) REFERENCES sites (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784183243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('CREATE INDEX IDX_14B784184CC8505A ON photo (offre_id)');
        $this->addSql('CREATE INDEX IDX_14B784187838E496 ON photo (sites_id)');
        $this->addSql('CREATE INDEX IDX_14B784183243BB18 ON photo (hotel_id)');
        $this->addSql('ALTER TABLE reservation ADD agence_voyage_id INT DEFAULT NULL, ADD grille_tarifaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955E6568256 FOREIGN KEY (agence_voyage_id) REFERENCES agence_voyage (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849552C47CC22 FOREIGN KEY (grille_tarifaire_id) REFERENCES grille_tarifaire (id)');
        $this->addSql('CREATE INDEX IDX_42C84955E6568256 ON reservation (agence_voyage_id)');
        $this->addSql('CREATE INDEX IDX_42C849552C47CC22 ON reservation (grille_tarifaire_id)');
        $this->addSql('ALTER TABLE sites ADD pays_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sites ADD CONSTRAINT FK_BC00AA63A6E44244 FOREIGN KEY (pays_id) REFERENCES pays (id)');
        $this->addSql('CREATE INDEX IDX_BC00AA63A6E44244 ON sites (pays_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455D9A7F869');
        $this->addSql('DROP INDEX IDX_C7440455D9A7F869 ON client');
        $this->addSql('ALTER TABLE client DROP reservations_id');
        $this->addSql('ALTER TABLE grille_tarifaire DROP FOREIGN KEY FK_63E2418B4CC8505A');
        $this->addSql('DROP INDEX IDX_63E2418B4CC8505A ON grille_tarifaire');
        $this->addSql('ALTER TABLE grille_tarifaire DROP offre_id');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B784184CC8505A');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B784187838E496');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B784183243BB18');
        $this->addSql('DROP INDEX IDX_14B784184CC8505A ON photo');
        $this->addSql('DROP INDEX IDX_14B784187838E496 ON photo');
        $this->addSql('DROP INDEX IDX_14B784183243BB18 ON photo');
        $this->addSql('ALTER TABLE photo DROP offre_id, DROP sites_id, DROP hotel_id');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955E6568256');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849552C47CC22');
        $this->addSql('DROP INDEX IDX_42C84955E6568256 ON reservation');
        $this->addSql('DROP INDEX IDX_42C849552C47CC22 ON reservation');
        $this->addSql('ALTER TABLE reservation DROP agence_voyage_id, DROP grille_tarifaire_id');
        $this->addSql('ALTER TABLE sites DROP FOREIGN KEY FK_BC00AA63A6E44244');
        $this->addSql('DROP INDEX IDX_BC00AA63A6E44244 ON sites');
        $this->addSql('ALTER TABLE sites DROP pays_id');
    }
}
