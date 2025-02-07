<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240000000002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create projections table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
            CREATE TABLE projections (
                no BIGSERIAL,
                name VARCHAR(150) NOT NULL,
                position JSONB,
                state JSONB,
                status VARCHAR(28) NOT NULL,
                locked_until CHAR(26),
                PRIMARY KEY (no),
                UNIQUE (name)
            );
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<SQL
            DROP TABLE projections;
        SQL);
    }
}
