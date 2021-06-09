<?php

namespace App\Libraries;

use DateTime;

class AgeLibraries
{
    public function getAge($age)
    {
        $now = new DateTime();
        $age = new DateTime($age);

        $interval = $now->diff($age);
        $years = $interval->y;
        // $month = $interval->m;
        // $day = $interval->d;

        return $years;
    }
}
