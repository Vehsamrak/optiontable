<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160206022318 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('
            CREATE TABLE `option` (
                id INT AUTO_INCREMENT NOT NULL,
                futures_id INT DEFAULT NULL,
                type VARCHAR(4) NOT NULL,
                strike DOUBLE PRECISION NOT NULL,
                INDEX IDX_5A8600B0E4BFBD9A (futures_id),
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB);
        ');

        $this->addSql('
            ALTER TABLE `option`
            ADD CONSTRAINT FK_5A8600B0E4BFBD9A
            FOREIGN KEY (futures_id) REFERENCES futures (id)
        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE `option`');
    }
}
