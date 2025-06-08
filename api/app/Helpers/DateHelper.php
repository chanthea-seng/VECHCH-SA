<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    private static function toKhmerNumerals($number)
    {
        $khmerNumerals = [
            '0' => '០',
            '1' => '១',
            '2' => '២',
            '3' => '៣',
            '4' => '៤',
            '5' => '៥',
            '6' => '៦',
            '7' => '៧',
            '8' => '៨',
            '9' => '៩',
        ];
        return strtr((string) $number, $khmerNumerals);
    }

    public static function roundTimeToNearestInterval($time, $intervalMinutes = 15)
    {
        $carbonTime = Carbon::parse($time);
        $minutes = $carbonTime->minute;
        $roundedMinutes = round($minutes / $intervalMinutes) * $intervalMinutes;

        if ($roundedMinutes >= 60) {
            $carbonTime->addHour();
            $roundedMinutes -= 60;
        }
        $carbonTime->setMinutes($roundedMinutes)->setSeconds(0);
        return $carbonTime;
    }

    public static function formatTimeWithCustomPeriodsToKhmer($time)
    {
        $carbonTime = Carbon::parse($time);
        $hour = $carbonTime->hour;
        $minutes = $carbonTime->minute;

        $hoursKhmer = self::toKhmerNumerals($hour % 12 ?: 12);
        $minutesKhmer = self::toKhmerNumerals(sprintf('%02d', $minutes));
        $formattedTime = "$hoursKhmer:$minutesKhmer";

        if ($hour >= 0 && $hour < 6)
            $period = 'រំលងអធ្រាត្រ';
        elseif ($hour >= 6 && $hour < 12)
            $period = 'ព្រឹក';
        elseif ($hour >= 12 && $hour < 17)
            $period = 'រសៀល';
        elseif ($hour >= 17 && $hour < 20)
            $period = 'ល្ងាច';
        else
            $period = 'យប់';
        return "$formattedTime $period";
    }

    public static function translateRelativeTimeToKhmer($date)
    {
        $relativeTime = Carbon::parse($date)->diffForHumans(null, false, true);
        $translations = [
            's' => 'វិនាទី',
            'ago' => 'មុន',
            'minute' => 'នាទី',
            'm' => 'នាទី',
            'hour' => 'ម៉ោង',
            'h' => 'ម៉ោង',
            'day' => 'ថ្ងៃ',
            'd' => 'ថ្ងៃ',
            'week' => 'សប្ដាហ៍',
            'w' => 'សប្ដាហ៍',
            'month' => 'ខែ',
            'year' => 'ឆ្នាំ',
            'y' => 'ឆ្នាំ'
        ];

        foreach ($translations as $english => $khmer) {
            $relativeTime = str_replace($english, $khmer, $relativeTime);
        }

        $relativeTime = preg_replace_callback('/\d+/', function ($matches) {
            return self::toKhmerNumerals($matches[0]);
        }, $relativeTime);

        return $relativeTime;
    }

    public static function calculateAgeInKhmer($dob)
    {
        $birthDate = Carbon::parse($dob);
        $age = $birthDate->age;
        $ageKhmer = self::toKhmerNumerals($age);
        return "$ageKhmer ឆ្នាំ";
    }

    public static function translateDateToKhmer($date, $includeTime = false, $use24Hour = false)
    {
        $months = [
            'January' => 'មករា',
            'February' => 'កុម្ភៈ',
            'March' => 'មីនា',
            'April' => 'មេសា',
            'May' => 'ឧសភា',
            'June' => 'មិថុនា',
            'July' => 'កក្តដា',
            'August' => 'សីហា',
            'September' => 'កញ្ញា',
            'October' => 'តុលា',
            'November' => 'វិច្ឆិកា',
            'December' => 'ធ្នូ'
        ];

        $carbonDate = Carbon::parse($date);
        $day = self::toKhmerNumerals($carbonDate->format('d'));
        $month = $carbonDate->format('F');
        $year = self::toKhmerNumerals($carbonDate->format('Y'));
        $monthKhmer = $months[$month];
        $formattedDate = "$day $monthKhmer $year";

        if ($includeTime) {
            $hour = $carbonDate->hour;
            $minutes = $carbonDate->minute;
            $hoursKhmer = self::toKhmerNumerals($use24Hour ? $hour : ($hour % 12 ?: 12));
            $minutesKhmer = self::toKhmerNumerals(sprintf('%02d', $minutes));
            $formattedTime = "$hoursKhmer:$minutesKhmer";
            if (!$use24Hour) {
                $amPm = $carbonDate->format('A');
                $translations = ['AM' => 'ព្រឹក', 'PM' => 'ល្ងាច'];
                $formattedTime .= ' ' . $translations[$amPm];
            }
            $formattedDate .= ' ម៉ោង ' . $formattedTime;
        }

        return $formattedDate;
    }

    public static function translateDateWithDayToKhmer($date, $includeTime = false, $use24Hour = false)
    {
        $days = [
            'Monday' => 'ថ្ងៃច័ន្ទ',
            'Tuesday' => 'ថ្ងៃអង្គារ',
            'Wednesday' => 'ថ្ងៃពុធ',
            'Thursday' => 'ថ្ងៃព្រហស្បតិ៍',
            'Friday' => 'ថ្ងៃសុក្រ',
            'Saturday' => 'ថ្ងៃសៅរ៍',
            'Sunday' => 'ថ្ងៃអាទិត្យ',
        ];

        $carbonDate = Carbon::parse($date);
        $dayOfWeek = $carbonDate->format('l');
        $dayKhmer = $days[$dayOfWeek];
        $formattedDate = self::translateDateToKhmer($date, $includeTime, $use24Hour);
        return "$dayKhmer $formattedDate";
    }
}
