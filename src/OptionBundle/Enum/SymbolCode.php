<?php
/**
 * Author: Vehsamrak
 * Date Created: 06.02.16 18:42
 */

namespace OptionBundle\Enum;
use MyCLabs\Enum\Enum;

/**
 * List of symbol codes
 */
class SymbolCode extends Enum
{
    // Energies
    const CRUDE_OIL_WTI = 'CL';
    const ULSD_NY_HARBOR = 'HO';
    const GASOLINE_RBOB = 'RB';
    const NATURAL_GAS = 'NG';
    const CRUDE_OIL_BRENT = 'QA';
    const ETHANOL = 'ZK';

    // Financials
    const FED_FUNDS_30_DAY = 'ZQ';
    const EURODOLLAR = 'GE';

    // Grains
    const WHEAT = 'ZW';
    const CORN = 'ZC';
    const SOYBEANS = 'ZS';
    const SOYBEAN_MEAL = 'ZM';
    const SOYBEAN_OIL = 'ZL';
    const OATS = 'ZO';
    const ROUGH_RICE = 'ZR';
    const HARD_RED_WHEAT = 'KE';
    const SPRING_WHEAT = 'MW';
    const CANOLA = 'RS';

    // Indices
    const E_MINI_SNP_500 = 'ES';
    const MINI_NASDAQ_100 = 'NQ';
    const DJIA_MINI = 'YM';

    // Meats
    const LIVE_CATTLE = 'LE';
    const FEEDER_CATTLE = 'GF';
    const LEAN_HOGS = 'HE';
    const CLASS_III_MILK = 'DL';

    // Metals
    const GOLD = 'GC';
    const SILVER = 'SI';
    const HIGH_GRADE_COPPER = 'HG';
    const PLATINUM = 'PL';
    const PALLADIUM = 'PA';

    // Softs
    const COTTON = 'CT';
    const ORANGE_JUICE = 'OJ';
    const COFFEE = 'KC';
    const SUGAR = 'SB';
    const COCOA = 'CC';
    const LUMBER = 'LS';
}
