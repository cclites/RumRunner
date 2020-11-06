<?php


namespace App\Generators;

use App\Interfaces\GeneratorInterface;
use Illuminate\Support\Str;

class BladeGenerators extends BaseGenerator implements GeneratorInterface
{
    private $bladePath;
    private $bladeUrl;

    /** UPDATED 11/05/2020         */
    /**
     * Add a blade file
     */
    public function create(){

        $this->generatePaths();

        $this->hasDirectory($this->bladePath);

        $blade = file_get_contents(resource_path("stubs/blade.stub"));
        $blade = $this->replaceStubs($blade);
        file_put_contents($this->bladeUrl, $blade);
    }

    /**
     * generate path & uri for blade templates
     */
    public function generatePaths() : void
    {
        if($this->directory){
            $this->bladePath = resource_path('views/') . strtolower($this->rawDirectory) . "/";
        }else{
            $this->bladePath = resource_path('views/');
        }

        $this->bladeUrl = $this->bladePath . Str::snake($this->file) . ".blade.php";
    }

    /**
     * @param $stub
     * @return String
     */
    public function replaceStubs($stub) : String
    {
        $vue = $this->directory ? strtolower($this->rawDirectory) . "-" . Str::kebab($this->rawFile) : Str::kebab($this->rawFile);
        return str_replace('%vue%', $vue, $stub );
    }

}
