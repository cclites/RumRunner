<?php

namespace App\Console\Commands;

class ModelViewFactory extends BaseCommand
{
    /**
     * This command would be suitable for creating a list view
     */

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'factory:model-view {class} {directory};';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Model View Factory';

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
        $this->setup($this->argument('class'), $this->argument('directory'));

        //$this->addClass();
        //$this->createTableMigration();
        //$this->addVueComponent();
        $this->registerComponent();
        //$this->addRequest();
        //$this->addRequest(true);
        //$this->generateRoutes();
        //$this->generateSingleResponsibilityRoutes();
        $this->addBlade();

    }
}
