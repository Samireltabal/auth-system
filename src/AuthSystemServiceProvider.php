<?php 
    namespace SamirEltabal\AuthSystem;

    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\ServiceProvider;
    use SamirEltabal\AuthSystem\commands\InstallCommand;


    class AuthSystemServiceProvider extends ServiceProvider {

        public function boot() {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
            $this->registerRoutes();
            if ($this->app->runningInConsole()) {
                $this->commands([
                    InstallCommand::class,
                ]);
            }
        }

        public function register() {
            $this->mergeConfigFrom(__DIR__.'/config/AuthConfig.php', 'auth');
        }

        protected function registerRoutes()
        {
            Route::group($this->routeConfiguration(), function () {
                $this->loadRoutesFrom(__DIR__.'/./Routes/Routes.php');
            });
        }

        protected function routeConfiguration()
        {
            return [
                'prefix' => config('auth.prefix'),
                'middleware' => config('auth.middleware'),
            ];
        }
    }