<?php

namespace App\Models;

use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function createdAtHuman(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getCreatedAtHumanDate()
        );
    }

    protected function getCreatedAtHumanDate()
    {

        $day = match (true) {
            $this->created_at->isToday() => 'Today',
            $this->created_at->isYesterday() => 'Yesterday',
            default => $this->created_at->toDateString()
        };

        // $day = $this->created_at->toDateString();
        // if ($this->created_at->isToday()) {
        //     $day = 'Today';
        // }
        // if ($this->created_at->isYesterday()) {
        //     $day = 'Yesterday';
        // }
        // return $day . ' ' . $this->created_at->toTimeString('minute');

        return $day . ' ' . $this->created_at->toTimeString('minute');;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}