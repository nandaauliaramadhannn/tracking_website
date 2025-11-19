<?php

namespace App\Events;

use App\Models\VisitorLog;
use App\Models\Website;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VisitorTracked implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $visitorLog;
    public $website;
    public $stats;

    /**
     * Create a new event instance.
     */
    public function __construct(VisitorLog $visitorLog, Website $website, array $stats)
    {
        $this->visitorLog = $visitorLog;
        $this->website = $website;
        $this->stats = $stats;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('admin.dashboard'),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'visitor.tracked';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'visitor_log' => [
                'id' => $this->visitorLog->id,
                'website_id' => $this->visitorLog->website_id,
                'ip_address' => $this->visitorLog->ip_address,
                'visited_at' => $this->visitorLog->visited_at,
                'website' => [
                    'id' => $this->website->id,
                    'name' => $this->website->name,
                    'url' => $this->website->url,
                ],
            ],
            'stats' => $this->stats,
        ];
    }
}
