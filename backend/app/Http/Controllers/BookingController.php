<?php

namespace App\Http\Controllers;

use App\Events\BookingCreated;
use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use Illuminate\Http\JsonResponse;

class BookingController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Booking::where('business_id', auth()->user()->business_id)
                ->with(['customer:id,name', 'service:id,name', 'staff:id,name'])
                ->latest('scheduled_for')
                ->paginate(15)
        );
    }

    public function store(BookingRequest $request): JsonResponse
    {
        $booking = Booking::create($request->validated() + ['business_id' => auth()->user()->business_id]);
        event(new BookingCreated($booking));

        return response()->json($booking->load(['customer', 'service', 'staff']), 201);
    }

    public function show(Booking $booking): JsonResponse
    {
        abort_unless($booking->business_id === auth()->user()->business_id, 403);
        return response()->json($booking->load(['customer', 'service', 'staff']));
    }

    public function update(BookingRequest $request, Booking $booking): JsonResponse
    {
        abort_unless($booking->business_id === auth()->user()->business_id, 403);
        $booking->update($request->validated());

        return response()->json($booking->load(['customer', 'service', 'staff']));
    }

    public function destroy(Booking $booking): JsonResponse
    {
        abort_unless($booking->business_id === auth()->user()->business_id, 403);
        $booking->delete();

        return response()->json(status: 204);
    }
}
