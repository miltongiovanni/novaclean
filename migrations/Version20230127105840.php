<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230127105840 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE perfiles (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, f_creacion DATETIME NOT NULL, slug VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE permission (id INT AUTO_INCREMENT NOT NULL, perfil_id INT NOT NULL, atributo VARCHAR(255) NOT NULL, modulo VARCHAR(255) NOT NULL, fecha_creacion DATETIME NOT NULL, fecha_actualizacion DATETIME DEFAULT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_E04992AA57291544 (perfil_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, perfil_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, passcode INT DEFAULT NULL, is_verified TINYINT(1) NOT NULL, activo TINYINT(1) DEFAULT NULL, f_creacion DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D64957291544 (perfil_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE permission ADD CONSTRAINT FK_E04992AA57291544 FOREIGN KEY (perfil_id) REFERENCES perfiles (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64957291544 FOREIGN KEY (perfil_id) REFERENCES perfiles (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE permission DROP FOREIGN KEY FK_E04992AA57291544');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64957291544');
        $this->addSql('DROP TABLE perfiles');
        $this->addSql('DROP TABLE permission');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
