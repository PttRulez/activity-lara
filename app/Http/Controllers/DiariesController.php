<?php

namespace App\Http\Controllers;

use App\Services\Diary;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DiariesController extends Controller
{
    public function __invoke(Diary $diaryService)
    {
        $now = Carbon::now();
        $before = $now->copy()->endOfWeek();
        $after = $now->copy()->subWeeks(3)->startOfWeek();
        $weeks = $diaryService->getDiaries($after, $before);
        return view('pages.diaries', [
            'weeks' => $weeks,
        ]);
    }
}
