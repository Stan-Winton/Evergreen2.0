<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240517090149 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        if (!$schema->getTable('comercios')->hasColumn('codigo_postal')) {
            $this->addSql('ALTER TABLE comercios ADD codigo_postal VARCHAR(5) NOT NULL');
        }
        $this->addSql('ALTER TABLE usuario DROP confirmation_token');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comercios DROP codigo_postal');
        $this->addSql('ALTER TABLE usuario ADD confirmation_token VARCHAR(255) DEFAULT NULL');
    }
}