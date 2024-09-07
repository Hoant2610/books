<?php

namespace App\Repositories;

use App\Models\Message;
use App\Models\Conversation;

class ChatRepository
{
    public function getConversationByUserId($user_id){
        $conversation = Conversation::where('user_id',$user_id)->first();
        if($conversation){
            return $conversation->messages;
        }
        return '';
    }
    public function addCustomerMessage($user_id,$message){
        $conversation = Conversation::where('user_id',$user_id)->first();
        if($conversation){
            $messageModel = new Message();
            $messageModel->conversation_id = $conversation->id;
            $messageModel->sender_id = $user_id;
            $messageModel->message = $message;
            $messageModel->save();
            return $messageModel;
        }
        else{
            $conversation = new Conversation();
            $conversation->user_id = $user_id;
            $conversation->save();
            $messageModel = new Message();
            $messageModel->conversation_id = $conversation->id;
            $messageModel->sender_id = $user_id;
            $messageModel->message = $message;
            $messageModel->save();
            return $messageModel;
        }
    }
    public function addAdminMessage($user_id,$message){
        $conversation = Conversation::where('user_id',$user_id)->first();
        if($conversation){
            $messageModel = new Message();
            $messageModel->conversation_id = $conversation->id;
            $messageModel->sender_id = 0;
            $messageModel->message = $message;
            $messageModel->save();
            return $messageModel;
        }
        else{
            $conversation = new Conversation();
            $conversation->user_id = $user_id;
            $conversation->save();
            $messageModel = new Message();
            $messageModel->conversation_id = $conversation->id;
            $messageModel->sender_id = $user_id;
            $messageModel->message = $message;
            $messageModel->save();
            return $messageModel;
        }
    }
}
