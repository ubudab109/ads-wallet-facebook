<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationMessages
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId, $title, $messages;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($userId, $title, $messages)
    {
        $this->userId = $userId;
        $this->title = $title;
        $this->messages = $messages;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // return new PrivateChannel('channel-name');
        return ['notification-messages'];
    }
}
