<?php

namespace App\Http\Controllers;

use App\Services\SAWService;
use Illuminate\Http\Request;

class SAWController extends Controller
{
    protected $sawService;

    public function __construct(SAWService $sawService)
    {
        $this->sawService = $sawService;
    }

    public function calculate(Request $request)
    {
        $result = $this->sawService->calculateRanking();

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
