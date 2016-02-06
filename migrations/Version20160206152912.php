<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Symbol dictionary filling
 */
class Version20160206152912 extends AbstractMigration
{

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $symbols = [
            // Energies
            'CL' => 'Crude_Oil_WTI_Futures',
            'HO' => 'ULSD_NY_Harbor_Futures',
            'RB' => 'Gasoline_RBOB_Futures',
            'NG' => 'Natural_Gas_Futures',
            'QA' => 'Crude_Oil_Brent_(F)_Futures',
            'ZK' => 'Ethanol_Futures_Futures',

            // Financials
            'ZQ' => '30-Day_Fed_Funds_Futures',
            'GE' => 'Eurodollar_Futures',

            // Grains
            'ZW' => 'Wheat_Futures',
            'ZC' => 'Corn_Futures',
            'ZS' => 'Soybeans_Futures',
            'ZM' => 'Soybean_Meal_Futures',
            'ZL' => 'Soybean_Oil_Futures',
            'ZO' => 'Oats_Futures',
            'ZR' => 'Rough_Rice_Futures',
            'KE' => 'Hard_Red_Wheat_Futures',
            'MW' => 'Spring_Wheat_Futures',
            'RS' => 'Canola_Futures',

            // Indices
            'ES' => 'E-Mini_S%26P_500_Futures',
            'NQ' => 'Mini_Nasdaq_100_Futures',
            'YM' => 'DJIA_mini-sized_Futures',

            // Meats
            'LE' => 'Live_Cattle_Futures',
            'GF' => 'Feeder_Cattle_Futures',
            'HE' => 'Lean_Hogs_Futures',
            'DL' => 'Class_III_Milk_Futures',

            // Metals
            'GC' => 'Gold_Futures',
            'SI' => 'Silver_Futures',
            'HG' => 'High_Grade_Copper_Futures',
            'PL' => 'Platinum_Futures',
            'PA' => 'Palladium_Futures',

            // Softs
            'CT' => 'Cotton_2_Futures',
            'OJ' => 'Orange_Juice_Futures',
            'KC' => 'Coffee_Futures',
            'SB' => 'Sugar_11_Futures',
            'CC' => 'Cocoa_Futures',
            'LS' => 'Lumber_Futures',
        ];

        foreach ($symbols as $symbol => $symbolName) {
            $query = $this->connection->createQueryBuilder();

            $query->insert('symbol');
            $query->values([
                'symbol' => ':symbol',
                'name'   => ':symbol_name',
            ]);

            $query->setParameters([
                ':symbol'      => $symbol,
                ':symbol_name' => $symbolName,
            ]);

            $query->execute();
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $connection = $this->connection;
        $connection->beginTransaction();

        try {
            $connection->query('DELETE FROM symbol');
            $connection->commit();
        } catch (\Exception $e) {
            $connection->rollback();
        }
    }
}
