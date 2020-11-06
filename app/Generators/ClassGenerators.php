<?php


namespace App\Generators;


use App\Interfaces\GeneratorInterface;

class ClassGenerators extends BaseGenerator implements GeneratorInterface
{

    public function create()
    {
        $this->pathGenerator();

        $this->hasDirectory($this->classModelPath);

        $class = file_get_contents(resource_path("stubs/class.stub"));
        $class = $this->replaceStubs($class);

        file_put_contents($this->classModelUrl, $class);
    }

    public function generatePaths()
    {
        $this->classModelPath = app_path() . "/" . $this->directory;
        $this->classModelUrl = $this->classModelPath . $this->file . ".php";
    }

    public function replaceStubs($stub)
    {
        $classPathString = 'App';
        $namespace = $this->rawDirectory ? $classPathString . "\\". ucfirst($this->rawDirectory) : $classPathString;

        $stub = str_replace('%CLASS%', $this->file, $stub );
        $stub = str_replace('%NAMESPACE%', $namespace, $stub);
        return $stub;
    }
}
