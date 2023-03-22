<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230322085414 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE carts (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_user_id INTEGER NOT NULL, id_product_id INTEGER NOT NULL, quantity INTEGER NOT NULL, CONSTRAINT FK_4E004AAC79F37AE5 FOREIGN KEY (id_user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4E004AACE00EE68D FOREIGN KEY (id_product_id) REFERENCES products (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_4E004AAC79F37AE5 ON carts (id_user_id)');
        $this->addSql('CREATE INDEX IDX_4E004AACE00EE68D ON carts (id_product_id)');
        $this->addSql('CREATE TABLE products (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, quantity INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9F85E0677 ON users (username)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE carts');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE users');
    }
}
