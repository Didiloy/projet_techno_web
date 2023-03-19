<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230319145154 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__carts AS SELECT id, id_user_id, quantity FROM carts');
        $this->addSql('DROP TABLE carts');
        $this->addSql('CREATE TABLE carts (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_user_id INTEGER NOT NULL, id_product_id INTEGER NOT NULL, quantity INTEGER NOT NULL, CONSTRAINT FK_4E004AAC79F37AE5 FOREIGN KEY (id_user_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4E004AACE00EE68D FOREIGN KEY (id_product_id) REFERENCES products (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO carts (id, id_user_id, quantity) SELECT id, id_user_id, quantity FROM __temp__carts');
        $this->addSql('DROP TABLE __temp__carts');
        $this->addSql('CREATE INDEX IDX_4E004AAC79F37AE5 ON carts (id_user_id)');
        $this->addSql('CREATE INDEX IDX_4E004AACE00EE68D ON carts (id_product_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__products AS SELECT id, name, prix, quantity FROM products');
        $this->addSql('DROP TABLE products');
        $this->addSql('CREATE TABLE products (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, quantity INTEGER NOT NULL)');
        $this->addSql('INSERT INTO products (id, name, prix, quantity) SELECT id, name, prix, quantity FROM __temp__products');
        $this->addSql('DROP TABLE __temp__products');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__carts AS SELECT id, id_user_id, quantity FROM carts');
        $this->addSql('DROP TABLE carts');
        $this->addSql('CREATE TABLE carts (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_user_id INTEGER NOT NULL, quantity INTEGER NOT NULL, CONSTRAINT FK_4E004AAC79F37AE5 FOREIGN KEY (id_user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO carts (id, id_user_id, quantity) SELECT id, id_user_id, quantity FROM __temp__carts');
        $this->addSql('DROP TABLE __temp__carts');
        $this->addSql('CREATE INDEX IDX_4E004AAC79F37AE5 ON carts (id_user_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__products AS SELECT id, name, prix, quantity FROM products');
        $this->addSql('DROP TABLE products');
        $this->addSql('CREATE TABLE products (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, cart_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, quantity INTEGER NOT NULL, CONSTRAINT FK_B3BA5A5A1AD5CDBF FOREIGN KEY (cart_id) REFERENCES carts (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO products (id, name, prix, quantity) SELECT id, name, prix, quantity FROM __temp__products');
        $this->addSql('DROP TABLE __temp__products');
        $this->addSql('CREATE INDEX IDX_B3BA5A5A1AD5CDBF ON products (cart_id)');
    }
}
