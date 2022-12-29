<?php

namespace App\Inputs;

use DateTime;

class CountPeriodInput
{
    public int $period;
    public DateTime $startPeriod;
    public DateTime $endPeriod;
}
