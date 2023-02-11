<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230211130533 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contrato_personal (id INT AUTO_INCREMENT NOT NULL, personal_id INT NOT NULL, contrato_id INT NOT NULL, INDEX IDX_3CBEDD2C5D430949 (personal_id), INDEX IDX_3CBEDD2C70AE7BF1 (contrato_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contrato_personal ADD CONSTRAINT FK_3CBEDD2C5D430949 FOREIGN KEY (personal_id) REFERENCES personal (id)');
        $this->addSql('ALTER TABLE contrato_personal ADD CONSTRAINT FK_3CBEDD2C70AE7BF1 FOREIGN KEY (contrato_id) REFERENCES contrato (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrato_personal DROP FOREIGN KEY FK_3CBEDD2C5D430949');
        $this->addSql('ALTER TABLE contrato_personal DROP FOREIGN KEY FK_3CBEDD2C70AE7BF1');
        $this->addSql('DROP TABLE contrato_personal');
    }
}
