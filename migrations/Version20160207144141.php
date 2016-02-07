<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160207144141 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE symbol DROP name');
        $this->addSql('DROP INDEX idx_ ON `option`');
        $this->addSql('CREATE UNIQUE INDEX unique_option_type_strike ON `option` (type, strike)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX unique_option_type_strike ON `option`');
        $this->addSql('CREATE UNIQUE INDEX idx_ ON `option` (type, strike)');
        $this->addSql('ALTER TABLE symbol ADD name VARCHAR(64) NOT NULL COLLATE utf8_unicode_ci');
    }
}
