<?php

namespace App\Http\Controllers;

use App\Services\DashboardMetricsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DashboardController extends Controller
{
    public function __construct(private readonly DashboardMetricsService $service)
    {
    }

    public function summary(): JsonResponse
    {
        return response()->json(
            $this->service->summary(auth()->user()->business_id)
        );
    }

    public function export(string $format): Response|JsonResponse
    {
        $metrics = $this->service->summary(auth()->user()->business_id);

        if ($format === 'json') {
            return response()->json($metrics);
        }

        if ($format === 'csv') {
            $rows = [
                ['metric', 'value'],
                ['total_revenue_tzs', $metrics['total_revenue_tzs']],
                ['monthly_revenue_tzs', $metrics['monthly_revenue_tzs']],
                ['active_customers', $metrics['active_customers']],
                ['bookings_count', $metrics['bookings_count']],
            ];

            $content = collect($rows)->map(fn ($row) => implode(',', $row))->implode("\n");

            return response($content, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="dashboard-report.csv"',
            ]);
        }

        return response()->json(['message' => 'Invalid format. Use csv or json.'], 422);
    }
}
