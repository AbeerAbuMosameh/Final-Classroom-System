<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Classroom;
use App\Models\Classwork;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

//        //allow all action to super admin
//        Gate::before(function (User $user, $ability){
//            if($user->super_admin){
//                return true;
//            }
//            //else check bellow permission
//        });
//
//        //Define Gates (abilities)
//        Gate::define('create-classwork', function (User $user, Classroom $classroom) { //object of authenticated/current user
//            $result =  $user->classrooms()
//                ->wherePivot('classroom_id', $classroom->id)
//                ->wherePivot('role', 'teacher')
//                ->exists(); // Is teacher in specific classroom
//
//            return $result  ?
//                Response::allow() :
//                Response::deny('not allowed');
//        });
//
//        Gate::define('update-classwork', function (User $user, Classroom $classroom) { //object of authenticated/current user
//            return $user->classrooms()
//                ->wherePivot('classroom_id', $classroom->id)
//                ->wherePivot('role', 'teacher')
//                ->exists(); // Is teacher in specific classroom
//        });
//
////        Gate::define('delete-classwork', function (User $user, Classwork $classwork) { //object of authenticated/current user
////            return $classwork->user_id == $user->id ;
////        });
////        //owner of classroom
//
//        Gate::define('delete-classwork', function (User $user, Classwork $classwork) { //object of authenticated/current user
//            return $classwork->user_id == $user->id  && $user->classrooms()
//                    ->wherePivot('classroom_id', $classwork->classroom_id)
//                    ->wherePivot('role', 'teacher')
//                    ->exists();
//        });
//        //owner of classroom
//
//        Gate::define('view-classwork', function (User $user, Classwork $classwork) { //object of authenticated/current user
//            $teacher = $user->classrooms()
//                ->wherePivot('role', 'teacher')
//                ->wherePivot('classroom_id', $classwork->classroom_id)
//                ->exists(); // any user in this classroom
//            $assigned = $user->classworks()
//                ->wherePivot('classwork_id', $classwork->id)
//                ->exists();
//
//            return ($teacher || $assigned);
//        });
//
//        //Define Gates (abilities)
//        Gate::define('create-submission', function (User $user, Classwork $classwork) { //object of authenticated/current user
//            $teacher = $user->classrooms()
//                ->wherePivot('role', 'teacher')
//                ->wherePivot('classroom_id', $classwork->classroom_id)
//                ->exists(); // any user in this classroom
//            if($teacher){
//                return false;
//            }
//            return $user->classworks()
//                ->wherePivot('classwork_id', $classwork->id)
//                ->exists();
//        });
    }
}
