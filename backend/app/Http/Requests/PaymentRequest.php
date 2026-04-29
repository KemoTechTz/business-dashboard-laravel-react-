<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $businessId = $this->user()->business_id;

        return [
            'booking_id' => [
                'required',
                Rule::exists('bookings', 'id')->where(fn ($query) => $query->where('business_id', $businessId)),
            ],
            'amount_tzs' => ['required', 'numeric', 'min:0'],
            'method' => ['required', 'in:cash,card,mpesa,airtel_money,bank_transfer'],
            'status' => ['required', 'in:paid,unpaid,failed'],
            'transaction_reference' => ['nullable', 'string', 'max:120'],
            'paid_at' => ['nullable', 'date'],
            'metadata' => ['array'],
        ];
    }
}
