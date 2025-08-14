<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Content\Post;
use Illuminate\Auth\Access\Response;
use App\Policies\PostPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Post::class => PostPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate::define('update-post', function (User $user, Post $post){
        //     return $user->id === $post->author_id;
        // });

        // Gate::define('update-post', function (User $user){
        //     return $user->user_type === 1 ?  Response::allow()
        //     : Response::deny('شما اجازه دسترسی ندارید');
        // });

        // Gate::define('update-post', function (User $user){
        //     return $user->user_type === 1 ?  Response::allow()
        //     : Response::denyWithStatus(404);
        // });

        // Gate::before('update-post', function (User $user){
        //     return $user->user_type === 1 ?  Response::allow()
        //     : Response::denyWithStatus(404);
        // });

        // Gate::after('update-post', function (User $user){
        //     return $user->user_type === 1 ?  Response::allow()
        //     : Response::denyWithStatus(404);
        // });

        Gate::define('update-post', [PostPolicy::class, 'update']);
    }
}
