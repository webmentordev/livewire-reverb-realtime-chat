<?php

namespace App\Events;

use App\Models\Message;
use App\Models\Room;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public function __construct(public Room $room, public Message $message)
    {
        //
    }

    public function broadcastWith(): array
    {
        return [
            'message' => [
                'id' => $this->message->id
            ]
        ];
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.room.' . $this->room->id),
        ];
    }
}