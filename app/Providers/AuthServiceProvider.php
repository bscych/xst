<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Model\Course;
use App\Policies\CoursePolicy;
use App\Model\School;
use App\Policies\SchoolPolicy;
use App\Model\Student;
use App\Policies\StudentPolicy;
use App\Model\Constant;
use App\Policies\ConstantPolicy;
use App\Model\Spend;
use App\Policies\SpendPolicy;
use App\Model\Classmodel;
use App\Policies\ClassmodelPolicy;
use App\Model\Income;
use App\Policies\IncomePolicy;
use App\Model\Homework;
use App\Policies\HomeworkPolicy;
use App\Model\Schedule;
use App\Policies\SchedulePolicy;
use App\Model\Specialdate;
use App\Policies\SpecialdatePolicy;
use App\Model\Menuitem;
use App\Policies\MenuitemPolicy;
use App\Model\Menu;
use App\Policies\MenuPolicy;
use App\Model\Visitor;
use App\Policies\VisitorPolicy;
class AuthServiceProvider extends ServiceProvider {

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        School::class => SchoolPolicy::class,
        Constant::class => ConstantPolicy::class,
        App\User::class => App\Policies\UserPolicy::class,
        Course::class => CoursePolicy::class,
        Student::class => StudentPolicy::class,
        Spend::class => SpendPolicy::class,
        Classmodel::class => ClassmodelPolicy::class,
        Income::class => IncomePolicy::class,
        Schedule::class => SchedulePolicy::class,
        Specialdate::class => SpecialdatePolicy::class,
        Menuitem::class => MenuitemPolicy::class,
        Menu::class => MenuPolicy::class,
//        App\Model\Event::class => App\Policies\EventPolicy::class,
        Visitor::class => VisitorPolicy::class,
//        App\Model\Payment::class => App\Policies\PaymentPolicy::class,
//        App\Model\Serviceitem::class => App\Policies\ServiceitemPolicy::class,
        Homework::class => HomeworkPolicy::class,
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
            return $user->roles->whereIn('name', ['admin'])->count() > 0;
        });

        Gate::define('view-student', function ($user) {
            return $user->roles->whereIn('name', ['headmaster', 'supervisor'])->count() > 0;
        });
        Gate::define('view-visitor', function ($user) {
            return $user->roles->whereIn('id', [46])->count() > 0;
        });

        Gate::define('view-course', function ($user) {
            return $user->roles->whereIn('name', ['headmaster', 'supervisor'])->count() > 0;
        });

        Gate::define('view-constant', function ($user) {
            return $user->roles->whereIn('id', [46, 47])->count() > 0;
        });
        Gate::define('view-user', function ($user) {
            return $user->roles->whereIn('id', [46, 47])->count() > 0;
        });
        Gate::define('view-parent', function($user) {
            return $user->roles->where('name', 'parent')->count() > 0;
        });
        Gate::define('view-class', function($user) {
            return $user->roles->whereIn('name', ['teacher'])->count() > 0;
        });
        Gate::define('view-homework', function($user) {
            return $user->roles->whereIn('name', ['teacher', 'supervisor', 'headmaster'])->count() > 0;
        });
        Gate::define('view-tck-statistic', function($user) {
            return $user->roles->where('name', 'teacher')->count() > 0 or $user->roles->whereIn('name', ['headmaster'])->count() > 0;
        });
        Gate::define('view-finance', function($user) {
            return $user->roles->whereIn('name', ['headmaster'])->count() > 0;
        });

        Gate::define('view-canteen', function($user) {
            return $user->roles->whereIn('name', ['headmaster', 'supervisor'])->count() > 0;
        });
    }

}
