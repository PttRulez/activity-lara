<?php

namespace App\Http\Controllers;

use App\Services\Strava;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StravaCallbackController extends Controller
{
    public function __invoke(Request $request, Strava $strava)
    {
        $userCode = $request->query('code');
    
        $success = $strava->oAuth($userCode);
        
        if (!$success) {
            session()->flash('toast', 'Failed to authorize with Strava');
            return redirect()->route('activities');
        }
        
        auth()->user()->load('stravaInfo');
        
        return redirect()->route('activities');
    }
}
