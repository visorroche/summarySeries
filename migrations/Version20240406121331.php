<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240406121331 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE episodes ADD season_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE episodes ADD CONSTRAINT FK_7DD55EDD68756988 FOREIGN KEY (season_id_id) REFERENCES seasons (id)');
        $this->addSql('CREATE INDEX IDX_7DD55EDD68756988 ON episodes (season_id_id)');
        $this->addSql('ALTER TABLE seasons ADD serie_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE seasons ADD CONSTRAINT FK_B4F4301CB748AAC3 FOREIGN KEY (serie_id_id) REFERENCES series (id)');
        $this->addSql('CREATE INDEX IDX_B4F4301CB748AAC3 ON seasons (serie_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE episodes DROP FOREIGN KEY FK_7DD55EDD68756988');
        $this->addSql('DROP INDEX IDX_7DD55EDD68756988 ON episodes');
        $this->addSql('ALTER TABLE episodes DROP season_id_id');
        $this->addSql('ALTER TABLE seasons DROP FOREIGN KEY FK_B4F4301CB748AAC3');
        $this->addSql('DROP INDEX IDX_B4F4301CB748AAC3 ON seasons');
        $this->addSql('ALTER TABLE seasons DROP serie_id_id');
    }
}
