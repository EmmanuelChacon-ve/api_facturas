<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240109011704 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cliente (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(20) NOT NULL, address VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE estado_cuenta (id INT AUTO_INCREMENT NOT NULL, factura_id INT DEFAULT NULL, facturas_id INT DEFAULT NULL, saldo_actual NUMERIC(5, 0) NOT NULL, monto_pagado NUMERIC(5, 0) NOT NULL, monto_pendiente NUMERIC(5, 0) NOT NULL, create_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', update_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delete_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_627ED779F04F795F (factura_id), INDEX IDX_627ED7791C55BE39 (facturas_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE factura (id INT AUTO_INCREMENT NOT NULL, cliente_id INT DEFAULT NULL, cliente_factura_id INT DEFAULT NULL, numfactura VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', update_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delete_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_F9EBA009DE734E51 (cliente_id), INDEX IDX_F9EBA0096C517279 (cliente_factura_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE linea_factura (id INT AUTO_INCREMENT NOT NULL, factura_id INT DEFAULT NULL, producto_id INT DEFAULT NULL, productoslinea_id INT DEFAULT NULL, cantidad INT NOT NULL, precio_unitario NUMERIC(5, 0) NOT NULL, subtotal NUMERIC(5, 0) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', update_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delete_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_B8330A4EF04F795F (factura_id), INDEX IDX_B8330A4E7645698E (producto_id), INDEX IDX_B8330A4EC9A8799A (productoslinea_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pago (id INT AUTO_INCREMENT NOT NULL, factura_id INT DEFAULT NULL, monto NUMERIC(5, 0) NOT NULL, metodo_pago VARCHAR(255) NOT NULL, create_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', update_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delete_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_F4DF5F3EF04F795F (factura_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE producto (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, precio NUMERIC(5, 0) NOT NULL, create_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', update_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delete_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE estado_cuenta ADD CONSTRAINT FK_627ED779F04F795F FOREIGN KEY (factura_id) REFERENCES factura (id)');
        $this->addSql('ALTER TABLE estado_cuenta ADD CONSTRAINT FK_627ED7791C55BE39 FOREIGN KEY (facturas_id) REFERENCES factura (id)');
        $this->addSql('ALTER TABLE factura ADD CONSTRAINT FK_F9EBA009DE734E51 FOREIGN KEY (cliente_id) REFERENCES cliente (id)');
        $this->addSql('ALTER TABLE factura ADD CONSTRAINT FK_F9EBA0096C517279 FOREIGN KEY (cliente_factura_id) REFERENCES cliente (id)');
        $this->addSql('ALTER TABLE linea_factura ADD CONSTRAINT FK_B8330A4EF04F795F FOREIGN KEY (factura_id) REFERENCES factura (id)');
        $this->addSql('ALTER TABLE linea_factura ADD CONSTRAINT FK_B8330A4E7645698E FOREIGN KEY (producto_id) REFERENCES producto (id)');
        $this->addSql('ALTER TABLE linea_factura ADD CONSTRAINT FK_B8330A4EC9A8799A FOREIGN KEY (productoslinea_id) REFERENCES producto (id)');
        $this->addSql('ALTER TABLE pago ADD CONSTRAINT FK_F4DF5F3EF04F795F FOREIGN KEY (factura_id) REFERENCES factura (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE estado_cuenta DROP FOREIGN KEY FK_627ED779F04F795F');
        $this->addSql('ALTER TABLE estado_cuenta DROP FOREIGN KEY FK_627ED7791C55BE39');
        $this->addSql('ALTER TABLE factura DROP FOREIGN KEY FK_F9EBA009DE734E51');
        $this->addSql('ALTER TABLE factura DROP FOREIGN KEY FK_F9EBA0096C517279');
        $this->addSql('ALTER TABLE linea_factura DROP FOREIGN KEY FK_B8330A4EF04F795F');
        $this->addSql('ALTER TABLE linea_factura DROP FOREIGN KEY FK_B8330A4E7645698E');
        $this->addSql('ALTER TABLE linea_factura DROP FOREIGN KEY FK_B8330A4EC9A8799A');
        $this->addSql('ALTER TABLE pago DROP FOREIGN KEY FK_F4DF5F3EF04F795F');
        $this->addSql('DROP TABLE cliente');
        $this->addSql('DROP TABLE estado_cuenta');
        $this->addSql('DROP TABLE factura');
        $this->addSql('DROP TABLE linea_factura');
        $this->addSql('DROP TABLE pago');
        $this->addSql('DROP TABLE producto');
    }
}
