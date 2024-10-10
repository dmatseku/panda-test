<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:review-prices')->everyMinute()->withoutOverlapping(10);
