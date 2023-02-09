<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230209123955 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE eps (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, contacto VARCHAR(255) DEFAULT NULL, telefono INT DEFAULT NULL, extension INT DEFAULT NULL, celular INT DEFAULT NULL, fecha_creacion DATETIME DEFAULT NULL, fecha_actualizacion DATETIME DEFAULT NULL, INDEX IDX_576E89A9A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE eps ADD CONSTRAINT FK_576E89A9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE eps DROP FOREIGN KEY FK_576E89A9A76ED395');
        $this->addSql('DROP TABLE eps');
    }
}
