<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    // protected $casts = ['hour' => 'array'];

    public function checkins()
    {
        return $this->hasMany(Checkin::class);
    }
}
