<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230322085204 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE carts');
        $this->addSql('DROP TABLE odlusers');
        $this->addSql('DROP TABLE products');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE carts (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_user_id INTEGER NOT NULL, id_product_id INTEGER NOT NULL, quantity INTEGER NOT NULL, CONSTRAINT FK_4E004AAC79F37AE5 FOREIGN KEY (id_user_id) REFERENCES odlusers (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4E004AACE00EE68D FOREIGN KEY (id_product_id) REFERENCES products (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_4E004AACE00EE68D ON carts (id_product_id)');
        $this->addSql('CREATE INDEX IDX_4E004AAC79F37AE5 ON carts (id_user_id)');
        $this->addSql('CREATE TABLE odlusers (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE "BINARY", birthdate DATE DEFAULT NULL, type VARCHAR(255) NOT NULL COLLATE "BINARY", password VARCHAR(255) DEFAULT NULL COLLATE "BINARY")');
        $this->addSql('CREATE TABLE products (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE "BINARY", prix DOUBLE PRECISION NOT NULL, quantity INTEGER NOT NULL)');
    }
}
