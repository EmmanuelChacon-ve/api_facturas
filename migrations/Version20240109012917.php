<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240109012917 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE estado_cuenta DROP FOREIGN KEY FK_627ED7791C55BE39');
        $this->addSql('DROP INDEX IDX_627ED7791C55BE39 ON estado_cuenta');
        $this->addSql('ALTER TABLE estado_cuenta DROP facturas_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE estado_cuenta ADD facturas_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE estado_cuenta ADD CONSTRAINT FK_627ED7791C55BE39 FOREIGN KEY (facturas_id) REFERENCES factura (id)');
        $this->addSql('CREATE INDEX IDX_627ED7791C55BE39 ON estado_cuenta (facturas_id)');
    }
}
