<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

/**
 * NOTES: This factory is used to create a report-oriented flow. Adds a blade, vue, registers all components.
 */

/**
 * Class ReportFactory
 * @package App\Console\Commands
 */
class ReportFactory extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'factory:report {report} {directory=""}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate boilerplate for a report';

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

        $this->registerComponent();

        $this->addRoute();
        /******************************

        $this->addClass();

        $this->addController();

        $this->addRequest();

        $this->addRoute();

        $this->addBlade();

        //$this->addVueComponent();

        $this->registerComponent();
         * */

        /****************************************************************/
    }
}
