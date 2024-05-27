<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240516084747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        if (!$schema->getTable('productos')->hasColumn('imagen')) {
            $this->addSql('ALTER TABLE productos ADD imagen VARCHAR(255) DEFAULT NULL');
        }
        if ($schema->getTable('usuario')->hasColumn('rol')) {
            $this->addSql('ALTER TABLE usuario DROP rol');
        }
        if ($schema->getTable('usuario')->hasColumn('imagen')) {
            $this->addSql('ALTER TABLE usuario DROP imagen');
        }
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        if ($schema->getTable('productos')->hasColumn('imagen')) {
            $this->addSql('ALTER TABLE productos DROP imagen');
        }
        if (!$schema->getTable('usuario')->hasColumn('rol')) {
            $this->addSql('ALTER TABLE usuario ADD rol TINYINT(1) NOT NULL');
        }
        if (!$schema->getTable('usuario')->hasColumn('imagen')) {
            $this->addSql('ALTER TABLE usuario ADD imagen VARCHAR(255) DEFAULT NULL');
        }
    }
}