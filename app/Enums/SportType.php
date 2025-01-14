<?php

namespace App\Enums;

enum SportType: string
{
    case OTHER = 'other';
    case RIDE = 'ride';
    case ROLLER_SKI = 'roller_ski';
    case RUN = 'run';
    case STRENGTH = 'strength';
    case XC_SKI = 'xc_ski';
}