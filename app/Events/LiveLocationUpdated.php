<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\LiveLocation;


class LiveLocationUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $location;

    public function __construct(LiveLocation $location)
    {
        $this->location = [
            'user_id'   => $location->user_id,
            'ibc_id'   => $location->user->areas->pluck('id')->implode(', '),
            'latitude'  => $location->latitude,
            'longitude' => $location->longitude,
            'updated_at'=> $location->last_seen_at,
            'agent' => [
                'username' => $location->user->name,
                'code'     => $location->user->code ?? null,
                'ibc'      => $location->user->areas->pluck('name')->implode(', '),
            ]
        ];
    }

    // Broadcast via public channel
    public function broadcastOn()
    {
        return new Channel('live-locations');
    }

    public function broadcastAs()
    {
        return 'location.updated';
    }
}
