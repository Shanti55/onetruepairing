<?php

namespace App\Livewire;

use App\Events\MessageSendEvent;
use App\Models\JobPost;
use App\Models\Message;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class ChatComponent extends Component
{
    public $job;
    public $user;
    public $sender_id;
    public $receiver_id;
    public $message = '';
    public $messages = [];


    public function render()
    {
        return view('livewire.chat-component');
    }

    public function mount($job,$user_id)
    {
        $this->job = JobPost::find($job->id);
        $this->user = User::find($user_id);
        $this->sender_id = auth()->user()->id;
        $this->receiver_id = $user_id;

        $messages = Message::where(function ($query){
            $query->where('sender_id',$this->sender_id)
                  ->where('receiver_id',$this->receiver_id)
                  ->where('job_post_id',$this->job->id);
        })->orWhere(function ($query){
            $query->where('sender_id',$this->receiver_id)
                ->where('receiver_id',$this->sender_id)
                ->where('job_post_id',$this->job->id);
        })

        ->with('sender:id,name','receiver:id,name')->get();
        foreach ($messages as $message){
            $this->appendChatMessage($message);
        }

    }

    public function sendMessage()
    {
        $chatMessage = new Message();
        $chatMessage->sender_id = $this->sender_id;
        $chatMessage->receiver_id = $this->receiver_id;
        $chatMessage->job_post_id = $this->job->id;
        $chatMessage->message = $this->message;
        $chatMessage->save();
        $this->appendChatMessage($chatMessage);
        broadcast(new MessageSendEvent($chatMessage))->toOthers();
        $this->message = '';

    }


    //Listener
    #[On('echo-private:chat-channel.{sender_id},MessageSendEvent')]
    public function listenForMessage($event)
    {
        $chatMessage = Message::whereId($event['message']['id'])
            ->where('job_post_id',$this->job->id)
            ->with('sender:id,name','receiver:id,name')
            ->first();
        $this->appendChatMessage($chatMessage);
    }

    public function appendChatMessage($message){
        $this->messages[] = [
          'id'=>$message->id,
          'message'=>$message->message,
          'sender'=>$message->sender->name,
          'receiver'=>$message->receiver->name,
          'sender_id'=>$message->sender_id,
          'receiver_id'=>$message->receiver_id,
          'created_at'=>$message->created_at,
        ];
    }

}
