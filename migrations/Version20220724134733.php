<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220724134733 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE manga_purchase_details DROP FOREIGN KEY FK_F2C4ABD5B72950E8');
        $this->addSql('CREATE TABLE order_item (id INT AUTO_INCREMENT NOT NULL, mangas_id INT NOT NULL, quantity INT DEFAULT NULL, INDEX IDX_52EA1F09DDC4978F (mangas_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F09DDC4978F FOREIGN KEY (mangas_id) REFERENCES manga (id)');
        $this->addSql('DROP TABLE manga_purchase_details');
        $this->addSql('DROP TABLE purchase_details');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE manga_purchase_details (manga_id INT NOT NULL, purchase_details_id INT NOT NULL, INDEX IDX_F2C4ABD57B6461 (manga_id), INDEX IDX_F2C4ABD5B72950E8 (purchase_details_id), PRIMARY KEY(manga_id, purchase_details_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE purchase_details (id INT AUTO_INCREMENT NOT NULL, amount INT DEFAULT NULL, status VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE manga_purchase_details ADD CONSTRAINT FK_F2C4ABD5B72950E8 FOREIGN KEY (purchase_details_id) REFERENCES purchase_details (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE manga_purchase_details ADD CONSTRAINT FK_F2C4ABD57B6461 FOREIGN KEY (manga_id) REFERENCES manga (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE order_item');
    }
}
