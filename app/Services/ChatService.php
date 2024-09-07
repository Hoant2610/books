<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Message;
use App\Models\Conversation;
use App\DTOs\admin\UserChatDTO;
use App\Repositories\ChatRepository;

class ChatService
{
    private ChatRepository $chatRepository;

    public function __construct(ChatRepository $chatRepository){
        $this->chatRepository = $chatRepository;
    }
    public function getConversationByUserId($user_id){
        return $this->chatRepository->getConversationByUserId($user_id);
    }
    public function addAdminMessage($user_id,$message){
        return $this->chatRepository->addAdminMessage($user_id,$message);
    }
    public function addCustomerMessage($user_id,$message){
        return $this->chatRepository->addCustomerMessage($user_id,$message);
    }
    public function getUserChatDTO(){
        $customers = User::where('role', 'customer')->get();
        $userChatDTOs = [];
        foreach($customers as $customer){
            $name = $customer->name;
            $user_id = $customer->id;
            // Check xem co cuoc hoi thoai chua
            $conversation = Conversation::where('user_id',$user_id)->first();
            if($conversation){
                $message_nearest = Message::where('conversation_id', $conversation->id)
                                        ->orderBy('created_at', 'asc')
                                        ->first();
                $sender_name = '';
                if($message_nearest->sender_id == 0){
                    $sender_name = "You : ";
                }
                $userChatDTO = new UserChatDTO($name,$message_nearest->message,$message_nearest->created_at,$user_id,$sender_name);
                $userChatDTOs[] = $userChatDTO;
            }
            else{
                $userChatDTO = new UserChatDTO($name,null,null,$user_id,null);
                $userChatDTOs[] = $userChatDTO;
            }
        }
        usort($userChatDTOs, function($a, $b) {
            // Lấy thời gian của đối tượng a và b
            $timeA = $a->getLastTime();
            $timeB = $b->getLastTime();
            
            // Nếu thời gian của a là null, cho vào cuối
            if (is_null($timeA)) {
                return 1;
            }
            
            // Nếu thời gian của b là null, cho vào cuối
            if (is_null($timeB)) {
                return -1;
            }
            
            // So sánh thời gian, dùng strtotime để chuyển đổi chuỗi thời gian thành timestamp
            $timestampA = strtotime($timeA);
            $timestampB = strtotime($timeB);
            
            // Trả về kết quả so sánh, timestamp lớn hơn sẽ được ưu tiên
            return $timestampB <=> $timestampA;
        });
        
        return $userChatDTOs;
    }
}