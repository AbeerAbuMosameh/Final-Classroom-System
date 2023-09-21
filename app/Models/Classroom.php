<?php

namespace App\Models;

use App\Models\Scopes\UserClassroomScope;
use App\Observers\ClassroomObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Classroom extends Model
{
    use HasFactory , softDeletes;
    protected $fillable = ['name','room','subject','section','cover_image','code','them','status','user_id'];



    //after model initialization
    protected static function booted()
    {
//         static::addGlobalScope('users',function(Builder $query){
//             $query->where('user_id','=', Auth::id());
//         });

       static::observe(ClassroomObserver::class);
        // GLOBAL SCOPE in Models
        static::addGlobalScope(new UserClassroomScope());

//          static::creating(function(Classroom $classroom){
//                    $classroom->code = Str::random(8);
//                    $classroom->user_id = Auth::id();
//                });
//
//             static::forceDeleted(function(Classroom $classroom){
//                      static::deleteCoverImage($classroom->cover_image_path);
//                });
//
//               static::deleted(function(Classroom $classroom){
//                  if($classroom->isForceDeleting()){
//                      return ;
//                  }
//                 $classroom->status = 'deleted';
//                 $classroom->save();
//
//               });
//
//
//               static::restored(function(Classroom $classroom){
//
//                $classroom->status = 'active';
//                  // to change the status
//                $classroom->save();
//
//              });

    }


    //Relations
    public function classworks():HasMany
    {
        return  $this->hasMany(Classwork::class , 'classroom_id');
    }
    public function topics():HasMany
    {
        return $this->hasMany(Topic::class , 'classroom_id');
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class );
    }
    public function users()
    {
        return $this->belongsToMany(User::class , //related model
            'classroom_user',  //pivot table
            'classroom_id', // FK for current model in pivot table
            'user_id', // FK for related model in pivot table
            'id', //PK for current model
            'id')->withPivot(['role','created_at']); //PK for related model
//        ->as('join') name nested of pivot  $user->join->role
        //to make this relation for teacher or student (condition on related model)
        // ->wherePivot('role' , 'teacher');
    }
    public function teachers()
    {
      return  $this->users()->wherePivot('role' , 'teacher');
    }
    public function students()
    {
        return  $this->users()->wherePivot('role' , 'student');
    }

    public function streams(){
        return $this->hasMany(Stream::class)->latest();
    }

    //Scopes
    public function scopeActive(Builder $query){
        $query->where('status','=','active');
    }
    public function scopeRecent(Builder $query){
        $query->orderBy('updated_at','DESC');

    }
    public function scopeStatus(Builder $query,$status='active'){
        $query->where('status','=',$status);

    }



    public function join($user_id,$role='student'){

        $exists =  $this->users()->wherePivot('user_id',$user_id)->exists(); // search on sql relation

        if ($exists){
           toastr()->error('You joined This Class previously');
           return redirect()->back();
        }
        if( $role == 'student') {
            //attach allow array of id's of classroom
            toastr()->success('You joined This Classroom ');
        }else{
            toastr()->success('Classroom Created Successfully');
        }

        return $this->users()->attach($user_id ,[
            'role' => $role,
            'created_at' => now(),
        ]);
        // attach insert in pivot table like bellow
//        return DB::table('classroom_user')->insert([
//            'classroom_id' => $this->id,
//            'user_id' => $user_id,
//            'role' => $role,
//            'created_at' => now(),
//        ]);
    }
    public function getNameAttribute($value){
        return strtoupper($value);
    }
    public function getUrlAttribute($value){
        return route('');
    }

    //Accessors -- classroom->cover_image_url [define new attribute] , get
//    public function getCoverImageUrlAttribute(){
//        if($this->cover_image){
////            $imagePath = str_replace('storage/', '', $this->cover_image_url);
//            return Storage::disk('public')->url($this->cover_image_url);
//        }
//        return 'https://placehold.co/600x400';
//
//    }

    public function messages()
    {
        return $this->morphMany(Message::class , 'recipient' );
    }

    public static function deleteCoverImage($path)
    {

        if ($path && Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }
    }

}
