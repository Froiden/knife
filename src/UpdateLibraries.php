<?php

namespace Froiden\Knife;


use Illuminate\Console\Command;

class UpdateLibraries extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'knife:update';

    const UPDATE_PATH = "http://localhost/index.json";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update libraries list for blade "require" extension.';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->info('Downloading latest libraries list...');

        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, self::UPDATE_PATH);

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);

        file_put_contents(__DIR__."/index.json", $output);

        // close curl resource to free up system resources
        curl_close($ch);
    }
}