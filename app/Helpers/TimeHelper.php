<?php

namespace App\Helpers;

class TimeHelper
{
    public static function sumIntervals(array $intervals): string
    {
        $totalHours = 0;
        $totalMinutes = 0;

        foreach ($intervals as $interval) {
           
            if (preg_match('/(\d+)\s*h\s*(\d+)\s*m/', $interval, $matches)) {
                $hours = (int) $matches[1];
                $minutes = (int) $matches[2];

                // Add to the total hours and minutes
                $totalHours += $hours;
                $totalMinutes += $minutes;
            }
        }

        // Normalize total minutes to hours and minutes
        $totalHours += floor($totalMinutes / 60);
        $totalMinutes = $totalMinutes % 60;

        // Return the result in "X h Y m" format
        return "{$totalHours} h {$totalMinutes} m";
    }




}
