<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\Meal;
use App\Models\Steps;
use App\Models\Weight;
use Carbon\Carbon;

class Diary
{
    public function getDiaries(Carbon $after, Carbon $before): array
    {
        $bmr = auth()->user()->bmr;
        $caloriesPer100Steps = auth()->user()->calories_per_100_steps;
        
        $days = [];
        $curDate = $after->copy();
        while (!$curDate->isAfter($before)) {
            $days[$curDate->toDateString()] = [
                'date' => $curDate->format('d.m'),
                'activities' => [],
                'weight' => null,
                'steps' => null,
                'meals' => [],
            ];
            $curDate->addDay();
        };
        
        auth()->user()->activities()->whereBetween('date', [$after, $before])->get()
            ->each(function (Activity $activity) use (&$days) {
                $days[$activity->date]['activities'][] = $activity;
            });
        auth()->user()->meals()->whereBetween('date', [$after, $before])->get()
            ->each(function (Meal $meal) use (&$days) {
                $days[$meal->date]['meals'][] = $meal;
            });
        auth()->user()->weights()->whereBetween('date', [$after, $before])->get()
            ->each(function (Weight $weight) use (&$days) {
                $days[$weight->date]['weight'] = $weight->weight;
            });
        auth()->user()->steps()->whereBetween('date', [$after, $before])->get()
            ->each(function (Steps $steps) use (&$days) {
                $days[$steps->date]['steps'] = $steps->steps;
            });
        
        // calculating metrics of each day
        foreach ($days as &$day) {
            $day['caloriesBurnedInActivities'] = 0;
            $day['caloriesBurnedBySteps'] = (int) ($day['steps'] / 100 * $caloriesPer100Steps);
            $day['caloriesConsumed'] = 0;
            
            foreach ($day['activities'] as $activity) {
                $day['caloriesBurnedInActivities'] +=  isset($activity->calories) ? $activity->calories : 0;
            }
            
            foreach ($day['meals'] as $meal) {
                $day['caloriesConsumed'] +=  isset($meal->calories) ? $meal->calories : 0;
            }
            
            $day['caloriesBalance'] = $day['caloriesConsumed']
                - $bmr
                - $day['caloriesBurnedInActivities']
                - $day['caloriesBurnedBySteps'];
        }
        
        // adding days to weeks and setting week's weight on the fly
        $days = array_values($days);
        $weeks = [];
        for ($i = 0; $i < count($days) / 7; $i++) {
            $weeks[$i]['weight'] = null;
            
            for ($j = $i * 7; $j <= $i * 7 + 6; $j++) {
                $d = $days[$j];
                $weeks[$i]['days'][] = $d;
                if (isset($d['weight'])) {
                    $weeks[$i]['weight'] = $d['weight'];
                }
            }
        }
        
        return array_reverse($weeks);
    }
}