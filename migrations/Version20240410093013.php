<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240410093013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        if (!$schema->getTable('usuario')->hasColumn('confirmation_token')) {
            $this->addSql('ALTER TABLE usuario ADD confirmation_token VARCHAR(255) DEFAULT NULL');
        }
        $this->addSql('ALTER TABLE usuario CHANGE nombre nombre VARCHAR(20) NOT NULL, CHANGE direccion direccion VARCHAR(100) NOT NULL, CHANGE telefono telefono VARCHAR(9) NOT NULL, CHANGE fecha fecha DATE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        if ($schema->getTable('usuario')->hasColumn('confirmation_token')) {
            $this->addSql('ALTER TABLE usuario DROP confirmation_token');
        }
        $this->addSql('ALTER TABLE usuario CHANGE nombre nombre VARCHAR(255) NOT NULL, CHANGE direccion direccion VARCHAR(255) NOT NULL, CHANGE telefono telefono VARCHAR(255) NOT NULL, CHANGE fecha fecha DATETIME NOT NULL');
    }
}