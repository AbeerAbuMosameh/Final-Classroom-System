<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory , HasUuids ;


    protected $fillable = [''];


    public function sender():BelongsTo
    {
        return $this->belongsTo(User::class , 'sender_id');
    }

    public function recipient()
    {
        return $this->morphTo( );
    }
}
