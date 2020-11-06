<?php

namespace App\Console\Commands;

use App\Generators\BladeGenerators;
use App\Generators\RouteGenerators;
use App\Generators\ControllerGenerators;
use App\Generators\RequestGenerators;
use App\Generators\VueGenerators;


/**
 * Class TestFactory
 * @package App\Console\Commands
 */
class TestFactory extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'factory:test {class} {directory?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'For testing only';

    /**
     * Create a new command instance.
     *
     * @return void
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
    public function handle()
    {
        $class = $this->argument('class');
        $directory = $this->argument('directory') ? $this->argument('directory')  : '';

        /*
        $generator = new BladeGenerators($class, $directory);
        $generator->generateBlade();

        $generator = new RouteGenerators($class, $directory);
        $generator->create();

        $generator = new RouteGenerators($class, $directory);
        $generator->createRest();

        $generator = new ControllerGenerators($class, $directory);
        $generator->create();

        $generator = new RequestGenerators($class, $directory);
        $generator->create();
        */

        $generator = new VueGenerators($class, $directory);
        $generator->create();


        //$this->setup($class, $directory);

        //$this->generateRoutes();

        /*
        $this->addVue();
        $this->registerComponent();
        $this->addRequest();


        $this->addClass();

        $this->addController();



        $this->addBlade();

        $this->addRoute();

        $this->addRequest();

        $this->addTableMigration();
        */

    }
}
