<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Payment;
use Illuminate\Support\Carbon;

class DashboardMetricsService
{
    public function summary(int $businessId): array
    {
        $startMonth = Carbon::now()->startOfMonth();
        $endMonth = Carbon::now()->endOfMonth();

        $totalRevenue = Payment::where('business_id', $businessId)
            ->where('status', 'paid')
            ->sum('amount_tzs');

        $monthlyRevenue = Payment::where('business_id', $businessId)
            ->where('status', 'paid')
            ->whereBetween('paid_at', [$startMonth, $endMonth])
            ->sum('amount_tzs');

        return [
            'total_revenue_tzs' => $totalRevenue,
            'monthly_revenue_tzs' => $monthlyRevenue,
            'active_customers' => Customer::where('business_id', $businessId)->count(),
            'bookings_count' => Booking::where('business_id', $businessId)->count(),
            'bookings_by_status' => Booking::where('business_id', $businessId)
                ->selectRaw('status, count(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status'),
            'daily_revenue' => Payment::where('business_id', $businessId)
                ->where('status', 'paid')
                ->whereDate('paid_at', '>=', Carbon::now()->subDays(14))
                ->selectRaw('DATE(paid_at) as day, SUM(amount_tzs) as total')
                ->groupBy('day')
                ->orderBy('day')
                ->get(),
            'recent_activity' => Booking::where('business_id', $businessId)
                ->with(['customer:id,name', 'service:id,name'])
                ->latest()
                ->limit(8)
                ->get(),
        ];
    }
}
