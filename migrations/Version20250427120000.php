<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250427120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Agrega el campo entityId a la tabla auditoria para registrar el ID del registro afectado';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE auditoria ADD entity_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE auditoria DROP entity_id');
    }
}
