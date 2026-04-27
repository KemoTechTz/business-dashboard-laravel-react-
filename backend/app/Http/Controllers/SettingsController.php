<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function businessProfile(): JsonResponse
    {
        return response()->json(auth()->user()->business);
    }

    public function updateBusinessProfile(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:160'],
            'location' => ['required', 'string', 'max:180'],
            'logo_url' => ['nullable', 'url'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:190'],
            'timezone' => ['required', 'string', 'max:80'],
        ]);

        $business = Business::findOrFail(auth()->user()->business_id);
        $business->update($data);

        return response()->json($business);
    }

    public function users(): JsonResponse
    {
        return response()->json(
            User::where('business_id', auth()->user()->business_id)
                ->select('id', 'name', 'email', 'role', 'created_at')
                ->get()
        );
    }

    public function updateUserRole(Request $request, User $user): JsonResponse
    {
        abort_unless($user->business_id === auth()->user()->business_id, 403);

        $data = $request->validate([
            'role' => ['required', 'in:admin,manager,staff'],
        ]);

        $user->update($data);

        return response()->json($user->only(['id', 'name', 'email', 'role']));
    }
}
