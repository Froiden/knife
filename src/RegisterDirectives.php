<?php
/**
 * Created by PhpStorm.
 * User: Shashank
 * Date: 21-Aug-15
 * Time: 4:07 PM
 */

namespace Froiden\Knife;


use Illuminate\Support\Facades\Blade;

class RegisterDirectives
{
    private static $templates = [];
    private static $occurrences = [];
    /**
     * Parse the given date and time and format it as in a format given in config
     */
    public static function datetime() {
        Blade::directive('datetime', function ($expression) {

            preg_match_all('/\((.*?)\)/i', $expression, $matches);

            $match = $matches[1][0];

            $format = config('knife.datetime_format');

            $output = "<?php echo \Carbon\Carbon::parse($match)->format('$format'); ?>";

            return $output;
        });
    }

    /**
     * Parse the given date and format it as in a format given in config
     */
    public static function date()
    {
        Blade::directive('date', function ($expression) {

            preg_match_all('/\((.*?)\)/i', $expression, $matches);

            $match = $matches[1][0];

            $format = config('knife.date_format');

            $output = "<?php echo \Carbon\Carbon::parse($match)->format('$format'); ?>";

            return $output;
        });
    }

    /**
     * Parse the given date and time and format it as in a format given in config
     */
    public static function time()
    {
        Blade::directive('time', function ($expression) {

            preg_match_all('/\((.*?)\)/i', $expression, $matches);

            $match = $matches[1][0];

            $format = config('knife.time_format');

            $output = "<?php echo \Carbon\Carbon::parse($match)->format('$format'); ?>";

            return $output;
        });
    }

    /**
     * Add 'use' directive for a particular class
     */
    public static function _use()
    {
        Blade::directive('use', function ($expression) {

            preg_match_all('/\(["\'](.*?)["\']\)/i', $expression, $matches);

            $match = $matches[1][0];
            $output = "<?php use $match; ?>";

            return $output;
        });
    }

    /**
     * Convert new lines in the given string to HTML <br/> tags
     */
    public static function nl2br()
    {
        Blade::directive('nl2br', function ($expression) {

            preg_match_all('/\((.*?)\)/i', $expression, $matches);

            $match = $matches[1][0];
            $output = "<?php echo nl2br($match); ?>";

            return $output;
        });
    }

    /**
     * Escape quotes and other characters in given string
     */
    public static function escape()
    {
        Blade::directive('escape', function ($expression) {
            preg_match_all('/\((.*?)\)/i', $expression, $matches);

            $match = $matches[1][0];
            $output = "<?php echo addslashes($match); ?>";

            return $output;
        });
    }

    /**
     * Add a breakpoint in the view
     */
    public static function breakpoint()
    {
        Blade::directive('break', function ($expression) {

            $output = "<?php if (function_exists('xdebug_break')) { xdebug_break(); } ?>";

            return $output;
        });
    }

    /**
     * Define a variable and set its value
     */
    public static function set()
    {
        Blade::directive('set', function ($expression) {

            preg_match_all('/\((.*?)\)/i', $expression, $matches);

            $match = $matches[1][0];

            $args = explode(",", $match);
            if (count($args) == 1) {
                // Only 1 arg was defined, set it to null
                $output = "<?php $args[0] = null; ?>";
            }
            else {
                $output = "<?php $args[0] = $args[1]; ?>";
            }

            return $output;
        });
    }



    /*public static function template()
    {

        Blade::extend(function ($view, $compiler) {

            echo "-----------------------------\n$view\n";
//            if (stristr($view, "@include")) {
//                return "";
//            }

            // First extract all the templates
//            $templates = [];

            $matcher = '/(?<=@deftemplate)(\s*)([a-zA-Z_0-9]+)\(([^\)]*)\)(.*)(?=@enddeftemplate)/msU';

            preg_match_all($matcher, $view, $matches);

            $view = preg_replace('/@deftemplate(?<=@deftemplate)(\s*)([a-zA-Z_0-9]+)\(([^\)]*)\)(.*)(?=@enddeftemplate)@enddeftemplate/msU', "", $view);

//            echo "Matches\n";
//            print_r($matches);

            for ($i = 0; $i < count($matches[0]); $i++) {
                RegisterDirectives::$templates = [
                    "name" => $matches[2][$i],
                    "parameters" => $matches[3][$i],
                    "text" => $matches[4][$i]
                ];
            }

//            echo "Templates\n";
//            print_r(RegisterDirectives::$templates);
            // We have all the templates now. Expand the templates

            $pattern = '/(?<=@template)(\s*)([a-zA-Z_0-9]+)\(([^\)]*)\)/U';

            preg_match_all($pattern, $view, RegisterDirectives::$occurrences);

            $replacements = [];

//            echo "Occurences\n";
//            print_r($occurrences);

            for ($i = 0; $i < count(RegisterDirectives::$occurrences[0]); $i++) {

                $found = false;

                // Find the matching template
                foreach (RegisterDirectives::$templates as $template) {
                    if ($template["name"] == RegisterDirectives::$occurrences[2][$i]) {
                        $found = true;
                        break;
                    }
                }

                if ($found) {
                    // We found a matching template. Lets prepare the expansion

                    $text = $template["text"];
                    $parameters = $template["parameters"];
                    $values = RegisterDirectives::$occurrences[3][$i];

                    $arrP = explode(",", $parameters);
                    $arrV = explode(",", $values);

                    for ($j = 0; $j < count($arrP); $j++) {
                        if (isset($arrV[$j])) {
                            $val = trim($arrV[$j]);
                            $par = trim($arrP[$j]);
                            $text = preg_replace('/<<(\s)*' . $par . '+(\s)*>>/U', "<?php echo $val; ?>", $text);
                        }
                    }

                    // $text is now the ready template, we need to replace it in the main view
                    $replacements[] = $text;

                } else {
                    $replacements[] = RegisterDirectives::$occurrences[0][$i];
                }
            }

//            echo "Replacements\n";
//            print_r($replacements);

            return preg_replace_callback($pattern, function ($matches) use ($replacements) {
                $rep = array_pop($replacements);
                return $rep;
            }, $view);
        });
    }*/

}