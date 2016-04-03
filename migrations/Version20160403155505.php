<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160403155505 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE trades DROP FOREIGN KEY fk_trades_option_price_low');
        $this->addSql('ALTER TABLE trades DROP FOREIGN KEY fk_trades_option_price_close');
        $this->addSql('ALTER TABLE trades DROP FOREIGN KEY fk_trades_option_price_high');
        $this->addSql('ALTER TABLE trades DROP FOREIGN KEY fk_trades_option_price_open');
        
        $this->addSql('ALTER TABLE trades ADD direction VARCHAR(4) NOT NULL, ADD volume INT NOT NULL');
        
        $this->addSql('DROP INDEX idx_trades_option_price_open ON trades');
        $this->addSql('CREATE INDEX IDX_BFA11125D922711E ON trades (price_open)');
        $this->addSql('DROP INDEX idx_trades_option_price_close ON trades');
        $this->addSql('CREATE INDEX IDX_BFA1112538C889A4 ON trades (price_close)');
        $this->addSql('DROP INDEX idx_trades_option_price_high ON trades');
        $this->addSql('CREATE INDEX IDX_BFA111258C5716EF ON trades (price_high)');
        $this->addSql('DROP INDEX idx_trades_option_price_low ON trades');
        $this->addSql('CREATE INDEX IDX_BFA11125C7E4732E ON trades (price_low)');
        
        $this->addSql('ALTER TABLE trades ADD CONSTRAINT fk_trades_option_price_low FOREIGN KEY (price_low) REFERENCES option_price (id)');
        $this->addSql('ALTER TABLE trades ADD CONSTRAINT fk_trades_option_price_close FOREIGN KEY (price_close) REFERENCES option_price (id)');
        $this->addSql('ALTER TABLE trades ADD CONSTRAINT fk_trades_option_price_high FOREIGN KEY (price_high) REFERENCES option_price (id)');
        $this->addSql('ALTER TABLE trades ADD CONSTRAINT fk_trades_option_price_open FOREIGN KEY (price_open) REFERENCES option_price (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE trades DROP FOREIGN KEY FK_BFA11125D922711E');
        $this->addSql('ALTER TABLE trades DROP FOREIGN KEY FK_BFA1112538C889A4');
        $this->addSql('ALTER TABLE trades DROP FOREIGN KEY FK_BFA111258C5716EF');
        $this->addSql('ALTER TABLE trades DROP FOREIGN KEY FK_BFA11125C7E4732E');
        $this->addSql('ALTER TABLE trades DROP direction, DROP volume');
        $this->addSql('DROP INDEX idx_bfa11125d922711e ON trades');
        $this->addSql('CREATE INDEX idx_trades_option_price_open ON trades (price_open)');
        $this->addSql('DROP INDEX idx_bfa1112538c889a4 ON trades');
        $this->addSql('CREATE INDEX idx_trades_option_price_close ON trades (price_close)');
        $this->addSql('DROP INDEX idx_bfa111258c5716ef ON trades');
        $this->addSql('CREATE INDEX idx_trades_option_price_high ON trades (price_high)');
        $this->addSql('DROP INDEX idx_bfa11125c7e4732e ON trades');
        $this->addSql('CREATE INDEX idx_trades_option_price_low ON trades (price_low)');
        $this->addSql('ALTER TABLE trades ADD CONSTRAINT FK_BFA11125D922711E FOREIGN KEY (price_open) REFERENCES option_price (id)');
        $this->addSql('ALTER TABLE trades ADD CONSTRAINT FK_BFA1112538C889A4 FOREIGN KEY (price_close) REFERENCES option_price (id)');
        $this->addSql('ALTER TABLE trades ADD CONSTRAINT FK_BFA111258C5716EF FOREIGN KEY (price_high) REFERENCES option_price (id)');
        $this->addSql('ALTER TABLE trades ADD CONSTRAINT FK_BFA11125C7E4732E FOREIGN KEY (price_low) REFERENCES option_price (id)');
    }
}
