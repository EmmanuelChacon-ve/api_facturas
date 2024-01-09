<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240109013340 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE factura DROP FOREIGN KEY FK_F9EBA0096C517279');
        $this->addSql('DROP INDEX IDX_F9EBA0096C517279 ON factura');
        $this->addSql('ALTER TABLE factura DROP cliente_factura_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE factura ADD cliente_factura_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE factura ADD CONSTRAINT FK_F9EBA0096C517279 FOREIGN KEY (cliente_factura_id) REFERENCES cliente (id)');
        $this->addSql('CREATE INDEX IDX_F9EBA0096C517279 ON factura (cliente_factura_id)');
    }
}
