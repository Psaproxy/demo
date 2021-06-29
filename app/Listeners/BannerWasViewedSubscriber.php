<?php

namespace App\Listeners;

use App\Events\BannerWasViewed;
use Illuminate\Support\Facades\Log;

class BannerWasViewedSubscriber
{
    public function subscribe($events): void
    {
        $events->listen(BannerWasViewed::class, [BannerWasViewedSubscriber::class, 'handle']);
    }

    public function handle(BannerWasViewed $event): void
    {
        Log::Info('qwewqe');
    }
}
