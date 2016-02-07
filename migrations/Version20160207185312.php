<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Symbol table filling
 */
class Version20160207185312 extends AbstractMigration
{

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $symbols = [
            // Energies
            'CL' => 10000,
            'HO' => 42000,
            'RB' => 42000,
            'NG' => 10000,
            'QA' => 1000,

            // Financials
            'GE' => 2500,

            // Grains
            'ZW' => 50,
            'ZC' => 50,
            'ZS' => 50,
            'ZM' => 100,
            'ZL' => 600,
            'ZO' => 50,
            'ZR' => 2000,
            'KE' => 50,
            'MW' => 50,
            'RS' => 20,

            // Indices
            'ES' => 50,
            'NQ' => 20,
            'YM' => 5,

            // Meats
            'LE' => 400,
            'GF' => 500,
            'HE' => 400,
            'DL' => 2000,

            // Metals
            'GC' => 100,
            'SI' => 5000,
            'HG' => 25000,
            'PL' => 50,
            'PA' => 100,

            // Softs
            'CT' => 500,
            'OJ' => 150,
            'KC' => 375,
            'SB' => 1120,
            'CC' => 10,
            'LS' => 110,
        ];

        foreach ($symbols as $symbol => $optionPointPrice) {
            $query = $this->connection->createQueryBuilder();

            $query->update('symbol', 's');
            $query->set('s.option_point_price', ':option_point_price');
            $query->where('s.symbol = :symbol');

            $query->setParameters([
                ':option_point_price' => $optionPointPrice,
                ':symbol'             => $symbol,
            ]);

            $query->execute();
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("UPDATE symbol SET option_point_price = NULL");
    }
}
