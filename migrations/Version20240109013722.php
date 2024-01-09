<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240109013722 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE linea_factura DROP FOREIGN KEY FK_B8330A4EC9A8799A');
        $this->addSql('DROP INDEX IDX_B8330A4EC9A8799A ON linea_factura');
        $this->addSql('ALTER TABLE linea_factura DROP productoslinea_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE linea_factura ADD productoslinea_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE linea_factura ADD CONSTRAINT FK_B8330A4EC9A8799A FOREIGN KEY (productoslinea_id) REFERENCES producto (id)');
        $this->addSql('CREATE INDEX IDX_B8330A4EC9A8799A ON linea_factura (productoslinea_id)');
    }
}
