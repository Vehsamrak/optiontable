<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160206025504 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE option_price (id INT AUTO_INCREMENT NOT NULL, futures_id INT DEFAULT NULL, date DATETIME NOT NULL, option_price DOUBLE PRECISION NOT NULL, option_contract VARCHAR(255) NOT NULL, futures_price DOUBLE PRECISION NOT NULL, futures_price52week_high DOUBLE PRECISION NOT NULL, futures_price52week_low DOUBLE PRECISION NOT NULL, INDEX IDX_F3239FB1E4BFBD9A (futures_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE option_price ADD CONSTRAINT FK_F3239FB1E4BFBD9A FOREIGN KEY (futures_id) REFERENCES futures (id)');
        $this->addSql('ALTER TABLE `option` DROP FOREIGN KEY FK_5A8600B0E4BFBD9A');
        $this->addSql('DROP INDEX IDX_5A8600B0E4BFBD9A ON `option`');
        $this->addSql('ALTER TABLE `option` DROP futures_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE option_price');
        $this->addSql('ALTER TABLE `option` ADD futures_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `option` ADD CONSTRAINT FK_5A8600B0E4BFBD9A FOREIGN KEY (futures_id) REFERENCES futures (id)');
        $this->addSql('CREATE INDEX IDX_5A8600B0E4BFBD9A ON `option` (futures_id)');
    }
}
