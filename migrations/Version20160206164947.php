<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160206164947 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE option_price ADD option_contract_id INT DEFAULT NULL, DROP option_contract');
        $this->addSql('ALTER TABLE option_price ADD CONSTRAINT FK_F3239FB1342B949 FOREIGN KEY (option_contract_id) REFERENCES `option` (id)');
        $this->addSql('CREATE INDEX IDX_F3239FB1342B949 ON option_price (option_contract_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE option_price DROP FOREIGN KEY FK_F3239FB1342B949');
        $this->addSql('DROP INDEX IDX_F3239FB1342B949 ON option_price');
        $this->addSql('ALTER TABLE option_price ADD option_contract VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, DROP option_contract_id');
    }
}
