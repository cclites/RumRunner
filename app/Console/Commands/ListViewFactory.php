<?php

namespace App\Console\Commands;

class ListViewFactory extends BaseCommand
{
    /**
     * This command would be suitable for creating a list view
     */


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'factory:list-view {class} {directory};';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List View Factory';

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

        $this->addVueComponent(true);
        $this->registerComponent(true);
        $this->addRoute(true);
        $this->addController();
        $this->addRequest();
    }
}
