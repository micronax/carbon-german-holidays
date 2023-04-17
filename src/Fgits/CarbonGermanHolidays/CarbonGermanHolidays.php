<?php
/**
 * GermanyHolidays GermanHolidays.php.
 *
 * @author    Fabian Golle <fabian@golle-it.de>
 * @copyright Fabian Golle <fabian@golle-it.de>
 */

namespace Fgits\CarbonGermanHolidays;

use Carbon\Carbon;

class CarbonGermanHolidays extends Carbon
{
    const BADEN_WUERTTEMBERG = 'baden-wuerttemberg';
    const BAYERN = 'bayern';
    const BERLIN = 'berlin';
    const BRANDENBURG = 'brandenburg';
    const BREMEN = 'bremen';
    const HAMBURG = 'hamburg';
    const HESSEN = 'hessen';
    const MECKLENBURG_VORPOMMERN = 'mecklenburg-vorpommern';
    const NIEDERSACHSEN = 'niedersachsen';
    const NORDRHEIN_WESTFALEN = 'nordrhein-westfalen';
    const RHEINLAND_PFALZ = 'rheinland-pfalz';
    const SAARLAND = 'saarland';
    const SACHSEN = 'sachsen';
    const SACHSEN_ANHALT = 'sachsen-anhalt';
    const SCHLESWIG_HOLSTEIN = 'schleswig-holstein';
    const THUERINGEN = 'thueringen';

    const CHRISTMAS_DAYS = 'christmas-days';
    const SPECIAL_DAYS_1 = 'special-days-1';
    const SPECIAL_DAYS_2 = 'special-days-2';
    const SPECIAL_DAYS_3 = 'special-days-3';
    const SPECIAL_DAYS_4 = 'special-days-4';

    const ALL_STATES
        = [
            self::BADEN_WUERTTEMBERG,
            self::BAYERN,
            self::BERLIN,
            self::BRANDENBURG,
            self::BREMEN,
            self::HAMBURG,
            self::HESSEN,
            self::MECKLENBURG_VORPOMMERN,
            self::NIEDERSACHSEN,
            self::NORDRHEIN_WESTFALEN,
            self::RHEINLAND_PFALZ,
            self::SAARLAND,
            self::SACHSEN,
            self::SACHSEN_ANHALT,
            self::SCHLESWIG_HOLSTEIN,
            self::THUERINGEN,
        ];

    const ALL_STATES_ALL_DAYS
        = [
            self::BADEN_WUERTTEMBERG,
            self::BAYERN,
            self::BERLIN,
            self::BRANDENBURG,
            self::BREMEN,
            self::HAMBURG,
            self::HESSEN,
            self::MECKLENBURG_VORPOMMERN,
            self::NIEDERSACHSEN,
            self::NORDRHEIN_WESTFALEN,
            self::RHEINLAND_PFALZ,
            self::SAARLAND,
            self::SACHSEN,
            self::SACHSEN_ANHALT,
            self::SCHLESWIG_HOLSTEIN,
            self::THUERINGEN,
            self::CHRISTMAS_DAYS,
            self::SPECIAL_DAYS_1,
            self::SPECIAL_DAYS_2,
            self::SPECIAL_DAYS_3,
            self::SPECIAL_DAYS_4,
        ];

    /**
     * Returns boolean if the current Carbon instance is a German holiday
     *
     * @param array $states
     *
     * @return bool
     */
    public function isGermanHoliday($states = self::ALL_STATES)
    {
        $holidays = self::getHolidays($this->year, $states);

        return in_array($this->startOfDay(), $holidays, false);
    }

    /**
     * Returns an array with the names of the German holidays for current Carbon instance
     *
     * @param array $states
     *
     * @return array
     */
    public function getGermanHolidaysForDay($states = self::ALL_STATES)
    {
        $holidays = self::getHolidays($this->year, $states);

        return array_keys($holidays, $this->startOfDay());
    }


    /**
     * Get easter sunday Carbon instance for given year
     *
     * @param $year
     *
     * @return CarbonGermanHolidays
     */
    public static function getEasterSunday($year)
    {
        $easter = self::createFromDate($year, 03, 21)->startOfDay();

        return $easter->addDays(easter_days($year));
    }

    /**
     * Returns an array with all German holidays name => \DateTime
     *
     * @param       $year
     * @param array $states
     *
     * @return array
     */
    public static function getHolidays($year, $states = self::ALL_STATES)
    {
        $holidays     = [];
        $easterSunday = self::getEasterSunday($year)->getTimeStamp();

        if ( ! is_array($states)) {
            $states = [$states];
        }

        $penanceDay = strtotime("last Wednesday", mktime(0, 0, 0, 11, 23, $year));


        // For all states
        $holidays['Neujahr']                   = mktime(0, 0, 0, 1, 1, $year);
        $holidays['Tag der Arbeit']            = mktime(0, 0, 0, 5, 1, $year);
        $holidays['Karfreitag']                = strtotime('-2 days', $easterSunday);
        $holidays['Ostermontag']               = strtotime('+1 day', $easterSunday);
        $holidays['Christi Himmelfahrt']       = strtotime('+39 days', $easterSunday);
        $holidays['Pfingstmontag']             = strtotime('+50 days', $easterSunday);
        $holidays['Tag der Deutschen Einheit'] = mktime(0, 0, 0, 10, 3, $year);
        $holidays['1. Weihnachtstag']          = mktime(0, 0, 0, 12, 25, $year);
        $holidays['2. Weihnachtstag']          = mktime(0, 0, 0, 12, 26, $year);

        if (in_array(self::BERLIN, $states)) {
            $holidays['Internationaler Frauentag'] = mktime(0, 0, 0, 3, 8, $year);
        }

        if (in_array(self::BRANDENBURG, $states)) {
            $holidays['Ostersonntag']   = $easterSunday;
            $holidays['Pfingstsonntag'] = strtotime('+49 days', $easterSunday);
        }

        if (array_intersect([self::BADEN_WUERTTEMBERG, self::BAYERN, self::SACHSEN_ANHALT], $states)) {
            $holidays['Heilige Drei Könige'] = mktime(0, 0, 0, 1, 6, $year);
        }

        if (in_array(self::SACHSEN, $states)) {
            $holidays['Buß- und Bettag'] = $penanceDay;
        }

        if (array_intersect([self::BADEN_WUERTTEMBERG, self::BAYERN, self::HESSEN, self::NORDRHEIN_WESTFALEN, self::RHEINLAND_PFALZ, self::SAARLAND], $states)) {
            $holidays['Fronleichnam'] = strtotime('+60 days', $easterSunday);
        }

        if (array_intersect([self::BAYERN, self::SAARLAND], $states)) {
            $holidays['Mariä Himmelfahrt'] = mktime(0, 0, 0, 8, 15, $year);
        }

        if (array_intersect([self::BRANDENBURG, self::MECKLENBURG_VORPOMMERN, self::SACHSEN, self::SACHSEN_ANHALT, self::THUERINGEN, self::NIEDERSACHSEN, self::HAMBURG, self::SCHLESWIG_HOLSTEIN, self::BREMEN], $states)) {
            $holidays['Reformationstag'] = mktime(0, 0, 0, 10, 31, $year);
        }

        if (array_intersect([self::BADEN_WUERTTEMBERG, self::BAYERN, self::NORDRHEIN_WESTFALEN, self::RHEINLAND_PFALZ, self::SAARLAND], $states)) {
            $holidays['Allerheiligen'] = mktime(0, 0, 0, 11, 1, $year);
        }

        if (in_array(self::CHRISTMAS_DAYS, $states)) {
            $holidays['1. Advent']   = strtotime('+11 days', $penanceDay);
            $holidays['2. Advent']   = strtotime('+18 days', $penanceDay);
            $holidays['3. Advent']   = strtotime('+25 days', $penanceDay);
            $holidays['4. Advent']   = strtotime('+32 days', $penanceDay);
            $holidays['Nikolaus']    = mktime(0, 0, 0, 12, 6, $year);
            $holidays['Heiligabend'] = mktime(0, 0, 0, 12, 24, $year);
            $holidays['Silvester']   = mktime(0, 0, 0, 12, 31, $year);
        }

        if (in_array(self::SPECIAL_DAYS_1, $states)) {
            $holidays['Halloween']    = mktime(0, 0, 0, 10, 31, $year);
            $holidays['Valentinstag'] = mktime(0, 0, 0, 2, 14, $year);
        }

        if (in_array(self::SPECIAL_DAYS_2, $states)) {
            $holidays['Weiberfastnacht'] = strtotime('-52 days', $easterSunday);
            $holidays['Rosenmontag']     = strtotime('-48 days', $easterSunday);
            $holidays['Fastnacht']       = strtotime('-47 days', $easterSunday);
            $holidays['Aschermittwoch']  = strtotime('-46 days', $easterSunday);
            $holidays['Palmsonntag']     = strtotime('-7 days', $easterSunday);
            $holidays['Gründonnerstag']  = strtotime('-3 days', $easterSunday);
        }

        if (in_array(self::SPECIAL_DAYS_3, $states)) {
            $holidays['Martinstag']                = mktime(0, 0, 0, 11, 11, $year);
            $holidays['Internationaler Kindertag'] = mktime(0, 0, 0, 6, 1, $year);
            $holidays['Weltkindertag']             = mktime(0, 0, 0, 9, 20, $year);
            $holidays['Weißer Sonntag']            = strtotime('+7 days', $easterSunday);
            $holidays['Internationaler Frauentag'] = mktime(0, 0, 0, 3, 8, $year);
            //$holidays['Walpurgisnacht']            = mktime(0, 0, 0, 4, 30, $year); // WTF
            $holidays['Karsamstag']     = strtotime('-1 day', $easterSunday);
            $holidays['Allerseelen']    = mktime(0, 0, 0, 11, 2, $year);
            $holidays['Erntedankfest']  = mktime(0, 0, 0, 10, 7 - ($year + 5 + $year / 4) % 7, $year);
            $holidays['Volkstrauertag'] = strtotime('-3 days', $penanceDay);
            $holidays['Totensonntag']   = strtotime('+4 days', $penanceDay);
        }

        if (in_array(self::SPECIAL_DAYS_4, $states)) {
            $holidays['Sommerzeit (+1h)'] = mktime(0, 0, 0, 3, 31 - ($year + 4 + $year / 4) % 7, $year);
            $holidays['Winterzeit (-1h)'] = mktime(0, 0, 0, 10, 31 - ($year + 1 + $year / 4) % 7, $year);
        }

        return array_map(static fn($u) => (new \DateTime())->setTimestamp($u), $holidays);
    }
}
