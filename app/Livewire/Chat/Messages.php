<?php

namespace App\Livewire\Chat;

use App\Models\Message;
use App\Models\Room;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Collection;

class Messages extends Component
{
    public Room $room;

    public Collection $messages;

    #[On('message.created')]
    public function prependMessage($id)
    {
        $this->messages->push(Message::with('user')->find($id));
    }

    public function mount()
    {
        $this->fill([
            'messages' => $this->room->messages()->with('user')->oldest()->take(100)->get()
        ]);
    }

    #[On('echo-private:chat.room.{room.id},MessageCreated')]
    public function prependMessageBroadcast(array $payload)
    {
        $this->prependMessage($payload['message']['id']);
    }

    public function render()
    {
        return view('livewire.chat.messages', []);
    }
}