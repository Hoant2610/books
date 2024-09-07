<?php

namespace App\DTOs\admin;

use Carbon\Carbon;
use Illuminate\Support\Str;
class UserChatDTO implements \JsonSerializable
{
    private  $name;
    private  $message_nearest;
    private $last_time;
    private $user_id;
    private $sender_name;
    public function __construct($name = null, $message_nearest = null, $last_time = null, $user_id = null,$sender_name = null)
    {
        $this->name = $name;
        $this->message_nearest = $message_nearest;
        $this->last_time = $last_time;
        $this->user_id = $user_id;
        $this->sender_name = $sender_name;
    }

    // Getter và Setter cho $name
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    // Getter và Setter cho $message_nearest
    public function getMessageNearest()
    {
        return Str::limit($this->message_nearest, 30, '...');
    }

    public function setMessageNearest($message_nearest)
    {
        $this->message_nearest = $message_nearest;
    }

    // Getter và Setter cho $last_time
    public function getLastTimeString()
    {
        if(!$this->last_time){
            return "";
        }
        // Chuyển đổi last_time thành đối tượng Carbon
        $date = Carbon::parse($this->last_time);
    
        // Kiểm tra xem có thuộc năm hiện tại không
        if ($date->isCurrentYear()) {
            // Nếu thuộc năm hiện tại, trả về dạng dd/mm
            return $date->format('d/m');
        } else {
            // Nếu không thuộc năm hiện tại, trả về dạng dd/mm/yy
            return $date->format('d/m/y');
        }
    }
    public function getLastTime()
    {
        return $this->last_time;
    }
    public function setLastTime($last_time)
    {
        $this->last_time = $last_time;
    }

    // Getter và Setter cho $user_id
    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }
    public function getSenderName()
    {
        return $this->sender_name;
    }

    public function setSenderName($sender_name)
    {
        $this->sender_name = $sender_name;
    }
    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'message_nearest' => $this->message_nearest,
            'last_time' => $this->last_time,
            'user_id' => $this->user_id,
            'sender_name' => $this->sender_name
        ];
    }
    
}