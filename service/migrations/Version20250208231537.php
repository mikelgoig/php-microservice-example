<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250208231537 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create read.books_tags table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
            CREATE SCHEMA IF NOT EXISTS read;
        SQL);
        $this->addSql(<<<SQL
            CREATE TABLE read.books_tags (
                book_id UUID NOT NULL,
                tag_id UUID NOT NULL,
                PRIMARY KEY(book_id, tag_id)
            );
        SQL);
        $this->addSql(<<<SQL
            CREATE INDEX IDX_F213259C16A2B381 ON read.books_tags (book_id);
        SQL);
        $this->addSql(<<<SQL
            CREATE INDEX IDX_F213259CBAD26311 ON read.books_tags (tag_id);
        SQL);
        $this->addSql(<<<SQL
            COMMENT ON COLUMN read.books_tags.book_id IS '(DC2Type:uuid)';
        SQL);
        $this->addSql(<<<SQL
            COMMENT ON COLUMN read.books_tags.tag_id IS '(DC2Type:uuid)';
        SQL);
        $this->addSql(<<<SQL
            ALTER TABLE read.books_tags ADD CONSTRAINT FK_F213259C16A2B381 FOREIGN KEY (book_id) REFERENCES read.books (id) NOT DEFERRABLE INITIALLY IMMEDIATE;
        SQL);
        $this->addSql(<<<SQL
            ALTER TABLE read.books_tags ADD CONSTRAINT FK_F213259CBAD26311 FOREIGN KEY (tag_id) REFERENCES read.tags (id) NOT DEFERRABLE INITIALLY IMMEDIATE;
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<SQL
            ALTER TABLE read.books_tags DROP CONSTRAINT FK_F213259C16A2B381;
        SQL);
        $this->addSql(<<<SQL
            ALTER TABLE read.books_tags DROP CONSTRAINT FK_F213259CBAD26311;
        SQL);
        $this->addSql(<<<SQL
            DROP TABLE read.books_tags;
        SQL);
    }
}
