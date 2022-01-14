<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220110113440 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE question_validee_museum (id INT AUTO_INCREMENT NOT NULL, id_user_id INT DEFAULT NULL, id_question_valide_id INT DEFAULT NULL, INDEX IDX_AE792C9679F37AE5 (id_user_id), INDEX IDX_AE792C9669A14A7D (id_question_valide_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE question_validee_museum ADD CONSTRAINT FK_AE792C9679F37AE5 FOREIGN KEY (id_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE question_validee_museum ADD CONSTRAINT FK_AE792C9669A14A7D FOREIGN KEY (id_question_valide_id) REFERENCES question_bddmuseum (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE question_validee_museum');
    }
}
