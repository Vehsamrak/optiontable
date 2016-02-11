<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160211213220 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE option_price DROP FOREIGN KEY FK_F3239FB1E4BFBD9A');
        $this->addSql('DROP INDEX IDX_F3239FB1E4BFBD9A ON option_price');
        $this->addSql('ALTER TABLE option_price DROP futures_id');
        $this->addSql('DROP INDEX unique_option_type_strike ON option_contract');
        $this->addSql('ALTER TABLE option_contract ADD futures_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE option_contract ADD CONSTRAINT FK_C9F859FDE4BFBD9A FOREIGN KEY (futures_id) REFERENCES futures (id)');
        $this->addSql('CREATE INDEX IDX_C9F859FDE4BFBD9A ON option_contract (futures_id)');
        $this->addSql('CREATE UNIQUE INDEX unique_option_type_futures_strike ON option_contract (type, futures_id, strike)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE option_contract DROP FOREIGN KEY FK_C9F859FDE4BFBD9A');
        $this->addSql('DROP INDEX IDX_C9F859FDE4BFBD9A ON option_contract');
        $this->addSql('DROP INDEX unique_option_type_futures_strike ON option_contract');
        $this->addSql('ALTER TABLE option_contract DROP futures_id');
        $this->addSql('CREATE UNIQUE INDEX unique_option_type_strike ON option_contract (type, strike)');
        $this->addSql('ALTER TABLE option_price ADD futures_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE option_price ADD CONSTRAINT FK_F3239FB1E4BFBD9A FOREIGN KEY (futures_id) REFERENCES futures (id)');
        $this->addSql('CREATE INDEX IDX_F3239FB1E4BFBD9A ON option_price (futures_id)');
    }
}
