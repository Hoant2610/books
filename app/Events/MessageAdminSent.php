<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class MessageAdminSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $userId;
    public function __construct($message,$userId)
    {
        $this->message = $message;
        $this->userId = $userId;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('customer.'. $this->userId);
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message,
            'userId' => $this->userId,
        ];
    }
    public function broadcastAs()
    {
        return 'send-to-customer';
    }
}
