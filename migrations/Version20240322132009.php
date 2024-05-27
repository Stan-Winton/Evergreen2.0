<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240322132009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {

        
        // this up() migration is auto-generated, please modify it to your needs
        if (!$schema->hasTable('comercios')) {
            $this->addSql('CREATE TABLE comercios (id INT AUTO_INCREMENT NOT NULL, id_comercio INT NOT NULL, cif VARCHAR(9) NOT NULL, nombre_comercio VARCHAR(20) NOT NULL, descripcion VARCHAR(255) NOT NULL, direccion_comercio VARCHAR(100) NOT NULL, telefono VARCHAR(9) NOT NULL, razon_social VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        }

        if (!$schema->hasTable('pedidos')) {
            $this->addSql('CREATE TABLE pedidos (id INT AUTO_INCREMENT NOT NULL, comercios_id INT DEFAULT NULL, usuario_id INT DEFAULT NULL, estado TINYINT(1) NOT NULL, fecha DATE NOT NULL, INDEX IDX_6716CCAA55E03C89 (comercios_id), INDEX IDX_6716CCAADB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        }

        if (!$schema->hasTable('productos')) {
            $this->addSql('CREATE TABLE productos (id INT AUTO_INCREMENT NOT NULL, comercios_id INT DEFAULT NULL, categoria_id INT DEFAULT NULL, nombre VARCHAR(20) NOT NULL, precio INT NOT NULL, descripcion VARCHAR(255) NOT NULL, stock INT NOT NULL, INDEX IDX_767490E655E03C89 (comercios_id), UNIQUE INDEX UNIQ_767490E63397707A (categoria_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        }

        if (!$schema->hasTable('productos_pedidos')) {
            $this->addSql('CREATE TABLE productos_pedidos (productos_id INT NOT NULL, pedidos_id INT NOT NULL, INDEX IDX_5F082DB5ED07566B (productos_id), INDEX IDX_5F082DB5213530F2 (pedidos_id), PRIMARY KEY(productos_id, pedidos_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        }

        if (!$schema->hasTable('usuario')) {
            $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, comercios_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nombre VARCHAR(20) NOT NULL, direccion VARCHAR(100) NOT NULL, telefono VARCHAR(9) NOT NULL, fecha DATE NOT NULL, rol TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_2265B05DE7927C74 (email), INDEX IDX_2265B05D55E03C89 (comercios_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        }

        if (!$schema->hasTable('valoraciones')) {
            $this->addSql('CREATE TABLE valoraciones (id INT AUTO_INCREMENT NOT NULL, productos_id INT DEFAULT NULL, usuario_id INT DEFAULT NULL, estrellas INT NOT NULL, INDEX IDX_40850667ED07566B (productos_id), INDEX IDX_40850667DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        }

        if (!$schema->hasTable('messenger_messages')) {
            $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        }

        $this->addSql('ALTER TABLE pedidos ADD CONSTRAINT FK_6716CCAA55E03C89_'.uniqid().' FOREIGN KEY (comercios_id) REFERENCES comercios (id)');
        $this->addSql('ALTER TABLE pedidos ADD CONSTRAINT FK_6716CCAADB38439E_'.uniqid().' FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE productos ADD CONSTRAINT FK_767490E655E03C89_'.uniqid().' FOREIGN KEY (comercios_id) REFERENCES comercios (id)');
        $this->addSql('ALTER TABLE productos_pedidos ADD CONSTRAINT FK_5F082DB5ED07566B_'.uniqid().' FOREIGN KEY (productos_id) REFERENCES productos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE productos_pedidos ADD CONSTRAINT FK_5F082DB5213530F2_'.uniqid().' FOREIGN KEY (pedidos_id) REFERENCES pedidos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE usuario ADD CONSTRAINT FK_2265B05D55E03C89_'.uniqid().' FOREIGN KEY (comercios_id) REFERENCES comercios (id)');
        $this->addSql('ALTER TABLE valoraciones ADD CONSTRAINT FK_40850667ED07566B_'.uniqid().' FOREIGN KEY (productos_id) REFERENCES productos (id)');
        $this->addSql('ALTER TABLE valoraciones ADD CONSTRAINT FK_40850667DB38439E_'.uniqid().' FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pedidos DROP FOREIGN KEY FK_6716CCAA55E03C89');
        $this->addSql('ALTER TABLE pedidos DROP FOREIGN KEY FK_6716CCAADB38439E');
        $this->addSql('ALTER TABLE productos DROP FOREIGN KEY FK_767490E655E03C89');
        $this->addSql('ALTER TABLE productos DROP FOREIGN KEY FK_767490E63397707A');
        $this->addSql('ALTER TABLE productos_pedidos DROP FOREIGN KEY FK_5F082DB5ED07566B');
        $this->addSql('ALTER TABLE productos_pedidos DROP FOREIGN KEY FK_5F082DB5213530F2');
        $this->addSql('ALTER TABLE usuario DROP FOREIGN KEY FK_2265B05D55E03C89');
        $this->addSql('ALTER TABLE valoraciones DROP FOREIGN KEY FK_40850667ED07566B');
        $this->addSql('ALTER TABLE valoraciones DROP FOREIGN KEY FK_40850667DB38439E');
        $this->addSql('DROP TABLE comercios');
        $this->addSql('DROP TABLE pedidos');
        $this->addSql('DROP TABLE productos');
        $this->addSql('DROP TABLE productos_pedidos');
        $this->addSql('DROP TABLE usuario');
        $this->addSql('DROP TABLE valoraciones');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
