<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Payment::where('business_id', auth()->user()->business_id)
                ->with('booking.customer:id,name')
                ->latest()
                ->paginate(15)
        );
    }

    public function store(PaymentRequest $request): JsonResponse
    {
        $payment = Payment::create($request->validated() + ['business_id' => auth()->user()->business_id]);
        return response()->json($payment->load('booking'), 201);
    }

    public function show(Payment $payment): JsonResponse
    {
        abort_unless($payment->business_id === auth()->user()->business_id, 403);
        return response()->json($payment->load('booking.customer'));
    }

    public function update(PaymentRequest $request, Payment $payment): JsonResponse
    {
        abort_unless($payment->business_id === auth()->user()->business_id, 403);
        $payment->update($request->validated());
        return response()->json($payment);
    }
}
