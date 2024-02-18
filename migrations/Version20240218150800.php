<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240218150800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tipo_novedad_nomina ADD user_id INT NOT NULL, ADD fecha_creacion DATETIME NOT NULL, ADD fecha_actualizacion DATETIME NOT NULL');
        $this->addSql('ALTER TABLE tipo_novedad_nomina ADD CONSTRAINT FK_AD6C3D19A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_AD6C3D19A76ED395 ON tipo_novedad_nomina (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tipo_novedad_nomina DROP FOREIGN KEY FK_AD6C3D19A76ED395');
        $this->addSql('DROP INDEX IDX_AD6C3D19A76ED395 ON tipo_novedad_nomina');
        $this->addSql('ALTER TABLE tipo_novedad_nomina DROP user_id, DROP fecha_creacion, DROP fecha_actualizacion');
    }
}
