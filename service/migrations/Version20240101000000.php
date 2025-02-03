<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240101000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create event_streams table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
            CREATE TABLE event_streams (
                no BIGSERIAL,
                real_stream_name VARCHAR(150) NOT NULL,
                stream_name CHAR(41) NOT NULL,
                metadata JSONB,
                category VARCHAR(150),
                PRIMARY KEY (no),
                UNIQUE (stream_name)
            );
        SQL);
        $this->addSql(<<<SQL
            CREATE INDEX on event_streams (category);
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<SQL
            DROP TABLE event_streams;
        SQL);
    }
}
