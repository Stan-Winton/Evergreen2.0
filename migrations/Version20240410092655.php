<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240410092655 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE usuario ADD confirmation_token VARCHAR(255) DEFAULT NULL, CHANGE nombre nombre VARCHAR(20) NOT NULL, CHANGE direccion direccion VARCHAR(100) NOT NULL, CHANGE telefono telefono VARCHAR(9) NOT NULL, CHANGE fecha fecha DATE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE usuario DROP confirmation_token, CHANGE nombre nombre VARCHAR(255) NOT NULL, CHANGE direccion direccion VARCHAR(255) NOT NULL, CHANGE telefono telefono VARCHAR(255) NOT NULL, CHANGE fecha fecha DATETIME NOT NULL');
    }
}