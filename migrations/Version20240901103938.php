<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240901103938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE detalle_nomina (id INT AUTO_INCREMENT NOT NULL, nomina_id INT NOT NULL, personal_id INT NOT NULL, sueldo_basico DOUBLE PRECISION DEFAULT NULL, dias_laborados INT NOT NULL, dias_transporte INT NOT NULL, dias_incapacidad INT NOT NULL, horas_extras_domingo INT NOT NULL, horas_extras_domingo_comp INT NOT NULL, auxilio_alimentacion INT NOT NULL, auxilio_transporte INT NOT NULL, anticipo INT NOT NULL, prestamo INT NOT NULL, coorserpark INT NOT NULL, INDEX IDX_BB0704248261CA50 (nomina_id), INDEX IDX_BB0704245D430949 (personal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nomina (id INT AUTO_INCREMENT NOT NULL, tipo_nomina_id INT NOT NULL, preparado_por_id INT NOT NULL, aprobado_por_id INT DEFAULT NULL, fecha_inicio DATETIME NOT NULL, fecha_fin DATETIME NOT NULL, fecha_preparation DATETIME NOT NULL, fecha_aprobacion DATETIME DEFAULT NULL, INDEX IDX_D7DFE783600F751E (tipo_nomina_id), INDEX IDX_D7DFE78391BEC823 (preparado_por_id), INDEX IDX_D7DFE783E5253621 (aprobado_por_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE detalle_nomina ADD CONSTRAINT FK_BB0704248261CA50 FOREIGN KEY (nomina_id) REFERENCES nomina (id)');
        $this->addSql('ALTER TABLE detalle_nomina ADD CONSTRAINT FK_BB0704245D430949 FOREIGN KEY (personal_id) REFERENCES personal (id)');
        $this->addSql('ALTER TABLE nomina ADD CONSTRAINT FK_D7DFE783600F751E FOREIGN KEY (tipo_nomina_id) REFERENCES tipo_nomina (id)');
        $this->addSql('ALTER TABLE nomina ADD CONSTRAINT FK_D7DFE78391BEC823 FOREIGN KEY (preparado_por_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE nomina ADD CONSTRAINT FK_D7DFE783E5253621 FOREIGN KEY (aprobado_por_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detalle_nomina DROP FOREIGN KEY FK_BB0704248261CA50');
        $this->addSql('ALTER TABLE detalle_nomina DROP FOREIGN KEY FK_BB0704245D430949');
        $this->addSql('ALTER TABLE nomina DROP FOREIGN KEY FK_D7DFE783600F751E');
        $this->addSql('ALTER TABLE nomina DROP FOREIGN KEY FK_D7DFE78391BEC823');
        $this->addSql('ALTER TABLE nomina DROP FOREIGN KEY FK_D7DFE783E5253621');
        $this->addSql('DROP TABLE detalle_nomina');
        $this->addSql('DROP TABLE nomina');
    }
}
