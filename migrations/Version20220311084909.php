<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220311084909 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE entrada (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, titulo VARCHAR(255) NOT NULL, contenido VARCHAR(255) NOT NULL, fecha VARCHAR(255) NOT NULL, INDEX IDX_C949A274DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mensaje (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, entrada_id INT NOT NULL, contenido VARCHAR(255) NOT NULL, fecha VARCHAR(255) NOT NULL, INDEX IDX_9B631D01DB38439E (usuario_id), INDEX IDX_9B631D01A688222A (entrada_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE entrada ADD CONSTRAINT FK_C949A274DB38439E FOREIGN KEY (usuario_id) REFERENCES usuarios (id)');
        $this->addSql('ALTER TABLE mensaje ADD CONSTRAINT FK_9B631D01DB38439E FOREIGN KEY (usuario_id) REFERENCES usuarios (id)');
        $this->addSql('ALTER TABLE mensaje ADD CONSTRAINT FK_9B631D01A688222A FOREIGN KEY (entrada_id) REFERENCES entrada (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mensaje DROP FOREIGN KEY FK_9B631D01A688222A');
        $this->addSql('DROP TABLE entrada');
        $this->addSql('DROP TABLE mensaje');
    }
}
