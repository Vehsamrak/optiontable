<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160206131637 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE futures ADD symbol_id INT DEFAULT NULL, DROP symbol');
        $this->addSql('ALTER TABLE futures ADD CONSTRAINT FK_F8A52F28C0F75674 FOREIGN KEY (symbol_id) REFERENCES symbol (id)');
        $this->addSql('CREATE INDEX IDX_F8A52F28C0F75674 ON futures (symbol_id)');
        $this->addSql('DROP INDEX idx_symbol_symbol ON symbol');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ECC836F9ECC836F9 ON symbol (symbol)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE futures DROP FOREIGN KEY FK_F8A52F28C0F75674');
        $this->addSql('DROP INDEX IDX_F8A52F28C0F75674 ON futures');
        $this->addSql('ALTER TABLE futures ADD symbol VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, DROP symbol_id');
        $this->addSql('DROP INDEX uniq_ecc836f9ecc836f9 ON symbol');
        $this->addSql('CREATE UNIQUE INDEX idx_symbol_symbol ON symbol (symbol)');
    }
}
