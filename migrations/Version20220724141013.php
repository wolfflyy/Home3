<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220724141013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_item ADD items_id INT NOT NULL');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F096BB0AE84 FOREIGN KEY (items_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_52EA1F096BB0AE84 ON order_item (items_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F096BB0AE84');
        $this->addSql('DROP INDEX IDX_52EA1F096BB0AE84 ON order_item');
        $this->addSql('ALTER TABLE order_item DROP items_id');
    }
}
