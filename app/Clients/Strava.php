<?php

namespace App\Clients;

use App\Models\StravaInfo;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Strava
{
    private StravaInfo|null $stravaInfo;
    private string $baseUrl;
    
    public function __construct()
    {
        $this->stravaInfo = auth()->user()->stravaInfo;
        $this->baseUrl = 'https://www.strava.com/api/v3';
    }
    
    public function getActivities(?int $after = null, ?int $before = null): Response
    {
        $params = [];
        
        if ($after !== null) {
            $params['after'] = $after;
        }
        if ($before !== null) {
            $params['before'] = $before;
        }
        
        return $this->makeStravaRequest('GET', 'athlete/activities', $params);
    }
    
    public function getActivity(int $id): Response
    {
        return $this->makeStravaRequest('GET', "activities/{$id}");
    }
    
    
     /**
     * @throws ConnectionException
     */
    private function request(string $method, string $endpoint, array $params, string $accessToken): Response
    {
        $url = "{$this->baseUrl}/{$endpoint}";
        
        return match ($method) {
            'GET' => Http::withToken($accessToken)->get($url, $params),
            'POST' => Http::withToken($accessToken)->post($url, $params),
            default => throw new Exception("Unsupported HTTP method: {$method}"),
        };
    }
    
    /**
     * @throws Exception
     */
    private function makeStravaRequest(string $method, string $endpoint, array $params = []): Response
    {
        $response = $this->request($method, $endpoint, $params, $this->stravaInfo->access_token);
        
        if ($response->status() === 401) {
            $this->refreshAccessToken();
            $response = $this->request($method, $endpoint, $params, $this->stravaInfo->access_token);
        }
        
        return $response;
    }
    
    /**
     * @throws Exception
     */
    private function refreshAccessToken(): void
    {
        $response = Http::post('https://www.strava.com/oauth/token', [
            'client_id' => config('app.strava_client_id'),
            'client_secret' => config('app.strava_client_secret'),
            'grant_type' => 'refresh_token',
            'refresh_token' => $this->stravaInfo->refresh_token,
        ]);
        
        if ($response->successful()) {
            $data = $response->json();
            
            $this->stravaInfo->update([
                'access_token' => $data['access_token'],
                'refresh_token' => $data['refresh_token'],
            ]);
        } else {
            Log::error('Failed to refresh Strava access token: ' . $response->body());
            throw new Exception('Failed to refresh Strava access token.');
        }
    }
    
    /**
     * @throws ConnectionException
     */
    public function oAuth(string $userCode): StravaInfo
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'charset' => 'utf-8'
        ])->post('https://www.strava.com/oauth/token', [
            'client_id' => config('app.strava_client_id'),
            'client_secret' => config('app.strava_client_secret'),
            'code' => $userCode,
            'grant_type' => 'authorization_code',
        ])->collect();
        
        return StravaInfo::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'access_token' => $response->get('access_token'),
                'refresh_token' => $response->get('refresh_token'),
            ]
        );
    }
}
