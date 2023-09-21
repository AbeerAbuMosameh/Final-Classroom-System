<?php

namespace App\Models;

use App\Enums\classworkType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Classwork extends Pivot
{
    use HasFactory;

    protected $fillable = ['classroom_id','user_id','topic_id','title','description','type','status','published_at','options'];

    protected $table = 'classworks';

    const TYPE_ASSIGNMENT =classworkType::TYPE_ASSIGNMENT;
    const TYPE_MATERIAL = classworkType::TYPE_MATERIAL;
    const TYPE_QUESTION = classworkType::TYPE_QUESTION;
    const STATUS_PUBLISHED = 'published';
    const STATUS_DRAFT = 'draft';

    public $incrementing = true;


    protected $casts = [
        'options' =>'json',
        'published_at' =>'datetime',
        ];


    protected  static function booted(){
        static::creating(function(Classwork $classwork){
            if(!$classwork->published_at){
                $classwork->published_at = now();
            }
        });
    }
    public function getPublishedDateAttribute()
    {
        if($this->published_at){
            return   $this->published_at->format('Y-m-d');
        }
    }

    //Relations
    public function classroom(){
        return $this->belongsTo(Classroom::class );
    }

    public function topic(){
       return $this->belongsTo(Topic::class );
    }

    public function users() : BelongsToMany
    {
        return  $this->belongsToMany(User::class,
            'classwork_user',  //pivot table
            'classwork_id', // FK for current model in pivot table
            'user_id') // FK for related model in pivot table)
            ->withPivot(['grade','submitted_at','created_at','status'])
            ->using(ClassworkUser::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class,'commentable')->latest();
    }
    public function submissions()
    {
        return  $this->hasMany((Submission::class));
    }

}
