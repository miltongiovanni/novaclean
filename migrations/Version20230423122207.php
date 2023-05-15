<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230423122207 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personal CHANGE talla_uniforme_id talla_uniforme_id INT DEFAULT NULL, CHANGE talla_botas_id talla_botas_id INT DEFAULT NULL, CHANGE talla_guantes_id talla_guantes_id INT DEFAULT NULL, CHANGE talla_camisa_id talla_camisa_id INT DEFAULT NULL, CHANGE talla_pantalon_id talla_pantalon_id INT DEFAULT NULL, CHANGE talla_calzado_id talla_calzado_id INT DEFAULT NULL, CHANGE bono bono INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personal CHANGE talla_uniforme_id talla_uniforme_id INT NOT NULL, CHANGE talla_botas_id talla_botas_id INT NOT NULL, CHANGE talla_guantes_id talla_guantes_id INT NOT NULL, CHANGE talla_camisa_id talla_camisa_id INT NOT NULL, CHANGE talla_pantalon_id talla_pantalon_id INT NOT NULL, CHANGE talla_calzado_id talla_calzado_id INT NOT NULL, CHANGE bono bono INT NOT NULL');
    }
}
