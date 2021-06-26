<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210622101306 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, numtel VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agence_voyage (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, numtel VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agent (id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, numtel VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, reservations_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, numtel VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, INDEX IDX_C7440455D9A7F869 (reservations_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE croissiere (id INT NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE excursion (id INT NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grille_tarifaire (id INT AUTO_INCREMENT NOT NULL, offre_id INT DEFAULT NULL, description VARCHAR(255) NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, prix VARCHAR(255) NOT NULL, INDEX IDX_63E2418B4CC8505A (offre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grille_tarifaire_hotel (grille_tarifaire_id INT NOT NULL, hotel_id INT NOT NULL, INDEX IDX_AE68DB6D2C47CC22 (grille_tarifaire_id), INDEX IDX_AE68DB6D3243BB18 (hotel_id), PRIMARY KEY(grille_tarifaire_id, hotel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotel (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, photo LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messagerie (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre (id INT AUTO_INCREMENT NOT NULL, agencevoyage_id INT NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_AF86866F6781A052 (agencevoyage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre_pays (offre_id INT NOT NULL, pays_id INT NOT NULL, INDEX IDX_76CD82DA4CC8505A (offre_id), INDEX IDX_76CD82DAA6E44244 (pays_id), PRIMARY KEY(offre_id, pays_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre_hotel (offre_id INT NOT NULL, hotel_id INT NOT NULL, INDEX IDX_5479B9424CC8505A (offre_id), INDEX IDX_5479B9423243BB18 (hotel_id), PRIMARY KEY(offre_id, hotel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE omra (id INT NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pays (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, photo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, offre_id INT DEFAULT NULL, sites_id INT DEFAULT NULL, hotel_id INT DEFAULT NULL, url VARCHAR(255) NOT NULL, photo LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_14B784184CC8505A (offre_id), INDEX IDX_14B784187838E496 (sites_id), INDEX IDX_14B784183243BB18 (hotel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE randonnee (id INT NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, offre_id INT DEFAULT NULL, agence_voyage_id INT DEFAULT NULL, grille_tarifaire_id INT DEFAULT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, INDEX IDX_42C849554CC8505A (offre_id), INDEX IDX_42C84955E6568256 (agence_voyage_id), INDEX IDX_42C849552C47CC22 (grille_tarifaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sites (id INT AUTO_INCREMENT NOT NULL, pays_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, INDEX IDX_BC00AA63A6E44244 (pays_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, agence_voyage_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649E6568256 (agence_voyage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voyage_organiser (id INT NOT NULL, description VARCHAR(255) NOT NULL, photo LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D76BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9DBF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455D9A7F869 FOREIGN KEY (reservations_id) REFERENCES reservation (id)');
        $this->addSql('ALTER TABLE croissiere ADD CONSTRAINT FK_BCD5DE6BF396750 FOREIGN KEY (id) REFERENCES offre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE excursion ADD CONSTRAINT FK_9B08E72FBF396750 FOREIGN KEY (id) REFERENCES offre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE grille_tarifaire ADD CONSTRAINT FK_63E2418B4CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id)');
        $this->addSql('ALTER TABLE grille_tarifaire_hotel ADD CONSTRAINT FK_AE68DB6D2C47CC22 FOREIGN KEY (grille_tarifaire_id) REFERENCES grille_tarifaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE grille_tarifaire_hotel ADD CONSTRAINT FK_AE68DB6D3243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F6781A052 FOREIGN KEY (agencevoyage_id) REFERENCES agence_voyage (id)');
        $this->addSql('ALTER TABLE offre_pays ADD CONSTRAINT FK_76CD82DA4CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offre_pays ADD CONSTRAINT FK_76CD82DAA6E44244 FOREIGN KEY (pays_id) REFERENCES pays (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offre_hotel ADD CONSTRAINT FK_5479B9424CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offre_hotel ADD CONSTRAINT FK_5479B9423243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE omra ADD CONSTRAINT FK_25B22A80BF396750 FOREIGN KEY (id) REFERENCES offre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784184CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784187838E496 FOREIGN KEY (sites_id) REFERENCES sites (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784183243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE randonnee ADD CONSTRAINT FK_CB71A99FBF396750 FOREIGN KEY (id) REFERENCES offre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849554CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955E6568256 FOREIGN KEY (agence_voyage_id) REFERENCES agence_voyage (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849552C47CC22 FOREIGN KEY (grille_tarifaire_id) REFERENCES grille_tarifaire (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE sites ADD CONSTRAINT FK_BC00AA63A6E44244 FOREIGN KEY (pays_id) REFERENCES pays (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649E6568256 FOREIGN KEY (agence_voyage_id) REFERENCES agence_voyage (id)');
        $this->addSql('ALTER TABLE voyage_organiser ADD CONSTRAINT FK_A4FC6462BF396750 FOREIGN KEY (id) REFERENCES offre (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F6781A052');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955E6568256');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649E6568256');
        $this->addSql('ALTER TABLE grille_tarifaire_hotel DROP FOREIGN KEY FK_AE68DB6D2C47CC22');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849552C47CC22');
        $this->addSql('ALTER TABLE grille_tarifaire_hotel DROP FOREIGN KEY FK_AE68DB6D3243BB18');
        $this->addSql('ALTER TABLE offre_hotel DROP FOREIGN KEY FK_5479B9423243BB18');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B784183243BB18');
        $this->addSql('ALTER TABLE croissiere DROP FOREIGN KEY FK_BCD5DE6BF396750');
        $this->addSql('ALTER TABLE excursion DROP FOREIGN KEY FK_9B08E72FBF396750');
        $this->addSql('ALTER TABLE grille_tarifaire DROP FOREIGN KEY FK_63E2418B4CC8505A');
        $this->addSql('ALTER TABLE offre_pays DROP FOREIGN KEY FK_76CD82DA4CC8505A');
        $this->addSql('ALTER TABLE offre_hotel DROP FOREIGN KEY FK_5479B9424CC8505A');
        $this->addSql('ALTER TABLE omra DROP FOREIGN KEY FK_25B22A80BF396750');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B784184CC8505A');
        $this->addSql('ALTER TABLE randonnee DROP FOREIGN KEY FK_CB71A99FBF396750');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849554CC8505A');
        $this->addSql('ALTER TABLE voyage_organiser DROP FOREIGN KEY FK_A4FC6462BF396750');
        $this->addSql('ALTER TABLE offre_pays DROP FOREIGN KEY FK_76CD82DAA6E44244');
        $this->addSql('ALTER TABLE sites DROP FOREIGN KEY FK_BC00AA63A6E44244');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455D9A7F869');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B784187838E496');
        $this->addSql('ALTER TABLE admin DROP FOREIGN KEY FK_880E0D76BF396750');
        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9DBF396750');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE agence_voyage');
        $this->addSql('DROP TABLE agent');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE croissiere');
        $this->addSql('DROP TABLE excursion');
        $this->addSql('DROP TABLE grille_tarifaire');
        $this->addSql('DROP TABLE grille_tarifaire_hotel');
        $this->addSql('DROP TABLE hotel');
        $this->addSql('DROP TABLE messagerie');
        $this->addSql('DROP TABLE offre');
        $this->addSql('DROP TABLE offre_pays');
        $this->addSql('DROP TABLE offre_hotel');
        $this->addSql('DROP TABLE omra');
        $this->addSql('DROP TABLE pays');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE randonnee');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE sites');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE voyage_organiser');
    }
}
