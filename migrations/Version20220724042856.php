<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220724042856 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE manga_artist');
        $this->addSql('DROP TABLE manga_genre');
        $this->addSql('ALTER TABLE manga ADD genre_id INT NOT NULL, ADD artist_id INT NOT NULL');
        $this->addSql('ALTER TABLE manga ADD CONSTRAINT FK_765A9E034296D31F FOREIGN KEY (genre_id) REFERENCES genre (id)');
        $this->addSql('ALTER TABLE manga ADD CONSTRAINT FK_765A9E03B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id)');
        $this->addSql('CREATE INDEX IDX_765A9E034296D31F ON manga (genre_id)');
        $this->addSql('CREATE INDEX IDX_765A9E03B7970CF8 ON manga (artist_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE manga_artist (manga_id INT NOT NULL, artist_id INT NOT NULL, INDEX IDX_D21934807B6461 (manga_id), INDEX IDX_D2193480B7970CF8 (artist_id), PRIMARY KEY(manga_id, artist_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE manga_genre (manga_id INT NOT NULL, genre_id INT NOT NULL, INDEX IDX_1506CF9F7B6461 (manga_id), INDEX IDX_1506CF9F4296D31F (genre_id), PRIMARY KEY(manga_id, genre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE manga_artist ADD CONSTRAINT FK_D2193480B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE manga_artist ADD CONSTRAINT FK_D21934807B6461 FOREIGN KEY (manga_id) REFERENCES manga (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE manga_genre ADD CONSTRAINT FK_1506CF9F7B6461 FOREIGN KEY (manga_id) REFERENCES manga (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE manga_genre ADD CONSTRAINT FK_1506CF9F4296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE manga DROP FOREIGN KEY FK_765A9E034296D31F');
        $this->addSql('ALTER TABLE manga DROP FOREIGN KEY FK_765A9E03B7970CF8');
        $this->addSql('DROP INDEX IDX_765A9E034296D31F ON manga');
        $this->addSql('DROP INDEX IDX_765A9E03B7970CF8 ON manga');
        $this->addSql('ALTER TABLE manga DROP genre_id, DROP artist_id');
    }
}
