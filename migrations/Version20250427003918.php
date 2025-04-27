<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250427003918 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE auditoria (id INT AUTO_INCREMENT NOT NULL, user VARCHAR(255) NOT NULL, entity VARCHAR(255) NOT NULL, actiontype VARCHAR(255) NOT NULL, datetime DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE empleado (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, birthdate DATE NOT NULL, salary DOUBLE PRECISION NOT NULL, contractdate DATE NOT NULL, status TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE proyecto (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, initdate DATE NOT NULL, finishdate DATE NOT NULL, no VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE proyecto_empleado (proyecto_id INT NOT NULL, empleado_id INT NOT NULL, INDEX IDX_9405246AF625D1BA (proyecto_id), INDEX IDX_9405246A952BE730 (empleado_id), PRIMARY KEY(proyecto_id, empleado_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE proyecto_empleado ADD CONSTRAINT FK_9405246AF625D1BA FOREIGN KEY (proyecto_id) REFERENCES proyecto (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE proyecto_empleado ADD CONSTRAINT FK_9405246A952BE730 FOREIGN KEY (empleado_id) REFERENCES empleado (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE proyecto_empleado DROP FOREIGN KEY FK_9405246AF625D1BA
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE proyecto_empleado DROP FOREIGN KEY FK_9405246A952BE730
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE auditoria
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE empleado
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE proyecto
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE proyecto_empleado
        SQL);
    }
}
