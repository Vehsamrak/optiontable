<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20160403181158 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("UPDATE `symbol` SET `option_point_price`=1000 WHERE  `symbol`='CL';");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("UPDATE `symbol` SET `option_point_price`=10000 WHERE  `symbol`='CL';");

    }
}
