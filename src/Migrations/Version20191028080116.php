<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Entity\Manager;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191028080116 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
//        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
//
//        $this->addSql('ALTER TABLE manager ADD email VARCHAR(255) DEFAULT \'test@test.test\' NOT NULL, CHANGE branch_id branch_id INT DEFAULT NULL');

        $table = $schema->getTable('manager');
        $table->addColumn('email', 'string', ['notnull' => true]);
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
//        $this->abortIf($this->connection->getDatabaseP2019latform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
//
//        $this->addSql('ALTER TABLE manager DROP email, CHANGE branch_id branch_id INT NOT NULL');
        $table = $schema->getTable('manager');
        $table->dropColumn('email');
    }
}
