<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230821110844 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrato_personal ADD salario_basico INT NOT NULL, ADD bono INT DEFAULT NULL');
        $this->addSql('ALTER TABLE personal DROP salario_basico, DROP bono');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrato_personal DROP salario_basico, DROP bono');
        $this->addSql('ALTER TABLE personal ADD salario_basico INT NOT NULL, ADD bono INT DEFAULT NULL');
    }
}
