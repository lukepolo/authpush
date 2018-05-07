<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Gate::define('account-access', function ($user, $account) {
            return $user->id == $account->user_id;
        });

        Gate::define('device-access', function ($user, $device) {
            return $user->id == $device->user_id;
        });
        
        Gate::define('develops-application', function ($user, $application) {
            return $user->id == $application->developer_id;
        });
    }
}
