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
        //
    }

    public function register()
    {
        // Register command
        $this->app->singleton('command.knife.update', function($app) {
            return new UpdateLibraries();
        });
        $this->commands('command.knife.update');

        // Get contents of index file
        $indexContents = file_get_contents( __DIR__ ."\index.json");

        // Parse content json
        $index = json_decode($indexContents);

        Blade::directive('css', function($expression) use ($index) {

            preg_match_all('/"(.*?)"/i', $expression, $libs);

            // This will contain the output
            $output = "";

            foreach($libs[0] as $lib) {
                // Modify the lib for common aliases
                $lib = strtolower($lib);

                $lib = preg_replace("/[\-\. \"]/i", "", $lib);

                // Check is right library was included and process accordingly
                if (isset($index->$lib)) {
                    foreach ($index->$lib->css as $css) {
                        $output .= '<link media="all" type="text/css" rel="stylesheet" href="' . $css . '">' . "\n";
                    }
                } else {
                    Log::error("This library was not found: $lib");
                }
            }
            return $output;
        });

        Blade::directive('script', function ($expression) use ($index) {

            preg_match_all('/"(.*?)"/i', $expression, $libs);

            // This will contain the output
            $output = "";

            foreach ($libs[0] as $lib) {
                // Modify the lib for common aliases
                $lib = strtolower($lib);

                $lib = preg_replace("/[\-\. \"]/i", "", $lib);

                // Check is right library was included and process accordingly
                if (isset($index->$lib)) {
                    foreach ($index->$lib->js as $js) {
                        $output .= '<script type="text/javascript" src="' . $js . '">' . '</script>'."\n";
                    }
                } else {
                    Log::error("This library was not found: $lib");
                }
            }
            return $output;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'command.knife.update'
        ];
    }
}
