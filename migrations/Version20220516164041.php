<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220516164041 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE identite ADD anciennecard_id INT DEFAULT NULL, ADD justifdomi_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE identite ADD CONSTRAINT FK_7E94B58B58351842 FOREIGN KEY (anciennecard_id) REFERENCES fichier (id)');
        $this->addSql('ALTER TABLE identite ADD CONSTRAINT FK_7E94B58BC1C041E3 FOREIGN KEY (justifdomi_id) REFERENCES fichier (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7E94B58B58351842 ON identite (anciennecard_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7E94B58BC1C041E3 ON identite (justifdomi_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE identite DROP FOREIGN KEY FK_7E94B58B58351842');
        $this->addSql('ALTER TABLE identite DROP FOREIGN KEY FK_7E94B58BC1C041E3');
        $this->addSql('DROP INDEX UNIQ_7E94B58B58351842 ON identite');
        $this->addSql('DROP INDEX UNIQ_7E94B58BC1C041E3 ON identite');
        $this->addSql('ALTER TABLE identite DROP anciennecard_id, DROP justifdomi_id');
    }
}
