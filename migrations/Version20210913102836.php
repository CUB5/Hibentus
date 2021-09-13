<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210913102836 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comentario ADD id_user_id INT NOT NULL, ADD id_evento_id INT NOT NULL');
        $this->addSql('ALTER TABLE comentario ADD CONSTRAINT FK_4B91E70279F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comentario ADD CONSTRAINT FK_4B91E7027904465 FOREIGN KEY (id_evento_id) REFERENCES evento (id)');
        $this->addSql('CREATE INDEX IDX_4B91E70279F37AE5 ON comentario (id_user_id)');
        $this->addSql('CREATE INDEX IDX_4B91E7027904465 ON comentario (id_evento_id)');
        $this->addSql('ALTER TABLE evento ADD id_user_id INT NOT NULL, ADD id_categoria_id INT DEFAULT NULL, ADD fecha_creacion DATETIME NOT NULL');
        $this->addSql('ALTER TABLE evento ADD CONSTRAINT FK_47860B0579F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE evento ADD CONSTRAINT FK_47860B0510560508 FOREIGN KEY (id_categoria_id) REFERENCES categoria (id)');
        $this->addSql('CREATE INDEX IDX_47860B0579F37AE5 ON evento (id_user_id)');
        $this->addSql('CREATE INDEX IDX_47860B0510560508 ON evento (id_categoria_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comentario DROP FOREIGN KEY FK_4B91E70279F37AE5');
        $this->addSql('ALTER TABLE comentario DROP FOREIGN KEY FK_4B91E7027904465');
        $this->addSql('DROP INDEX IDX_4B91E70279F37AE5 ON comentario');
        $this->addSql('DROP INDEX IDX_4B91E7027904465 ON comentario');
        $this->addSql('ALTER TABLE comentario DROP id_user_id, DROP id_evento_id');
        $this->addSql('ALTER TABLE evento DROP FOREIGN KEY FK_47860B0579F37AE5');
        $this->addSql('ALTER TABLE evento DROP FOREIGN KEY FK_47860B0510560508');
        $this->addSql('DROP INDEX IDX_47860B0579F37AE5 ON evento');
        $this->addSql('DROP INDEX IDX_47860B0510560508 ON evento');
        $this->addSql('ALTER TABLE evento DROP id_user_id, DROP id_categoria_id, DROP fecha_creacion');
    }
}
