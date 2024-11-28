<?php

namespace Hypervix\ExeclDateConverter;

use DateTime;

/**
 * ExcelDateConverter Class
 *
 * A utility class for handling and converting Excel-style date values 
 * as well as standard date formats. This class supports various formats 
 * and provides functionality to convert, parse, and format dates.
 *
 * @package    Hypervix
 * @author     Jayanta Bhunia
 * @license    MIT License (https://opensource.org/licenses/MIT)
 * @link       https://hypervix.com/
 * @version    1.0.0
 * @since      2024
 */
class ExeclDateConverter
{
    /**
     * @var int|string $date Holds the parsed or converted date value
     */
    public static $date;

    /**
     * @var string|null $strToTime Holds the string representation of the date
     */
    public $strToTime;

    /**
     * Constructor
     *
     * Initializes the ExeclDateConverter instance with a given date string.
     *
     * @param string|null $strToTime String representation of the date (optional)
     */
    public function __construct($strToTime = '')
    {
        $this->strToTime = $strToTime;
    }

    /**
     * Convert Excel-style date or standard date format into a timestamp.
     *
     * @param mixed $date_value Date value (Excel-style serial or string)
     * @return ExeclDateConverter|null Returns an instance or null if invalid
     */
    public static function date($date_value = null): ?ExeclDateConverter
    {
        if (!$date_value) 
            return null;

        self::$date = $date_value;

        // Handle Excel date values
        if (is_numeric($date_value)) {
            /**
             * Number of days between the beginning of serial date-time (1900-Jan-0)
             * used by Excel and the beginning of UNIX Epoch time (1970-Jan-1).
             */
            $days_since_1900 = 25569;

            if ($date_value < 60) {
                --$days_since_1900;
            }

            /**
             * Values greater than 1 contain both a date and time while values lesser
             * than 1 contain only a fraction of a 24-hour day, and thus only time.
             */
            if ($date_value >= 1) {
                $utc_days = $date_value - $days_since_1900;
                $timestamp = round($utc_days * 86400);

                if (($timestamp <= PHP_INT_MAX) && ($timestamp >= -PHP_INT_MAX)) {
                    $timestamp = (int) $timestamp;
                }
            } else {
                $hours = round($date_value * 24);
                $mins = round($date_value * 1440) - round($hours * 60);
                $secs = round($date_value * 86400) - round($hours * 3600) - round($mins * 60);
                $timestamp = (int) gmmktime($hours, $mins, $secs);
            }

            self::$date = $timestamp;
            return new ExeclDateConverter($timestamp);
        }

        // Handle standard date formats
        $date_formats = self::possible_format();

        foreach ($date_formats as $format) {
            $date = DateTime::createFromFormat($format, trim($date_value));

            if ($date) {
                self::$date = $date->getTimestamp();
                return new ExeclDateConverter(self::$date);
            }
        }

        return null;
    }

    /**
     * Format the date into a specified string format.
     *
     * @param string|null $format The date format (e.g., 'Y-m-d', 'd/m/Y')
     * @return string|null Returns the formatted date string or null
     */
    public static function format($format = null): ?string
    {
        if (!self::$date) 
            return null;

        return $format ? date($format, self::$date) : self::$date;
    }

    /**
     * Provides an array of possible date formats supported by the class.
     *
     * @return array List of date formats
     */
    public static function possible_format($value='')
    {
        return [
            'd-m-Y',        // 31-12-2024
            'Y-m-d',        // 2024-12-31
            'Y/m/d',        // 2024/12/31
            'd/m/Y',        // 31/12/2024
            'Y/d/m',        // 2024/31/12
            'd.m.Y',        // 31.12.2024
            'm-d-Y',        // 12-31-2024
            'm/d/Y',        // 12/31/2024
            'd M Y',        // 31 Dec 2024
            'd F Y',        // 31 December 2024
            'M d, Y',       // Dec 31, 2024
            'F d, Y',       // December 31, 2024
            'd-M-Y',        // 31-Dec-2024
            'd-F-Y',        // 31-December-2024
            'Y-M-d',        // 2024-Dec-31
            'Y-F-d',        // 2024-December-31
            'D, d M Y',     // Sun, 31 Dec 2024
            'l, d F Y',     // Sunday, 31 December 2024
            'd F, Y',       // 31 December, 2024
            'd-M-y',        // 31-Dec-23
            'Y/m/d H:i:s',  // 2024/12/31 23:59:59 (with time)
            'd-m-Y H:i',    // 31-12-2024 23:59 (with time)
            'Y.m.d',        // 2024.12.31
            'm.d.Y',        // 12.31.2024
            'j/n/Y',        // 31/12/2024 (no leading zero in day/month)
            'n/j/Y',        // 12/31/2024 (no leading zero in day/month)
            'd M, Y H:i',   // 31 Dec, 2024 23:59 (with time)
            'd F, Y H:i:s', // 31 December, 2024 23:59:59 (with time)
        ];
    }
}
