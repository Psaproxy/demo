<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class NumberOfBannerViewsWasUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $numberOfViews;

    public function __construct(int $numberOfViews)
    {
        $this->numberOfViews = $numberOfViews;
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('banner.' . Auth::id());
    }
}
