<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230723160803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create product table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE "product_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "product" (
                id INT NOT NULL, 
                name VARCHAR(255) NOT NULL, 
                price NUMERIC(5,2) NOT NULL, 
                PRIMARY KEY(id)
            )'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA IF NOT EXISTS public');
        $this->addSql('DROP TABLE "product"');
    }
}
