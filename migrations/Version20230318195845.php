<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230318195845 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fruit (nutritions_id INTEGER NOT NULL, "id" INTEGER NOT NULL, "genus" VARCHAR(255) NOT NULL, "name" VARCHAR(255) NOT NULL, "family" VARCHAR(255) NOT NULL, "order" VARCHAR(255) NOT NULL, PRIMARY KEY("id"), CONSTRAINT FK_A00BD297211D40C FOREIGN KEY (nutritions_id) REFERENCES nutritions (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A00BD297211D40C ON fruit (nutritions_id)');
        $this->addSql('CREATE TABLE nutritions (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "carbohydrates" DOUBLE PRECISION NOT NULL, "protein" DOUBLE PRECISION NOT NULL, "fat" DOUBLE PRECISION NOT NULL, "calories" DOUBLE PRECISION NOT NULL, "sugar" DOUBLE PRECISION NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE fruit');
        $this->addSql('DROP TABLE nutritions');
    }
}
