<?php

namespace App\Services;

use App\Enums\Source;
use App\Enums\SportType;
use App\Models\Activity;
use App\Models\StravaInfo;
use App\Clients\Strava as StravaClient;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;

class Strava
{
    public function __construct(private StravaClient $client)
    {
    }
    
    public function getStravaOauthLink(): string
    {
        $clientId = config('app.strava_client_id');
        $redirectUri = route('strava-callback'); // Ensure you have this route set
        $scope = ['read', 'activity:read']; // Scopes you need
        
        // Build the query parameters dynamically
        $params = [
            'scope' => implode(',', $scope),  // Convert the scope array to a comma-separated string
            'client_id' => $clientId,
            'response_type' => 'code',
            'redirect_uri' => $redirectUri,
            'approval_prompt' => 'force',
        ];
        
        // Build the full URL with query parameters
        $url = "https://www.strava.com/oauth/authorize?" . http_build_query($params);
        
        return $url;
    }
    
    public function updateActivityWithCalories(int $sourceId): void
    {
        $activity = Activity::where(['source_id' => $sourceId])->first();
        
        if (!$activity) {
            return;
        }
        
        try {
            $res = $this->client->getActivity($activity->source_id);
            $calories = $res['calories'] ?: 0;
            $activeCalories = round($calories * 0.89);
            $activity->update(['calories' => $activeCalories]);
        } catch (\Exception $e) {
            Log::error('Failed to fetch' . $activity->source_id . 'activity from Strava: ' . $e->getMessage());
        }
    }
    
    public function syncStrava(): void
    {
        set_time_limit(0);
        $after = 0;
        $isPolling = true;
        $latestUnix = Auth::user()->activities()->max('start_time_unix');
        
        if ($latestUnix > 0) {
            $after = $latestUnix;
        }
        
        while ($isPolling) {
            try {
                $res = retry(3, function () use ($after) {
                    return $this->client->getActivities($after);
                }, 100);
                
                $activities = $res->collect()->map(function ($row) {
                    return $this->convertToActivity($row);
                });
                
                if ($activities->isEmpty()) {
                    $isPolling = false;
                    break;
                }
                
                $activities->each(function (Activity $activity) {
                    $activity->save();
                });
                
                $after = $activities->max('start_time_unix');
            } catch (\Exception $e) {
                Log::error('Failed to fetch activities from Strava: ' . $e->getMessage());
            }
        }
    }
    
    /**
     *                INTERNAL PRIVATE METHODS
     */
    private function calculatePace(int $movingTime, int $distance): array
    {
        if ($distance <= 0) {
            return ['pace' => 0, 'pace_string' => ''];
        }
        $km = $distance / 1000;
        $secondsPerKm = $movingTime / $km;
        $minutes = round($secondsPerKm / 60);
        $seconds = str_pad($secondsPerKm % 60, 2, '0', STR_PAD_LEFT);
        $paceString = "{$minutes}:{$seconds}";
        
        return [
            'pace' => $secondsPerKm,
            'pace_string' => $paceString,
        ];
    }
    
    private function sportType(string $stravaApiType): SportType
    {
        return match ($stravaApiType) {
            'Run', 'TrailRun' => SportType::RUN,
            'Ride', 'GravelRide', 'MountainBikeRide' => SportType::RIDE,
            'NordicSki' => SportType::XC_SKI,
            'RollerSki' => SportType::ROLLER_SKI,
            default => SportType::OTHER,
        };
    }
    
    private function convertToActivity(mixed $row): Activity
    {
        $paceData = $this->calculatePace($row['moving_time'], $row['distance']);
        
        $a = new Activity([
            'calories' => 0,
            'distance' => round($row['distance']),
            'description' => '',
            'date' => Carbon::parse($row['start_date_local']),
            'elevate' => round($row['total_elevation_gain']),
            'heart_rate' => 0,
            'name' => $row['name'],
            'pace' => $paceData['pace'],
            'pace_string' => $paceData['pace_string'],
            'source' => Source::STRAVA->value,
            'source_id' => $row['id'],
            'sport_type' => $this->sportType($row['type']),
            'start_time_unix' => Carbon::parse($row['start_date'])->getTimestamp(),
            'total_time' => $row['elapsed_time'],
            'user_id' => Auth::id(),
            'hui' => 22
        ]);
        
        if ($row['has_heartrate']) {
            $a->heart_rate = round($row['average_heartrate']);
        }
        
        return $a;
    }
}