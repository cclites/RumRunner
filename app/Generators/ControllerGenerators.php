<?php


namespace App\Generators;


use App\Interfaces\GeneratorInterface;

class ControllerGenerators extends BaseGenerator implements GeneratorInterface
{
    public $controllerPath;
    public $controllerUrl;

    public function create(){

        $this->generatePaths();

        $this->hasDirectory($this->controllerPath);

        $controller = file_get_contents(resource_path('stubs/controller.stub'));
        $controller = $this->replaceStubs($controller);

        file_put_contents($this->controllerUrl, $controller) . "\n";
    }

    public function generatePaths() : void
    {
        $this->controllerPath = app_path() . "/Http/Controllers/" . $this->directory ."/";
        $this->controllerUrl = $this->controllerPath . $this->file . "Controller.php";
    }

    /**
     * @param $stub
     * @return String
     */
    public function replaceStubs($stub) : String
    {
        $controllerPathString = 'App\Http\Controllers';
        $namespace = $this->rawDirectory ? $controllerPathString . "\\". ucfirst($this->directory) : $controllerPathString;
        $vue = $this->directory ? strtolower($this->rawDirectory) . "." . strtolower($this->rawFile) : strtolower($this->rawFile);

        $import = $this->directory ? "use App\\" . $this->rawDirectory . ";" : '';

        $stub = str_replace('%CLASS%', $this->file, $stub );
        $stub = str_replace('%NAMESPACE%', $namespace, $stub);
        $stub = str_replace('%IMPORT%', $import, $stub);
        $stub = str_replace('%class%', strtolower($this->file), $stub);
        $stub = str_replace('%VUE%', $vue, $stub );

        $title = preg_replace('/(?!^)[A-Z]{2,}(?=[A-Z][a-z])|[A-Z][a-z]/', ' $0', $this->file);
        $stub = str_replace('%TITLE%', $title, $stub);

        return $stub;
    }
}
