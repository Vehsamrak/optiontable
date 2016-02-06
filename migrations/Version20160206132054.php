<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160206132054 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE futures DROP FOREIGN KEY FK_F8A52F28C0F75674');
        $this->addSql('DROP INDEX IDX_F8A52F28C0F75674 ON futures');
        $this->addSql('ALTER TABLE futures CHANGE symbol_id symbol INT DEFAULT NULL');
        $this->addSql('ALTER TABLE futures ADD CONSTRAINT FK_F8A52F28ECC836F9 FOREIGN KEY (symbol) REFERENCES symbol (symbol)');
        $this->addSql('CREATE INDEX IDX_F8A52F28ECC836F9 ON futures (symbol)');
        $this->addSql('ALTER TABLE symbol MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX UNIQ_ECC836F9ECC836F9 ON symbol');
        $this->addSql('ALTER TABLE symbol DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE symbol DROP id, CHANGE symbol symbol INT NOT NULL');
        $this->addSql('ALTER TABLE symbol ADD PRIMARY KEY (symbol)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE futures DROP FOREIGN KEY FK_F8A52F28ECC836F9');
        $this->addSql('DROP INDEX IDX_F8A52F28ECC836F9 ON futures');
        $this->addSql('ALTER TABLE futures CHANGE symbol symbol_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE futures ADD CONSTRAINT FK_F8A52F28C0F75674 FOREIGN KEY (symbol_id) REFERENCES symbol (id)');
        $this->addSql('CREATE INDEX IDX_F8A52F28C0F75674 ON futures (symbol_id)');
        $this->addSql('ALTER TABLE symbol DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE symbol ADD id INT AUTO_INCREMENT NOT NULL, CHANGE symbol symbol VARCHAR(2) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ECC836F9ECC836F9 ON symbol (symbol)');
        $this->addSql('ALTER TABLE symbol ADD PRIMARY KEY (id)');
    }
}
