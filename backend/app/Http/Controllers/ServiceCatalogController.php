<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Models\ServiceCatalog;
use Illuminate\Http\JsonResponse;

class ServiceCatalogController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(ServiceCatalog::where('business_id', auth()->user()->business_id)->paginate(15));
    }

    public function store(ServiceRequest $request): JsonResponse
    {
        $service = ServiceCatalog::create($request->validated() + ['business_id' => auth()->user()->business_id]);
        return response()->json($service, 201);
    }

    public function show(ServiceCatalog $service): JsonResponse
    {
        abort_unless($service->business_id === auth()->user()->business_id, 403);
        return response()->json($service);
    }

    public function update(ServiceRequest $request, ServiceCatalog $service): JsonResponse
    {
        abort_unless($service->business_id === auth()->user()->business_id, 403);
        $service->update($request->validated());
        return response()->json($service);
    }

    public function destroy(ServiceCatalog $service): JsonResponse
    {
        abort_unless($service->business_id === auth()->user()->business_id, 403);
        $service->delete();
        return response()->json(status: 204);
    }
}
