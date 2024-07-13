<?php

namespace App\Livewire\Chat;

use App\Models\Message as ModelsMessage;
use Livewire\Component;

class Message extends Component
{
    public ModelsMessage $message;
    public function render()
    {
        return view('livewire.chat.message');
    }
}