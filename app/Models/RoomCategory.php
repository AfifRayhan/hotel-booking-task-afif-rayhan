<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomCategory extends Model
{
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

}
