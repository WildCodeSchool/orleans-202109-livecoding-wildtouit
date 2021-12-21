<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211220162032 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE touit ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE touit ADD CONSTRAINT FK_18589937A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_18589937A76ED395 ON touit (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE touit DROP FOREIGN KEY FK_18589937A76ED395');
        $this->addSql('DROP INDEX IDX_18589937A76ED395 ON touit');
        $this->addSql('ALTER TABLE touit DROP user_id');
    }
}
