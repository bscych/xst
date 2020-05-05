<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Model\Constant;
use App\Policies\ConstantPolicy;
use App\Model\School;
use App\Policies\SchoolPolicy;
use App\User;
use App\Policies\UserPolicy;
use App\Model\Course;
use App\Policies\CoursePolicy;
use App\Model\Student;
use App\Policies\StudentPolicy;
use App\Model\Spend;
use App\Policies\SpendPolicy;
use App\Model\Classmodel;
use App\Policies\ClassmodelPolicy;
use App\Model\Income;
use App\Policies\IncomePolicy;
use App\Model\Schedule;
use App\Policies\SchedulePolicy;
use App\Model\Specialdate;
use App\Policies\SpecialdatePolicy;

class AuthServiceProvider extends ServiceProvider {

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        School::class => SchoolPolicy::class,
        Constant::class => ConstantPolicy::class,
        User::class => UserPolicy::class,
        Course::class => CoursePolicy::class,
        Student::class => StudentPolicy::class,
        Spend::class => SpendPolicy::class,
        Classmodel::class => ClassmodelPolicy::class,
        Income::class => IncomePolicy::class,
        Schedule::class => SchedulePolicy::class,
        Specialdate::class => SpecialdatePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot() {
        $this->registerPolicies();

        //define Gates
        Gate::define('view-school', function ($user) {   
          return $user->roles->whereIn('name',['admin','headmaster'])->count()>0;
        });

        Gate::define('view-student', function ($user) {
            return $user->roles->whereIn('name',['admin','headmaster','supervisor'])->count()>0;
        });
        
         Gate::define('view-course', function ($user) {
            return $user->roles->whereIn('name',['admin','headmaster','supervisor'])->count()>0;
        });

        Gate::define('view-constant', function ($user) {
            return $user->name === 'bscych';
        });
         Gate::define('view-user', function ($user) {
            return $user->roles->where('name','admin')->count()>0 or $user->roles->where('name','headmaster')->count()>0;
        });
        Gate::define('view-parent',function($user){
            return $user->roles->where('name','parent')->count()>0;
        });
         Gate::define('view-class',function($user){
            return $user->roles->where('name','teacher')->count()>0;
        });
          Gate::define('view-finance',function($user){
            return $user->roles->whereIn('name',['admin','headmaster'])->count()>0;
        });
        
        Gate::define('view-canteen',function($user){
            return $user->roles->whereIn('name',['admin','headmaster','supervisor'])->count()>0;
        });
        
    }

}
