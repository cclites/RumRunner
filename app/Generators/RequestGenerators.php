<?php


namespace App\Generators;


use App\Interfaces\GeneratorInterface;
use Illuminate\Support\Facades\Artisan;

class RequestGenerators extends BaseGenerator implements GeneratorInterface
{
    /** UPDATED  11/05/2020       */
    /**
     * Add a request object
     */
    public function create() : void
    {
        $file = $this->directory ? $this->directory . $this->file : $this->file;

        Artisan::call("make:request {$file}Request");
        Artisan::call("make:request {$file}UpdateRequest");
    }

    public function generatePaths()
    {
        // TODO: Implement generatePaths() method.
    }

    public function replaceStubs($stub)
    {
        // TODO: Implement replaceStubs() method.
    }
}
