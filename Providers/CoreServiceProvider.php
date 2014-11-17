<?php namespace Core\Providers;

use Illuminate\Support\ServiceProvider;
use Core\Console\InstallCommand;
use User\Entities\User;
use User\Repositories\UserRepository;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * @var UserRepository
     */
    private $user;

    public function __construct($app){

        $this->app = $app;
    }
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * The filters base class name.
     *
     * @var array
     */
    protected $filters = [
        'Core' => [
            'permissions' => 'PermissionFilter',
            'auth.admin' => 'AdminFilter',
        ]
    ];

    public function boot()
    {
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
//        $this->loadModuleProviders();
        $this->app->booted(function ($app) {
            $this->registerFilters($app['router']);
        });
        $this->registerCommands();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    /**
     * Load the Service Providers for all enabled modules
     */
    private function loadModuleProviders()
    {
        $this->app->booted(function ($app) {
//            var_dump($app['modules']->all()); exit;
            $modules = $app['modules']->getEnabled();
            foreach ($modules as $module) {
                if ($providers = $app['modules']->prop("{$module}::providers")) {
                    foreach ($providers as $provider) {
//                        $app->register($provider);
                    }
                }
            }
        });
    }

    /**
     * Register the filters.
     *
     * @param  Router $router
     * @return void
     */
    public function registerFilters($router)
    {
        foreach ($this->filters as $module => $filters) {
            foreach ($filters as $name => $filter) {
                $class = "modules\\{$module}\\Http\\Filters\\{$filter}";
                $router->filter($name, $class);
            }
        }
    }

    /**
     * Register the console commands
     */
    private function registerCommands()
    {
        $this->registerInstallCommand();
    }

    /**
     * Register the installation command
     */
    private function registerInstallCommand()
    {
        $this->app->bindShared('command.platform.install', function ($app) {
            return new InstallCommand(
                $app['files'],
                $app
            );
        });

        $this->commands(
            'command.platform.install'
        );
    }
}
