<?php

namespace App\Console\Commands;

/**
 * NOTES: This factory is used to create a model representing a business object (such as a report or invoice).
 *        This factory differs from the model factory in that it will create a view, register the view component,
 *        and create a migration. Will also populate namespaces and imports.
 */

/**
 * Class ClassFactory
 * @package App\Console\Commands
 */
class ClassFactory extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'factory:class {class} {directory?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate boilerplate for a class. Creates a migration.';

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
        $directory = $this->argument('directory') ? $this->argument('directory') : null;

        $this->setup($this->argument('class'), $directory);

        $this->addClass();

        $this->addController();

        $this->addVueComponent();

        $this->addRoute();

        $this->registerComponent();

        $this->makeMigration();


    }
}
