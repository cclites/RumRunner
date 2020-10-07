<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Str;

/**
 * NOTES: This factory is used to create a report-oriented flow. Adds a blade, vue, registers all components.
 */

/**
 * Class ReportFactory
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
        $class = $this->argument('class');
        $directory = $this->argument('directory') ? $this->argument('directory')  : '';

        $this->setup($class, $directory);

//        $this->addClass();

        $this->addController();

//        $this->addVue();
//
//        $this->addBlade();
//
//        $this->addRoute();
//
//        $this->addRequest();
//
//        $this->addTableMigration();

    }
}
