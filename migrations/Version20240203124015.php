<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240203124015 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE prestamo (id INT AUTO_INCREMENT NOT NULL, personal_id INT NOT NULL, responsable_id INT NOT NULL, monto INT NOT NULL, fecha_prestamo DATETIME NOT NULL, estado VARCHAR(255) NOT NULL, INDEX IDX_F4D874F25D430949 (personal_id), INDEX IDX_F4D874F253C59D72 (responsable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE prestamo ADD CONSTRAINT FK_F4D874F25D430949 FOREIGN KEY (personal_id) REFERENCES personal (id)');
        $this->addSql('ALTER TABLE prestamo ADD CONSTRAINT FK_F4D874F253C59D72 FOREIGN KEY (responsable_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prestamo DROP FOREIGN KEY FK_F4D874F25D430949');
        $this->addSql('ALTER TABLE prestamo DROP FOREIGN KEY FK_F4D874F253C59D72');
        $this->addSql('DROP TABLE prestamo');
    }
}
