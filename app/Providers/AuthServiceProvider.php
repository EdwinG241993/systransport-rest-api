<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\AffiliatedCompany;
use App\Models\Car;
use App\Models\Conductor;
use App\Models\Employee;
use App\Models\Route;
use App\Models\Turn;
use App\Models\Client;
use App\Models\Ticket;
use App\Policies\AffiliatedCompanyPolicy;
use App\Policies\CarCompanyPolicy;
use App\Policies\ClientCompanyPolicy;
use App\Policies\ConductorCompanyPolicy;
use App\Policies\EmployeeCompanyPolicy;
use App\Policies\RouteCompanyPolicy;
use App\Policies\TicketCompanyPolicy;
use App\Policies\TurnCompanyPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        AffiliatedCompany::class => AffiliatedCompanyPolicy::class,
        Car::class => CarCompanyPolicy::class,
        Client::class => ClientCompanyPolicy::class,
        Conductor::class => ConductorCompanyPolicy::class,
        Employee::class => EmployeeCompanyPolicy::class,
        Route::class => RouteCompanyPolicy::class,
        Ticket::class => TicketCompanyPolicy::class,
        Turn::class => TurnCompanyPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('index-affiliated-company', 'AffiliatedCompanyPolicy@index');
        Gate::define('store-affiliated-company', 'AffiliatedCompanyPolicy@store');        
        Gate::define('show-affiliated-company', 'AffiliatedCompanyPolicy@show');
        Gate::define('update-affiliated-company', 'AffiliatedCompanyPolicy@update');
        Gate::define('delete-affiliated-company', 'AffiliatedCompanyPolicy@delete');
    }
}
