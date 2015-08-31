<?php
/**
 * A laravel service provider to register the class into the the IoC container
 */
namespace Froiden\Knife;

use App;
use Blade;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Log;

/**
 * A laravel service provider to register the class into the the IoC container
 *
 * @package        Froiden\Knife
 * @version        1.0
 * @author         Shashank Jain
 * @license        MIT License - http://radic.mit-license.org
 * @copyright      2011-2015, Froiden Technologies Pvt Ltd.
 * @link           http://www.froiden.com/
 *
 */
class KnifeServiceProvider extends ServiceProvider
{

    public function boot()
    {
        // Publish our configuration file
        $this->publishes([
            __DIR__ . '/config/knife.php' => config_path('knife.php'),
        ]);

        // Merge the default config file
        $this->mergeConfigFrom(
            __DIR__ . '/config/knife.php', 'knife'
        );
    }

    public function register()
    {
        RegisterDirectives::datetime();
        RegisterDirectives::date();
        RegisterDirectives::time();
        RegisterDirectives::_use();
        RegisterDirectives::nl2br();
        RegisterDirectives::escape();
        RegisterDirectives::breakpoint();
        RegisterDirectives::set();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {

    }
}
