<?php

namespace App\Console\Commands;


/**
 * NOTES: This factory is specifically for creating views. This adds the route, registers the vue component,
 *        creates all of the controllers and classes, and a blade element.
 */

/**
 * Class ViewFactory
 * @package App\Console\Commands
 */
class ViewFactory extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'factory:vue {vue} {directory=""}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a vue module and boiler plate. Does not include a migration';

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
        $this->setup($this->argument('vue'), $this->argument('directory'));

        $this->addVueComponent();

        $this->addRoute();

        $this->registerComponent();

        $this->addController();

        $this->addClass();

        $this->addBlade();

    }
}
