<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191107165941 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->getTable('manager');
        $table->addColumn('code', 'string');
    }

    public function down(Schema $schema) : void
    {
        $table = $schema->getTable('manager');
        $table->dropColumn('code');
        }
}
