<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210914102157 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE participante (id INT AUTO_INCREMENT NOT NULL, id_evento_id INT NOT NULL, id_usuario_id INT NOT NULL, INDEX IDX_85BDC5C37904465 (id_evento_id), INDEX IDX_85BDC5C37EB2C349 (id_usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE participante ADD CONSTRAINT FK_85BDC5C37904465 FOREIGN KEY (id_evento_id) REFERENCES evento (id)');
        $this->addSql('ALTER TABLE participante ADD CONSTRAINT FK_85BDC5C37EB2C349 FOREIGN KEY (id_usuario_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE participante');
    }
}
