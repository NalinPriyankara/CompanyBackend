<?php

namespace App\Providers;

use App\Repositories\All\Auth\AuthInterface;
use App\Repositories\All\Auth\AuthRepository;
use App\Repositories\All\Contact\ContactInterface;
use App\Repositories\All\Contact\ContactRepository;
use App\Repositories\All\Feedback\FeedbackInterface;
use App\Repositories\All\Feedback\FeedbackRepository;
use App\Repositories\All\Project\ProjectInterface;
use App\Repositories\All\Project\ProjectRepository;
use App\Repositories\All\Logo\LogoInterface;
use App\Repositories\All\Logo\LogoRepository;
use App\Repositories\All\SecurityRoles\SecurityRolesInterface;
use App\Repositories\All\SecurityRoles\SecurityRolesRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\All\UserManagement\UserManagementInterface;
use App\Repositories\All\UserManagement\UserManagementRepository;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserManagementInterface::class, UserManagementRepository::class);
        $this->app->bind(AuthInterface::class, AuthRepository::class);
        $this->app->bind(SecurityRolesInterface::class, SecurityRolesRepository::class);
        $this->app->bind(ProjectInterface::class, ProjectRepository::class);
        $this->app->bind(LogoInterface::class, LogoRepository::class);
        $this->app->bind(FeedbackInterface::class, FeedbackRepository::class);
        $this->app->bind(ContactInterface::class, ContactRepository::class);
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $router = $this->app->make(\Illuminate\Routing\Router::class);

        if (method_exists($router, 'aliasMiddleware')) {
            $router->aliasMiddleware('permission', \App\Http\Middleware\CheckPermission::class);
        } else {
            $router->middleware('permission', \App\Http\Middleware\CheckPermission::class);
        }
    }
}
