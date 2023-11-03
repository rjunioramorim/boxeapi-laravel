<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    use HasFactory;

    protected $fillable = ['schedule_id', 'hour', 'checkin_date', 'client_id', 'canceled_at', 'confirmed_at', 'realized_at'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
