<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'from_date',
        'to_date',
        'room_category_id',
        'base_price',
        'final_price',
    ];

    // Relationship to RoomCategory
    public function roomCategory()
    {
        return $this->belongsTo(RoomCategory::class);
    }
}
