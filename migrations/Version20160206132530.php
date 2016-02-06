<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160206132530 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE futures (id INT AUTO_INCREMENT NOT NULL, symbol VARCHAR(2) DEFAULT NULL, name VARCHAR(255) NOT NULL, option_point_price INT NOT NULL, expiration DATETIME NOT NULL, INDEX IDX_F8A52F28ECC836F9 (symbol), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE symbol (symbol VARCHAR(2) NOT NULL, PRIMARY KEY(symbol)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE option_price (id INT AUTO_INCREMENT NOT NULL, futures_id INT DEFAULT NULL, date DATETIME NOT NULL, option_price DOUBLE PRECISION NOT NULL, option_contract VARCHAR(255) NOT NULL, futures_price DOUBLE PRECISION NOT NULL, futures_price52week_high DOUBLE PRECISION NOT NULL, futures_price52week_low DOUBLE PRECISION NOT NULL, INDEX IDX_F3239FB1E4BFBD9A (futures_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `option` (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(4) NOT NULL, strike DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE futures ADD CONSTRAINT FK_F8A52F28ECC836F9 FOREIGN KEY (symbol) REFERENCES symbol (symbol)');
        $this->addSql('ALTER TABLE option_price ADD CONSTRAINT FK_F3239FB1E4BFBD9A FOREIGN KEY (futures_id) REFERENCES futures (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE option_price DROP FOREIGN KEY FK_F3239FB1E4BFBD9A');
        $this->addSql('ALTER TABLE futures DROP FOREIGN KEY FK_F8A52F28ECC836F9');
        $this->addSql('DROP TABLE futures');
        $this->addSql('DROP TABLE symbol');
        $this->addSql('DROP TABLE option_price');
        $this->addSql('DROP TABLE `option`');
    }
}
