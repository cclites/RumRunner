<?php


namespace App\Generators;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

use App\Generators\BladeGenerators;
use App\Generators\ClassGenerators;
use App\Generators\ControllerGenerators;
use App\Generators\ModelGenerators;
use App\Generators\RouteGenerators;
use App\Generators\RequestGenerators;
use App\Generators\VueGenerators;


class BaseGenerator
{
    public $directory;
    public $rawDirectory;

    public $file;
    public $rawFile;



    public function __construct(string $file, string $directory = '')
    {
        $this->rawFile = Str::kebab($file);
        $this->file = ucfirst($file);
        $this->rawDirectory = $directory; //save an unformatted version of directory
        $this->directory = $directory;
    }

    public function generateBlade()
    {
        $generator = new BladeGenerators($this->file, $this->directory);
        $generator->create();
    }

    public function generateRoute(){
        $generator = new RouteGenerators($this->file, $this->directory);
        $generator->create();
    }

    public function generateRestRoute(){
        $generator = new RouteGenerators($this->file, $this->directory);
        $generator->createRest();
    }

    public function generateControllers()
    {
        $generate = new ControllerGenerators($this->file, $this->directory);
        $generate->create();
    }

    public function requestControllers()
    {
        $generate = new RequestGenerators($this->file, $this->directory);
        $generate->create();
    }

    /***
     * Utilities
     */

    /**
     * @param $path
     * @return bool
     */
    public function hasDirectory($path){

        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
            return true;
        }

        return false;
    }
}
