<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240504111816 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE novedad_nomina DROP FOREIGN KEY FK_21BFF2B9271DD841');
        $this->addSql('DROP INDEX IDX_21BFF2B9271DD841 ON novedad_nomina');
        $this->addSql('ALTER TABLE novedad_nomina CHANGE personal_id_id personal_id INT NOT NULL');
        $this->addSql('ALTER TABLE novedad_nomina ADD CONSTRAINT FK_21BFF2B95D430949 FOREIGN KEY (personal_id) REFERENCES personal (id)');
        $this->addSql('CREATE INDEX IDX_21BFF2B95D430949 ON novedad_nomina (personal_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE novedad_nomina DROP FOREIGN KEY FK_21BFF2B95D430949');
        $this->addSql('DROP INDEX IDX_21BFF2B95D430949 ON novedad_nomina');
        $this->addSql('ALTER TABLE novedad_nomina CHANGE personal_id personal_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE novedad_nomina ADD CONSTRAINT FK_21BFF2B9271DD841 FOREIGN KEY (personal_id_id) REFERENCES personal (id)');
        $this->addSql('CREATE INDEX IDX_21BFF2B9271DD841 ON novedad_nomina (personal_id_id)');
    }
}
