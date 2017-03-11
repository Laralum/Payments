<?php

namespace Laralum\Payments;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

use Laralum\Payments\Models\Settings;
use Laralum\Payments\Policies\SettingsPolicy;

use Laralum\Permissions\PermissionsChecker;

class PaymentsServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Settings::class => SettingsPolicy::class,
    ];

    /**
     * The mandatory permissions for the module.
     *
     * @var array
     */
    protected $permissions = [
        [
            'name' => 'Payments Access',
            'slug' => 'laralum::payments.access',
            'desc' => "Grants access to payments",
        ],
        [
            'name' => 'Payments Settings',
            'slug' => 'laralum::payments.settings',
            'desc' => "Allows edititing the payments settings",
        ],
    ];
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->loadTranslationsFrom(__DIR__.'/Translations', 'laralum_payments');

        $this->loadViewsFrom(__DIR__.'/Views', 'laralum_payments');

        if (!$this->app->routesAreCached()) {
            require __DIR__.'/Routes/web.php';
            require __DIR__.'/Routes/api.php';
        }

        $this->loadMigrationsFrom(__DIR__.'/Migrations');

        $this->app->register('Laravel\\Cashier\\CashierServiceProvider');

        // Make sure the permissions are OK
        PermissionsChecker::check($this->permissions);
    }

    /**
     * I cheated this comes from the AuthServiceProvider extended by the App\Providers\AuthServiceProvider
     *
     * Register the application's policies.
     *
     * @return void
     */
    public function registerPolicies()
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
