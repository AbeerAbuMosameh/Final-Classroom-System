<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    //Mutators -- set
    public function setEmailAttribute($value)
    {
        //  $this->email = strtolower($value); // recursive function
        $this->attributes['email'] = strtolower($value); // just to exist attribute , before stored in db
    }


//    //define accessor and Mutators
//    protected function email(){
//        return Attribute::make(null , function ($value){
//            return strtolower($value); // just to exist attribute , before stored in db
//        });
//    }

    protected function email()
    {
        return Attribute::make(
            get: fn($value) => strtoupper($value),
            set: fn($value) => strtolower($value)
        );
    }
    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, //related model
            'classroom_user',                           //pivot table
            'user_id',                           // FK for current model in pivot table
            'classroom_id',                      // FK for related model in pivot table
            'id',                                    //PK for current model
            'id')->withPivot(['role', 'created_at']);
    }
    public function createdClassrooms() //as owner of classroom -- user create many classroom
    {
        return $this->hasMany(Classroom::class, 'user_id');
    }
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function submissions()
    {
        return  $this->hasMany((Submission::class));
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function messages()
    {
        return $this->morphMany(Message::class , 'recipient' );
    }

    public function receivedMessages()
    {
        return $this->morphMany(Message::class , 'sender_id' );
    }


    public function sentMessages()
    {
        return $this->hasMany(Message::class , 'sender_id' );
    }


}
