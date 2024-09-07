<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ChatService;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    private ChatService $chatService;

    public function __construct(ChatService $chatService){
        $this->chatService = $chatService;
    }
    public function viewChat(){
        return view('admin.chat')->with('customers',$this->chatService->getUserChatDTO());
    }
    public function getCustomerConversation(){
        $user = Auth::user();
        if($user->role == 'customer'){
            return $this->chatService->getConversationByUserId($user->id);
        }
        return response()->json(['error'=>'Unauthorized '],401);
    }
    // role : admin
    public function getCustomerConversationByUserId(Request $request){
        $user_id = $request->user_id;
        return $this->chatService->getConversationByUserId($user_id);
    }
    public function addAdminMessage(Request $request){
        $message = $request->message;
        $user = Auth::user();
        if($user->role == 'admin'){
            $message =  $this->chatService->addAdminMessage($user->id,$message);
            return response()->json(['message'=>$message],200);
        }
        return response()->json(['error'=>'Unauthorized '],401);
    }
    public function addCustomerMessage(Request $request){
        $message = $request->message;
        $user = Auth::user();
        if($user->role == 'customer'){
            $message =  $this->chatService->addCustomerMessage($user->id,$message);
            return response()->json(['message'=>$message],200);
        }
        return response()->json(['error'=>'Unauthorized '],401);
    }
}
