<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230723160821 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create coupon table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE "coupon_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "coupon" (
                id INT NOT NULL, 
                code VARCHAR(3) NOT NULL, 
                type INT NOT NULL,
                actual BOOLEAN NOT NULL DEFAULT TRUE, 
                PRIMARY KEY(id)
            )'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA IF NOT EXISTS public');
        $this->addSql('DROP TABLE "coupon"');
    }
}
