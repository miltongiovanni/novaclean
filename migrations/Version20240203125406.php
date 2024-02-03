<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240203125406 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE novedades_nomina (id INT AUTO_INCREMENT NOT NULL, personal_id_id INT NOT NULL, tipo_novedad_id INT NOT NULL, fecha_inicio DATETIME NOT NULL, fecha_fin DATETIME NOT NULL, observaciones VARCHAR(255) DEFAULT NULL, INDEX IDX_71610DA271DD841 (personal_id_id), INDEX IDX_71610DA973A847A (tipo_novedad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE novedades_nomina ADD CONSTRAINT FK_71610DA271DD841 FOREIGN KEY (personal_id_id) REFERENCES personal (id)');
        $this->addSql('ALTER TABLE novedades_nomina ADD CONSTRAINT FK_71610DA973A847A FOREIGN KEY (tipo_novedad_id) REFERENCES tipo_novedad_nomina (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE novedades_nomina DROP FOREIGN KEY FK_71610DA271DD841');
        $this->addSql('ALTER TABLE novedades_nomina DROP FOREIGN KEY FK_71610DA973A847A');
        $this->addSql('DROP TABLE novedades_nomina');
    }
}
