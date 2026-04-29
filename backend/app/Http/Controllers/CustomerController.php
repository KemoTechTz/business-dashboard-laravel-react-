<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Customer::where('business_id', auth()->user()->business_id)->paginate(15));
    }

    public function store(CustomerRequest $request): JsonResponse
    {
        $customer = Customer::create($request->validated() + ['business_id' => auth()->user()->business_id]);
        return response()->json($customer, 201);
    }

    public function show(Customer $customer): JsonResponse
    {
        $this->authorizeTenant($customer->business_id);
        return response()->json($customer->load('bookings'));
    }

    public function update(CustomerRequest $request, Customer $customer): JsonResponse
    {
        $this->authorizeTenant($customer->business_id);
        $customer->update($request->validated());
        return response()->json($customer);
    }

    public function destroy(Customer $customer): JsonResponse
    {
        $this->authorizeTenant($customer->business_id);
        $customer->delete();
        return response()->json(status: 204);
    }

    private function authorizeTenant(int $businessId): void
    {
        abort_unless(auth()->user()->business_id === $businessId, 403);
    }
}
