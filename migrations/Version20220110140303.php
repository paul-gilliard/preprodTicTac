<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220110140303 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE question_bddcompagny (id INT AUTO_INCREMENT NOT NULL, intitule_question VARCHAR(255) NOT NULL, reponse VARCHAR(255) NOT NULL, numero_question INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question_validee_compagny (id INT AUTO_INCREMENT NOT NULL, id_user_id INT DEFAULT NULL, id_question_valide_id INT DEFAULT NULL, INDEX IDX_13A99DFD79F37AE5 (id_user_id), INDEX IDX_13A99DFD69A14A7D (id_question_valide_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE question_validee_compagny ADD CONSTRAINT FK_13A99DFD79F37AE5 FOREIGN KEY (id_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE question_validee_compagny ADD CONSTRAINT FK_13A99DFD69A14A7D FOREIGN KEY (id_question_valide_id) REFERENCES question_bddcompagny (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question_validee_compagny DROP FOREIGN KEY FK_13A99DFD69A14A7D');
        $this->addSql('DROP TABLE question_bddcompagny');
        $this->addSql('DROP TABLE question_validee_compagny');
    }
}
