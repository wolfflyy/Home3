<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220723091950 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE manga_artist (manga_id INT NOT NULL, artist_id INT NOT NULL, INDEX IDX_D21934807B6461 (manga_id), INDEX IDX_D2193480B7970CF8 (artist_id), PRIMARY KEY(manga_id, artist_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE manga_artist ADD CONSTRAINT FK_D21934807B6461 FOREIGN KEY (manga_id) REFERENCES manga (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE manga_artist ADD CONSTRAINT FK_D2193480B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE manga DROP FOREIGN KEY FK_765A9E03B7970CF8');
        $this->addSql('DROP INDEX IDX_765A9E03B7970CF8 ON manga');
        $this->addSql('ALTER TABLE manga DROP artist_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE manga_artist');
        $this->addSql('ALTER TABLE manga ADD artist_id INT NOT NULL');
        $this->addSql('ALTER TABLE manga ADD CONSTRAINT FK_765A9E03B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id)');
        $this->addSql('CREATE INDEX IDX_765A9E03B7970CF8 ON manga (artist_id)');
    }
}
