<?php

namespace App\Providers;

use App\Events\BookingCreated;
use App\Jobs\SendBookingNotificationJob;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Event::listen(BookingCreated::class, function (BookingCreated $event): void {
            SendBookingNotificationJob::dispatch($event->booking->id);
        });
    }
}
