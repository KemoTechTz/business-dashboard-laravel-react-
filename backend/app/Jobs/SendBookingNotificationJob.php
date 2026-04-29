<?php

namespace App\Jobs;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendBookingNotificationJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public int $bookingId)
    {
    }

    public function handle(): void
    {
        $booking = Booking::find($this->bookingId);
        if (! $booking) {
            return;
        }

        User::where('business_id', $booking->business_id)
            ->each(function (User $user) use ($booking): void {
                $user->notifications()->create([
                    'business_id' => $booking->business_id,
                    'title' => 'New booking created',
                    'body' => "Booking #{$booking->id} was scheduled.",
                    'type' => 'booking_created',
                    'is_read' => false,
                ]);
            });
    }
}
