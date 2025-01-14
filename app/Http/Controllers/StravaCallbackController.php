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
    
        $strava->oAuth($userCode);
        
        return redirect()->route('home');
    }
}
