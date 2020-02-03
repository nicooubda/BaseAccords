<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200131141923 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE accords (id INT AUTO_INCREMENT NOT NULL, sous_type_document_id INT DEFAULT NULL, cote VARCHAR(255) NOT NULL, boite_archive VARCHAR(255) NOT NULL, date_signature_at DATE NOT NULL, date_entree_at DATE NOT NULL, lieu_signature VARCHAR(255) NOT NULL, etat_accord VARCHAR(255) NOT NULL, intitule LONGTEXT NOT NULL, mot_cle LONGTEXT NOT NULL, mot_geo LONGTEXT NOT NULL, note LONGTEXT NOT NULL, resume LONGTEXT NOT NULL, INDEX IDX_1CF23D08CCEEF398 (sous_type_document_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, roles JSON NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sous_type_document (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, sous_type VARCHAR(255) NOT NULL, INDEX IDX_28F1A805C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE langue (id INT AUTO_INCREMENT NOT NULL, langue VARCHAR(255) NOT NULL, abreviation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE repertoire (id INT AUTO_INCREMENT NOT NULL, langue_id INT NOT NULL, accord_id INT NOT NULL, repertoire VARCHAR(700) NOT NULL, INDEX IDX_3C3678762AADBACD (langue_id), INDEX IDX_3C3678761EDF023F (accord_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_document (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accords ADD CONSTRAINT FK_1CF23D08CCEEF398 FOREIGN KEY (sous_type_document_id) REFERENCES sous_type_document (id)');
        $this->addSql('ALTER TABLE sous_type_document ADD CONSTRAINT FK_28F1A805C54C8C93 FOREIGN KEY (type_id) REFERENCES type_document (id)');
        $this->addSql('ALTER TABLE repertoire ADD CONSTRAINT FK_3C3678762AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id)');
        $this->addSql('ALTER TABLE repertoire ADD CONSTRAINT FK_3C3678761EDF023F FOREIGN KEY (accord_id) REFERENCES accords (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE repertoire DROP FOREIGN KEY FK_3C3678761EDF023F');
        $this->addSql('ALTER TABLE accords DROP FOREIGN KEY FK_1CF23D08CCEEF398');
        $this->addSql('ALTER TABLE repertoire DROP FOREIGN KEY FK_3C3678762AADBACD');
        $this->addSql('ALTER TABLE sous_type_document DROP FOREIGN KEY FK_28F1A805C54C8C93');
        $this->addSql('DROP TABLE accords');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE sous_type_document');
        $this->addSql('DROP TABLE langue');
        $this->addSql('DROP TABLE repertoire');
        $this->addSql('DROP TABLE type_document');
    }
}
