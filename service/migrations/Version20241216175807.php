<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241216175807 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create books table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE books (id_primary SERIAL NOT NULL, id UUID NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id_primary))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4A1B2A92BF396750 ON books (id)');
        $this->addSql('COMMENT ON COLUMN books.id IS \'(DC2Type:uuid)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE books');
    }
}
