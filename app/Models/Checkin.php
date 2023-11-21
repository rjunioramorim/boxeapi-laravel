<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Checkin extends Model
{
    use HasFactory;

    protected $fillable = ['schedule_id', 'hour', 'checkin_date', 'client_id', 'status'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
