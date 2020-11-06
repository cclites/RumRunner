<?php


namespace App\Generators;


use App\Interfaces\GeneratorInterface;
use Illuminate\Support\Str;

class VueGenerators extends BaseGenerator implements GeneratorInterface
{
    private $vueUrl;
    private $vuePath;

    /** Used as placeholder in app.js */
    public $placeholder = "//------- RR AUTO-GENERATED CONTENT -------//";

    public function create()
    {
        $this->generatePaths();
        $this->hasDirectory($this->vuePath);

        $vue = file_get_contents(resource_path('stubs/vue.stub'));
        $vue = $this->replaceStubs($vue);

        file_put_contents($this->vueUrl, $vue);
    }

    /**
     * Generate paths
     */
    public function generatePaths()
    {
        if($this->directory){
            $this->vuePath = resource_path('js/components/') . Str::plural(strtolower($this->rawDirectory)) . "/";
        }else{
            $this->vuePath = resource_path('js/components/');
        }

        $this->vueUrl = $this->vuePath . Str::snake($this->file) . ".vue";

        $this->registerComponent();
    }

    /**
     * Replace stubs in vue template
     *
     * @param $stub
     * @return string|string[]
     */
    public function replaceStubs($stub)
    {
        $vue = $this->directory ? strtolower($this->rawDirectory) . "." . strtolower($this->file) : strtolower($this->file);
        $stub = str_replace('%CLASS%', $this->file, $stub );
        $stub = str_replace('%class%', strtolower($this->file), $stub);
        $stub = str_replace('%VUE%', $vue, $stub );

        return $stub;
    }

    /**
     * Register a vue component in app.js
     */
    public function registerComponent() : void
    {
        $vue = $this->directory ? Str::plural(Str::kebab($this->rawDirectory)) . "/" . Str::kebab($this->file) : Str::kebab($this->file);
        $appJsRaw = file_get_contents(resource_path('js/app.js'));

        $dataToInsert = 'Vue.component("' . Str::kebab($vue) . '", require("./components/' . $vue . '.vue").default);' . "\n";
        $dataToInsert .= "\n" . $this->placeholder . "\n";

        $appJsRaw = str_replace($this->placeholder, $dataToInsert, $appJsRaw );

        file_put_contents(resource_path('js/app.js'), $appJsRaw);
    }
}
