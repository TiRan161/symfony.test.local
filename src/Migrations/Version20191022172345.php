<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191022172345 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('branch');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('name', 'string');
        $table->setPrimaryKey(['id']);

        $table = $schema->createTable('manager');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('name', 'string');
        $table->addColumn('surname', 'string');
        $table->addColumn('branch_id', 'integer');
        $table->setPrimaryKey(['id']);
        $table->addForeignKeyConstraint($schema->getTable('branch'), ['branch_id'], ['id'], ['NO ACTION', 'RESTRICT'], 'fk_manager_branch');


    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('manager');
        $schema->dropTable('branch');
    }
}
