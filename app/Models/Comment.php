<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'commentable_id', 'commentable_type', 'content', 'ip', 'user_agent'];

    protected $with = [
        'user'
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
         'name'=>'UnKown User',
       ]);

    }


    public function commentable()
    {
        return $this->morphTo();
    }
}
