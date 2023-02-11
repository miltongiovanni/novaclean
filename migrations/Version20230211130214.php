<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230211130214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contrato (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, cliente_id INT NOT NULL, personal_id INT NOT NULL, n_contrato VARCHAR(255) NOT NULL, f_inicio DATE NOT NULL, f_fin DATE NOT NULL, poliza_salario TINYINT(1) NOT NULL, poliza_cumplimiento TINYINT(1) NOT NULL, n_poliza VARCHAR(255) DEFAULT NULL, aseguradora VARCHAR(255) DEFAULT NULL, vencimiento_poliza DATE DEFAULT NULL, observaciones LONGTEXT DEFAULT NULL, INDEX IDX_66696523A76ED395 (user_id), INDEX IDX_66696523DE734E51 (cliente_id), INDEX IDX_666965235D430949 (personal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contrato ADD CONSTRAINT FK_66696523A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE contrato ADD CONSTRAINT FK_66696523DE734E51 FOREIGN KEY (cliente_id) REFERENCES cliente (id)');
        $this->addSql('ALTER TABLE contrato ADD CONSTRAINT FK_666965235D430949 FOREIGN KEY (personal_id) REFERENCES personal (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrato DROP FOREIGN KEY FK_66696523A76ED395');
        $this->addSql('ALTER TABLE contrato DROP FOREIGN KEY FK_66696523DE734E51');
        $this->addSql('ALTER TABLE contrato DROP FOREIGN KEY FK_666965235D430949');
        $this->addSql('DROP TABLE contrato');
    }
}
