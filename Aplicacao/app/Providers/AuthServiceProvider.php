<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Permission;

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
    public function boot(GateContract $gate)
    {
        parent::registerPolicies($gate);

        // Dynamically register permissions with Laravel's Gate.
        foreach ($this->getPermissions() as $permission) {
            $gate->define($permission->label, function ($user) use ($permission) {
                return $user->hasPermission($permission->label);
            });
        }
    }

    /**
     * Fetch the collection of site permissions.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getPermissions()
    {
        $p = [];
        try {
            return  Permission::with('roles')->get();
        } catch (\Exception $e) {
            return $p;
        }
    }
}
