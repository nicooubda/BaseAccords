<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200214180853 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_audit (id INT UNSIGNED AUTO_INCREMENT NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX type_e06395edc291d0719bee26fd39a32e8a_idx (type), INDEX object_id_e06395edc291d0719bee26fd39a32e8a_idx (object_id), INDEX discriminator_e06395edc291d0719bee26fd39a32e8a_idx (discriminator), INDEX transaction_hash_e06395edc291d0719bee26fd39a32e8a_idx (transaction_hash), INDEX blame_id_e06395edc291d0719bee26fd39a32e8a_idx (blame_id), INDEX created_at_e06395edc291d0719bee26fd39a32e8a_idx (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sous_type_document_audit (id INT UNSIGNED AUTO_INCREMENT NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX type_f3494828e0a4cfbfd365bea24b9c7e80_idx (type), INDEX object_id_f3494828e0a4cfbfd365bea24b9c7e80_idx (object_id), INDEX discriminator_f3494828e0a4cfbfd365bea24b9c7e80_idx (discriminator), INDEX transaction_hash_f3494828e0a4cfbfd365bea24b9c7e80_idx (transaction_hash), INDEX blame_id_f3494828e0a4cfbfd365bea24b9c7e80_idx (blame_id), INDEX created_at_f3494828e0a4cfbfd365bea24b9c7e80_idx (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE repertoire_audit (id INT UNSIGNED AUTO_INCREMENT NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX type_cf3aeee929e1ec400bbadd6d58f9c49f_idx (type), INDEX object_id_cf3aeee929e1ec400bbadd6d58f9c49f_idx (object_id), INDEX discriminator_cf3aeee929e1ec400bbadd6d58f9c49f_idx (discriminator), INDEX transaction_hash_cf3aeee929e1ec400bbadd6d58f9c49f_idx (transaction_hash), INDEX blame_id_cf3aeee929e1ec400bbadd6d58f9c49f_idx (blame_id), INDEX created_at_cf3aeee929e1ec400bbadd6d58f9c49f_idx (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_document_audit (id INT UNSIGNED AUTO_INCREMENT NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX type_5b2328224d797698aee807c18a1a3bfd_idx (type), INDEX object_id_5b2328224d797698aee807c18a1a3bfd_idx (object_id), INDEX discriminator_5b2328224d797698aee807c18a1a3bfd_idx (discriminator), INDEX transaction_hash_5b2328224d797698aee807c18a1a3bfd_idx (transaction_hash), INDEX blame_id_5b2328224d797698aee807c18a1a3bfd_idx (blame_id), INDEX created_at_5b2328224d797698aee807c18a1a3bfd_idx (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE accords_audit (id INT UNSIGNED AUTO_INCREMENT NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX type_f43c80a22422bc22c34ef47b713da110_idx (type), INDEX object_id_f43c80a22422bc22c34ef47b713da110_idx (object_id), INDEX discriminator_f43c80a22422bc22c34ef47b713da110_idx (discriminator), INDEX transaction_hash_f43c80a22422bc22c34ef47b713da110_idx (transaction_hash), INDEX blame_id_f43c80a22422bc22c34ef47b713da110_idx (blame_id), INDEX created_at_f43c80a22422bc22c34ef47b713da110_idx (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user_audit');
        $this->addSql('DROP TABLE sous_type_document_audit');
        $this->addSql('DROP TABLE repertoire_audit');
        $this->addSql('DROP TABLE type_document_audit');
        $this->addSql('DROP TABLE accords_audit');
    }
}
