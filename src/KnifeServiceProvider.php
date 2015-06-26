<?php
/**
 * A laravel service provider to register the class into the the IoC container
 */
namespace Froiden\Knife;

use Blade;
use Log;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

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
        $this->app->singleton('command.knife.update', function ($app) {
            return new UpdateLibraries();
        });
        $this->commands('command.knife.update');

        // Get contents of index file
        $indexContents = file_get_contents(__DIR__ . "\index.json");

        // Parse content json
        $index = json_decode($indexContents);


        Blade::extend(function ($view, $compiler) use($index) {
            $pattern = $compiler->createMatcher('css');

            preg_match_all($pattern, $view, $matches);

            $output = "";

            foreach($matches[2] as $match) {
                 preg_match_all('/"(.*?)"/i', $match, $libs);

                 // This will contain the output
                $temp = "";

                 foreach($libs[0] as $lib) {
                     // Modify the lib for common aliases
                     $lib = strtolower($lib);

                     $lib = preg_replace("/[\-\. \"]/i", "", $lib);

                     // Check is right library was included and process accordingly
                     if (isset($index->$lib)) {
                         foreach ($index->$lib->css as $css) {
                             $temp .= '<link media="all" type="text/css" rel="stylesheet" href="' . $css . '">' . "\n";
                         }
                     } else {
                         Log::error("This library was not found: $lib");
                     }
                 }

                $temp = rtrim($temp, "\n");
                $view = str_replace("@css".$match, $temp, $view);

            }

            return $view;
        });

        Blade::extend(function ($view, $compiler) use($index) {
            $pattern = $compiler->createMatcher('script');

            preg_match_all($pattern, $view, $matches);

            $output = "";

            foreach($matches[2] as $match) {
                 preg_match_all('/"(.*?)"/i', $match, $libs);

                 // This will contain the output
                $temp = "";

                 foreach($libs[0] as $lib) {
                     // Modify the lib for common aliases
                     $lib = strtolower($lib);

                     $lib = preg_replace("/[\-\. \"]/i", "", $lib);

                     // Check is right library was included and process accordingly
                     if (isset($index->$lib)) {
                         foreach ($index->$lib->js as $js) {
                             $temp .= '<script type="text/javascript" src="' . $js . '">' . '</script>'."\n";
                         }
                     } else {
                         Log::error("This library was not found: $lib");
                     }
                 }

                $temp = rtrim($temp, "\n");
                $view = str_replace("@script".$match, $temp, $view);

            }

            return $view;
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
