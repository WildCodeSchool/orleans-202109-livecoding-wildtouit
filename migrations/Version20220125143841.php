<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220125143841 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE touit ADD recipient_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE touit ADD CONSTRAINT FK_18589937E92F8F78 FOREIGN KEY (recipient_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_18589937E92F8F78 ON touit (recipient_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE touit DROP FOREIGN KEY FK_18589937E92F8F78');
        $this->addSql('DROP INDEX IDX_18589937E92F8F78 ON touit');
        $this->addSql('ALTER TABLE touit DROP recipient_id');
    }
}
