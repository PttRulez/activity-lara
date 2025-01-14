<?php

namespace App\Enums;

enum Source: string
{
    case STRAVA = 'strava';
    case GARMIN = 'garmin';
}