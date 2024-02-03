<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240203124333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE abono_prestamo (id INT AUTO_INCREMENT NOT NULL, prestamo_id INT NOT NULL, abono INT NOT NULL, fecha_abono DATETIME NOT NULL, INDEX IDX_EA5F4C0B135A846E (prestamo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE abono_prestamo ADD CONSTRAINT FK_EA5F4C0B135A846E FOREIGN KEY (prestamo_id) REFERENCES prestamo (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE abono_prestamo DROP FOREIGN KEY FK_EA5F4C0B135A846E');
        $this->addSql('DROP TABLE abono_prestamo');
    }
}
