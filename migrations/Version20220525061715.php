<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220525061715 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notification ADD identite_id INT NOT NULL');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAE5F13C8F FOREIGN KEY (identite_id) REFERENCES identite (id)');
        $this->addSql('CREATE INDEX IDX_BF5476CAE5F13C8F ON notification (identite_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAE5F13C8F');
        $this->addSql('DROP INDEX IDX_BF5476CAE5F13C8F ON notification');
        $this->addSql('ALTER TABLE notification DROP identite_id');
    }
}
