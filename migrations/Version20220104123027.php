<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220104123027 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question_bddcooking DROP FOREIGN KEY FK_DF75644EA76ED395');
        $this->addSql('DROP INDEX IDX_DF75644EA76ED395 ON question_bddcooking');
        $this->addSql('ALTER TABLE question_bddcooking DROP user_id, DROP validate');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question_bddcooking ADD user_id INT NOT NULL, ADD validate TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE question_bddcooking ADD CONSTRAINT FK_DF75644EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_DF75644EA76ED395 ON question_bddcooking (user_id)');
    }
}
