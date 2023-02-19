<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230218110655 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE talla_botas CHANGE nombre talla VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE talla_camisa CHANGE nombre talla VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE talla_pantalon CHANGE nombre talla VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE talla_uniforme CHANGE nombre talla VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE talla_botas CHANGE talla nombre VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE talla_camisa CHANGE talla nombre VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE talla_pantalon CHANGE talla nombre VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE talla_uniforme CHANGE talla nombre VARCHAR(255) NOT NULL');
    }
}
