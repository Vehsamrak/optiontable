<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20160403140931 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE trades (
                id INT AUTO_INCREMENT NOT NULL, 
                price_open INT NOT NULL, 
                price_close INT DEFAULT NULL, 
                price_high INT NOT NULL, 
                price_low INT NOT NULL, 
                INDEX idx_trades_option_price_open (price_open), 
                INDEX idx_trades_option_price_close (price_close), 
                INDEX idx_trades_option_price_high (price_high), 
                INDEX idx_trades_option_price_low (price_low), 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        
        $this->addSql('ALTER TABLE trades ADD CONSTRAINT fk_trades_option_price_open FOREIGN KEY (price_open) REFERENCES option_price (id)');
        $this->addSql('ALTER TABLE trades ADD CONSTRAINT fk_trades_option_price_close FOREIGN KEY (price_close) REFERENCES option_price (id)');
        $this->addSql('ALTER TABLE trades ADD CONSTRAINT fk_trades_option_price_high FOREIGN KEY (price_high) REFERENCES option_price (id)');
        $this->addSql('ALTER TABLE trades ADD CONSTRAINT fk_trades_option_price_low FOREIGN KEY (price_low) REFERENCES option_price (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE trades');
    }
}
