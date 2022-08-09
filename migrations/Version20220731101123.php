<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220731101123 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE manga ADD price DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE order_item ADD order_ref_id INT NOT NULL, ADD mangas_id INT NOT NULL, ADD quantity INT NOT NULL');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F09E238517C FOREIGN KEY (order_ref_id) REFERENCES order_session (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F09DDC4978F FOREIGN KEY (mangas_id) REFERENCES manga (id)');
        $this->addSql('CREATE INDEX IDX_52EA1F09E238517C ON order_item (order_ref_id)');
        $this->addSql('CREATE INDEX IDX_52EA1F09DDC4978F ON order_item (mangas_id)');
        $this->addSql('ALTER TABLE order_session ADD status VARCHAR(255) NOT NULL, ADD created_at DATE NOT NULL, ADD updated_at DATE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE manga DROP price');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F09E238517C');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F09DDC4978F');
        $this->addSql('DROP INDEX IDX_52EA1F09E238517C ON order_item');
        $this->addSql('DROP INDEX IDX_52EA1F09DDC4978F ON order_item');
        $this->addSql('ALTER TABLE order_item DROP order_ref_id, DROP mangas_id, DROP quantity');
        $this->addSql('ALTER TABLE order_session DROP status, DROP created_at, DROP updated_at');
    }
}
