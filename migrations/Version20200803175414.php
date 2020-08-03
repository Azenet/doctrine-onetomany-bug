<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200803175414 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bar (id INT AUTO_INCREMENT NOT NULL, foo_id INT NOT NULL, INDEX IDX_76FF8CAA8E48560F (foo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE baz (id INT AUTO_INCREMENT NOT NULL, foo_id INT DEFAULT NULL, INDEX IDX_782404988E48560F (foo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE foo (id INT AUTO_INCREMENT NOT NULL, expected_bars INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bar ADD CONSTRAINT FK_76FF8CAA8E48560F FOREIGN KEY (foo_id) REFERENCES foo (id)');
        $this->addSql('ALTER TABLE baz ADD CONSTRAINT FK_782404988E48560F FOREIGN KEY (foo_id) REFERENCES foo (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bar DROP FOREIGN KEY FK_76FF8CAA8E48560F');
        $this->addSql('ALTER TABLE baz DROP FOREIGN KEY FK_782404988E48560F');
        $this->addSql('DROP TABLE bar');
        $this->addSql('DROP TABLE baz');
        $this->addSql('DROP TABLE foo');
    }
}
