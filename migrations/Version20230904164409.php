<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230904164409 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrato_personal ADD tipo_nomina_id INT NULL');
        $this->addSql('ALTER TABLE contrato_personal ADD CONSTRAINT FK_3CBEDD2C600F751E FOREIGN KEY (tipo_nomina_id) REFERENCES tipo_nomina (id)');
        $this->addSql('CREATE INDEX IDX_3CBEDD2C600F751E ON contrato_personal (tipo_nomina_id)');
        $this->addSql('ALTER TABLE personal DROP FOREIGN KEY FK_F18A6D84600F751E');
        $this->addSql('DROP INDEX IDX_F18A6D84600F751E ON personal');
        $this->addSql('ALTER TABLE personal DROP tipo_nomina_id');
        $this->addSql('ALTER TABLE messenger_messages CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE available_at available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE delivered_at delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrato_personal DROP FOREIGN KEY FK_3CBEDD2C600F751E');
        $this->addSql('DROP INDEX IDX_3CBEDD2C600F751E ON contrato_personal');
        $this->addSql('ALTER TABLE contrato_personal DROP tipo_nomina_id');
        $this->addSql('ALTER TABLE messenger_messages CHANGE created_at created_at DATETIME NOT NULL, CHANGE available_at available_at DATETIME NOT NULL, CHANGE delivered_at delivered_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE personal ADD tipo_nomina_id INT NOT NULL');
        $this->addSql('ALTER TABLE personal ADD CONSTRAINT FK_F18A6D84600F751E FOREIGN KEY (tipo_nomina_id) REFERENCES tipo_nomina (id)');
        $this->addSql('CREATE INDEX IDX_F18A6D84600F751E ON personal (tipo_nomina_id)');
    }
}
