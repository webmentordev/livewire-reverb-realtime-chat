<?php

namespace App\Livewire\Chat\Pages;

use App\Events\MessageCreated;
use App\Models\Message;
use App\Models\Room;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

class RoomShow extends Component
{
    #[Layout('layouts.app')]

    public Room $room;

    #[Rule('required')]
    public string $body = '';

    public function submit()
    {
        $this->validate();
        $message = Message::make($this->only('body'));
        $message->room()->associate($this->room);
        $message->user()->associate(auth()->user());
        $message->save();

        // Message::create([
        //     'body' => $this->body,
        //     'room_id' => $this->room->id,
        //     'user_id' => auth()->user()->id
        // ]);

        $this->reset('body');
        $this->dispatch('message.created', $message->id);
        broadcast(new MessageCreated($this->room, $message))->toOthers();
    }


    public function render()
    {
        return view('livewire.chat.pages.room-show');
    }
}