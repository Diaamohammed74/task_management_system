<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Task;
use App\Models\Project;
use App\Models\Category;
use App\Policies\TaskPolicy;
use App\Policies\ProjectPolicy;
use App\Policies\CategoryPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
            Category::class=>CategoryPolicy::class,
            Project::class=>ProjectPolicy::class,
            Task::class=>TaskPolicy::class,
    ];


    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
