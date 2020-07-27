<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200727144032 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE type_document (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_document_audit (id INT UNSIGNED AUTO_INCREMENT NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX type_5b2328224d797698aee807c18a1a3bfd_idx (type), INDEX object_id_5b2328224d797698aee807c18a1a3bfd_idx (object_id), INDEX discriminator_5b2328224d797698aee807c18a1a3bfd_idx (discriminator), INDEX transaction_hash_5b2328224d797698aee807c18a1a3bfd_idx (transaction_hash), INDEX blame_id_5b2328224d797698aee807c18a1a3bfd_idx (blame_id), INDEX created_at_5b2328224d797698aee807c18a1a3bfd_idx (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE accords (id INT AUTO_INCREMENT NOT NULL, sous_type_document_id INT DEFAULT NULL, users_id INT DEFAULT NULL, cote VARCHAR(255) NOT NULL, boite_archive VARCHAR(255) NOT NULL, date_signature_at DATE NOT NULL, date_entree_at DATE NOT NULL, lieu_signature VARCHAR(255) NOT NULL, etat_accord VARCHAR(255) NOT NULL, intitule LONGTEXT NOT NULL, mot_cle LONGTEXT NOT NULL, mot_geo LONGTEXT NOT NULL, note LONGTEXT NOT NULL, resume LONGTEXT NOT NULL, INDEX IDX_1CF23D08CCEEF398 (sous_type_document_id), INDEX IDX_1CF23D0867B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE accords_audit (id INT UNSIGNED AUTO_INCREMENT NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX type_f43c80a22422bc22c34ef47b713da110_idx (type), INDEX object_id_f43c80a22422bc22c34ef47b713da110_idx (object_id), INDEX discriminator_f43c80a22422bc22c34ef47b713da110_idx (discriminator), INDEX transaction_hash_f43c80a22422bc22c34ef47b713da110_idx (transaction_hash), INDEX blame_id_f43c80a22422bc22c34ef47b713da110_idx (blame_id), INDEX created_at_f43c80a22422bc22c34ef47b713da110_idx (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sous_type_document (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, sous_type VARCHAR(255) NOT NULL, INDEX IDX_28F1A805C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sous_type_document_audit (id INT UNSIGNED AUTO_INCREMENT NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX type_f3494828e0a4cfbfd365bea24b9c7e80_idx (type), INDEX object_id_f3494828e0a4cfbfd365bea24b9c7e80_idx (object_id), INDEX discriminator_f3494828e0a4cfbfd365bea24b9c7e80_idx (discriminator), INDEX transaction_hash_f3494828e0a4cfbfd365bea24b9c7e80_idx (transaction_hash), INDEX blame_id_f3494828e0a4cfbfd365bea24b9c7e80_idx (blame_id), INDEX created_at_f3494828e0a4cfbfd365bea24b9c7e80_idx (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, roles JSON NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, activation_token VARCHAR(50) DEFAULT NULL, reset_token VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_audit (id INT UNSIGNED AUTO_INCREMENT NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX type_e06395edc291d0719bee26fd39a32e8a_idx (type), INDEX object_id_e06395edc291d0719bee26fd39a32e8a_idx (object_id), INDEX discriminator_e06395edc291d0719bee26fd39a32e8a_idx (discriminator), INDEX transaction_hash_e06395edc291d0719bee26fd39a32e8a_idx (transaction_hash), INDEX blame_id_e06395edc291d0719bee26fd39a32e8a_idx (blame_id), INDEX created_at_e06395edc291d0719bee26fd39a32e8a_idx (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE repertoire (id INT AUTO_INCREMENT NOT NULL, langue_id INT NOT NULL, accord_id INT NOT NULL, repertoire VARCHAR(700) NOT NULL, INDEX IDX_3C3678762AADBACD (langue_id), INDEX IDX_3C3678761EDF023F (accord_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE repertoire_audit (id INT UNSIGNED AUTO_INCREMENT NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX type_cf3aeee929e1ec400bbadd6d58f9c49f_idx (type), INDEX object_id_cf3aeee929e1ec400bbadd6d58f9c49f_idx (object_id), INDEX discriminator_cf3aeee929e1ec400bbadd6d58f9c49f_idx (discriminator), INDEX transaction_hash_cf3aeee929e1ec400bbadd6d58f9c49f_idx (transaction_hash), INDEX blame_id_cf3aeee929e1ec400bbadd6d58f9c49f_idx (blame_id), INDEX created_at_cf3aeee929e1ec400bbadd6d58f9c49f_idx (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE langue (id INT AUTO_INCREMENT NOT NULL, langue VARCHAR(255) NOT NULL, abreviation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE langue_audit (id INT UNSIGNED AUTO_INCREMENT NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX type_d6a9024da46045267e58254506b5cbfa_idx (type), INDEX object_id_d6a9024da46045267e58254506b5cbfa_idx (object_id), INDEX discriminator_d6a9024da46045267e58254506b5cbfa_idx (discriminator), INDEX transaction_hash_d6a9024da46045267e58254506b5cbfa_idx (transaction_hash), INDEX blame_id_d6a9024da46045267e58254506b5cbfa_idx (blame_id), INDEX created_at_d6a9024da46045267e58254506b5cbfa_idx (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE audit_associations (id INT AUTO_INCREMENT NOT NULL, typ VARCHAR(128) NOT NULL, tbl VARCHAR(128) DEFAULT NULL, label VARCHAR(255) DEFAULT NULL, fk VARCHAR(255) NOT NULL, class VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE audit_logs (id INT AUTO_INCREMENT NOT NULL, source_id INT NOT NULL, target_id INT DEFAULT NULL, blame_id INT DEFAULT NULL, action VARCHAR(12) NOT NULL, tbl VARCHAR(128) NOT NULL, diff JSON DEFAULT NULL, logged_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_D62F2858953C1C61 (source_id), UNIQUE INDEX UNIQ_D62F2858158E0B66 (target_id), UNIQUE INDEX UNIQ_D62F28588C082A2E (blame_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accords ADD CONSTRAINT FK_1CF23D08CCEEF398 FOREIGN KEY (sous_type_document_id) REFERENCES sous_type_document (id)');
        $this->addSql('ALTER TABLE accords ADD CONSTRAINT FK_1CF23D0867B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE sous_type_document ADD CONSTRAINT FK_28F1A805C54C8C93 FOREIGN KEY (type_id) REFERENCES type_document (id)');
        $this->addSql('ALTER TABLE repertoire ADD CONSTRAINT FK_3C3678762AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id)');
        $this->addSql('ALTER TABLE repertoire ADD CONSTRAINT FK_3C3678761EDF023F FOREIGN KEY (accord_id) REFERENCES accords (id)');
        $this->addSql('ALTER TABLE audit_logs ADD CONSTRAINT FK_D62F2858953C1C61 FOREIGN KEY (source_id) REFERENCES audit_associations (id)');
        $this->addSql('ALTER TABLE audit_logs ADD CONSTRAINT FK_D62F2858158E0B66 FOREIGN KEY (target_id) REFERENCES audit_associations (id)');
        $this->addSql('ALTER TABLE audit_logs ADD CONSTRAINT FK_D62F28588C082A2E FOREIGN KEY (blame_id) REFERENCES audit_associations (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sous_type_document DROP FOREIGN KEY FK_28F1A805C54C8C93');
        $this->addSql('ALTER TABLE repertoire DROP FOREIGN KEY FK_3C3678761EDF023F');
        $this->addSql('ALTER TABLE accords DROP FOREIGN KEY FK_1CF23D08CCEEF398');
        $this->addSql('ALTER TABLE accords DROP FOREIGN KEY FK_1CF23D0867B3B43D');
        $this->addSql('ALTER TABLE repertoire DROP FOREIGN KEY FK_3C3678762AADBACD');
        $this->addSql('ALTER TABLE audit_logs DROP FOREIGN KEY FK_D62F2858953C1C61');
        $this->addSql('ALTER TABLE audit_logs DROP FOREIGN KEY FK_D62F2858158E0B66');
        $this->addSql('ALTER TABLE audit_logs DROP FOREIGN KEY FK_D62F28588C082A2E');
        $this->addSql('DROP TABLE type_document');
        $this->addSql('DROP TABLE type_document_audit');
        $this->addSql('DROP TABLE accords');
        $this->addSql('DROP TABLE accords_audit');
        $this->addSql('DROP TABLE sous_type_document');
        $this->addSql('DROP TABLE sous_type_document_audit');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_audit');
        $this->addSql('DROP TABLE repertoire');
        $this->addSql('DROP TABLE repertoire_audit');
        $this->addSql('DROP TABLE langue');
        $this->addSql('DROP TABLE langue_audit');
        $this->addSql('DROP TABLE audit_associations');
        $this->addSql('DROP TABLE audit_logs');
    }
}
