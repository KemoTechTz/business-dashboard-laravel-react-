<?php

namespace App\Http\Controllers;

use App\Models\NotificationItem;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            NotificationItem::where('business_id', auth()->user()->business_id)
                ->where('user_id', auth()->id())
                ->latest()
                ->limit(30)
                ->get()
        );
    }

    public function markRead(NotificationItem $notification): JsonResponse
    {
        abort_unless(
            $notification->business_id === auth()->user()->business_id && $notification->user_id === auth()->id(),
            403
        );

        $notification->update(['is_read' => true]);

        return response()->json($notification);
    }
}
