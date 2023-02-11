<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230211124352 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE personal (id INT AUTO_INCREMENT NOT NULL, sexo_id INT NOT NULL, tipo_nomina_id INT NOT NULL, afp_id INT NOT NULL, eps_id INT NOT NULL, afc_id INT NOT NULL, tipo_cuenta_id INT NOT NULL, talla_uniforme_id INT NOT NULL, talla_botas_id INT NOT NULL, cargo_id INT NOT NULL, talla_guantes_id INT NOT NULL, curso_especializado_id INT DEFAULT NULL, talla_camisa_id INT NOT NULL, talla_pantalon_id INT NOT NULL, talla_calzado_id INT NOT NULL, user_id INT NOT NULL, identificacion VARCHAR(255) NOT NULL, lugar_expedicion VARCHAR(255) NOT NULL, nombre VARCHAR(255) NOT NULL, apellido VARCHAR(255) NOT NULL, numero_cuenta VARCHAR(255) NOT NULL, salario_basico INT NOT NULL, bono INT NOT NULL, direccion VARCHAR(255) NOT NULL, telefono INT DEFAULT NULL, correo_electronico VARCHAR(255) DEFAULT NULL, celular INT DEFAULT NULL, f_nacimiento DATE NOT NULL, f_ingreso DATE NOT NULL, f_examen_ingreso DATE NOT NULL, INDEX IDX_F18A6D842B32DB58 (sexo_id), INDEX IDX_F18A6D84600F751E (tipo_nomina_id), INDEX IDX_F18A6D849627430F (afp_id), INDEX IDX_F18A6D84F0A3CCD5 (eps_id), INDEX IDX_F18A6D84D48BBB7E (afc_id), INDEX IDX_F18A6D8478814E56 (tipo_cuenta_id), INDEX IDX_F18A6D841C425C2A (talla_uniforme_id), INDEX IDX_F18A6D842E1E1B6D (talla_botas_id), INDEX IDX_F18A6D84813AC380 (cargo_id), INDEX IDX_F18A6D8419D5F450 (talla_guantes_id), INDEX IDX_F18A6D84BA950A0C (curso_especializado_id), INDEX IDX_F18A6D8432A87CCE (talla_camisa_id), INDEX IDX_F18A6D842C33CAD (talla_pantalon_id), INDEX IDX_F18A6D849D32B8E4 (talla_calzado_id), INDEX IDX_F18A6D84A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE personal ADD CONSTRAINT FK_F18A6D842B32DB58 FOREIGN KEY (sexo_id) REFERENCES sexo (id)');
        $this->addSql('ALTER TABLE personal ADD CONSTRAINT FK_F18A6D84600F751E FOREIGN KEY (tipo_nomina_id) REFERENCES tipo_nomina (id)');
        $this->addSql('ALTER TABLE personal ADD CONSTRAINT FK_F18A6D849627430F FOREIGN KEY (afp_id) REFERENCES afp (id)');
        $this->addSql('ALTER TABLE personal ADD CONSTRAINT FK_F18A6D84F0A3CCD5 FOREIGN KEY (eps_id) REFERENCES eps (id)');
        $this->addSql('ALTER TABLE personal ADD CONSTRAINT FK_F18A6D84D48BBB7E FOREIGN KEY (afc_id) REFERENCES afc (id)');
        $this->addSql('ALTER TABLE personal ADD CONSTRAINT FK_F18A6D8478814E56 FOREIGN KEY (tipo_cuenta_id) REFERENCES tipo_cuenta (id)');
        $this->addSql('ALTER TABLE personal ADD CONSTRAINT FK_F18A6D841C425C2A FOREIGN KEY (talla_uniforme_id) REFERENCES talla_uniforme (id)');
        $this->addSql('ALTER TABLE personal ADD CONSTRAINT FK_F18A6D842E1E1B6D FOREIGN KEY (talla_botas_id) REFERENCES talla_botas (id)');
        $this->addSql('ALTER TABLE personal ADD CONSTRAINT FK_F18A6D84813AC380 FOREIGN KEY (cargo_id) REFERENCES cargo (id)');
        $this->addSql('ALTER TABLE personal ADD CONSTRAINT FK_F18A6D8419D5F450 FOREIGN KEY (talla_guantes_id) REFERENCES talla_guantes (id)');
        $this->addSql('ALTER TABLE personal ADD CONSTRAINT FK_F18A6D84BA950A0C FOREIGN KEY (curso_especializado_id) REFERENCES curso_especializado (id)');
        $this->addSql('ALTER TABLE personal ADD CONSTRAINT FK_F18A6D8432A87CCE FOREIGN KEY (talla_camisa_id) REFERENCES talla_camisa (id)');
        $this->addSql('ALTER TABLE personal ADD CONSTRAINT FK_F18A6D842C33CAD FOREIGN KEY (talla_pantalon_id) REFERENCES talla_pantalon (id)');
        $this->addSql('ALTER TABLE personal ADD CONSTRAINT FK_F18A6D849D32B8E4 FOREIGN KEY (talla_calzado_id) REFERENCES talla_calzado (id)');
        $this->addSql('ALTER TABLE personal ADD CONSTRAINT FK_F18A6D84A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personal DROP FOREIGN KEY FK_F18A6D842B32DB58');
        $this->addSql('ALTER TABLE personal DROP FOREIGN KEY FK_F18A6D84600F751E');
        $this->addSql('ALTER TABLE personal DROP FOREIGN KEY FK_F18A6D849627430F');
        $this->addSql('ALTER TABLE personal DROP FOREIGN KEY FK_F18A6D84F0A3CCD5');
        $this->addSql('ALTER TABLE personal DROP FOREIGN KEY FK_F18A6D84D48BBB7E');
        $this->addSql('ALTER TABLE personal DROP FOREIGN KEY FK_F18A6D8478814E56');
        $this->addSql('ALTER TABLE personal DROP FOREIGN KEY FK_F18A6D841C425C2A');
        $this->addSql('ALTER TABLE personal DROP FOREIGN KEY FK_F18A6D842E1E1B6D');
        $this->addSql('ALTER TABLE personal DROP FOREIGN KEY FK_F18A6D84813AC380');
        $this->addSql('ALTER TABLE personal DROP FOREIGN KEY FK_F18A6D8419D5F450');
        $this->addSql('ALTER TABLE personal DROP FOREIGN KEY FK_F18A6D84BA950A0C');
        $this->addSql('ALTER TABLE personal DROP FOREIGN KEY FK_F18A6D8432A87CCE');
        $this->addSql('ALTER TABLE personal DROP FOREIGN KEY FK_F18A6D842C33CAD');
        $this->addSql('ALTER TABLE personal DROP FOREIGN KEY FK_F18A6D849D32B8E4');
        $this->addSql('ALTER TABLE personal DROP FOREIGN KEY FK_F18A6D84A76ED395');
        $this->addSql('DROP TABLE personal');
    }
}
