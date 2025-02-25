<?php

namespace App\Http\Controllers;

use App\Services\WPService;
use Illuminate\Http\Request;

class WPController extends Controller
{
    protected $wpService;

    public function __construct(WPService $wpService)
    {
        $this->wpService = $wpService;
    }

    public function calculate(Request $request)
    {
        $result = $this->wpService->calculateRanking();

        if (!$result['success']) {
            if ($request->wantsJson()) {
                return response()->json($result, 500);
            }
            return redirect()->back()
                ->with('error', $result['message'])
                ->with('refresh', true);
        }

        if ($request->wantsJson()) {
            return response()->json($result);
        }

        return response()->json([
            'success' => true,
            'refresh' => true,
            'data' => $result['data'],
        ]);
    }
}