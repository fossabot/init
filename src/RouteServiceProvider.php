<?php
    
    namespace Weeq\Init\Providers;
    
    use Weeq\Init\Http\Middleware\TokenAuthenticate;
    use Illuminate\Support\Facades\Route;
    use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
    
    class RouteServiceProvider extends ServiceProvider
    {
        /**
         * This namespace is applied to your controller routes.
         *
         * In addition, it is set as the URL generator's root namespace.
         *
         * @var string
         */
        protected $namespace = 'Weeq\Init\Http\Controllers';
        
        /**
         * Define your route model bindings, pattern filters, etc.
         *
         * @return void
         */
        public function boot()
        {
            //
            
            parent::boot();
        }
        
        /**
         * Define the routes for the application.
         *
         * @return void
         */
        public function map()
        {
            $this->aliasMiddleware('token', TokenAuthenticate::class);
            
            $this->mapApiUsersRoutes();
            $this->mapApiRolesRoutes();
            $this->mapApiRoutes();
//
            $this->mapWebRoutes();
        }
        
        /**
         * Define the "web" routes for the application.
         *
         * These routes all receive session state, CSRF protection, etc.
         *
         * @return void
         */
        protected function mapWebRoutes()
        {
            Route::middleware('web')
                ->namespace($this->namespace)
                ->prefix('/admin')
                ->group(__DIR__ . "/../routes/web.php");
        }
        
        /**
         * Define the "api" routes for the application.
         *
         * These routes are typically stateless.
         *
         * @return void
         */
        protected function mapApiRoutes()
        {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace . "\API")
                ->group(__DIR__ . "/../routes/api.php");
        }
        
        /**
         * Define the "api/users" routes for the application.
         *
         * These routes are typically stateless.
         *
         * @return void
         */
        protected function mapApiUsersRoutes()
        {
            Route::prefix('api/users')
                ->middleware(['api', 'token'])
                ->namespace($this->namespace . "\API\USERS")
                ->group(__DIR__ . '/../routes/users.php');
        }
        
        /**
         * Define the "api/roles" routes for the application.
         *
         * These routes are typically stateless.
         *
         * @return void
         */
        protected function mapApiRolesRoutes()
        {
            Route::prefix('api/roles')
                ->middleware(['api', 'token'])
                ->namespace($this->namespace . "\API\ROLES")
                ->group(__DIR__ . '/../routes/roles.php');
        }
    }
