<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpParser\Node\Scalar\String_;


/**
 * Class BaseCommand
 * @package App\Console\Commands
 */
class BaseCommand extends Command
{
    /** @var string */
    public $fileName;

    /** @var string */
    public $file;

    /** @var string */
    //public $classPath;

    /** @var string */
    //public $vuePath;

    /** @var string */
    //public $bladePath;

    /** @var string */
    //public $controllerPath;

    /** @var string */
    public $classModelPath;
    public $classModelUrl;

    public $controllerPath;
    public $controllerUrl;

    public $vuePath;
    public $vueUrl;

    public $bladePath;
    public $bladeUrl;

    /** @var string */
    public $bladePathUrl;

    /** @var string */
    public $controllerPathUrl;

    /** @var string */
    public $classFileName;

    /** @var string */
    public $vueFileName;

    /** @var string */
    public $bladeFileName;

    /** @var string */
    public $controllerFileName;

    /** @var string */
    public $directory;
    public $rawDirectory;

    public $paths = [];

    /** Paths */
    const VUE_PATH = 'js/components'; //storage_path
    const VIEW_PATH = 'views';  //storage_path
    const CONTROLLER_PATH = 'Http/Controllers'; //app_path
    const MIGRATION_PATH = 'database/migrations';
    //const PLURAL = ;

    /** Used as placeholder in app.js */
    public $placeholder = "//------- CONTENT -------//";

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'do-not-run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /** UPDATED 10/06/2020         */
    /**
     * Add a blade
     */
    public function addBlade(){

        $this->bladePathGenerator();

        $this->hasDirectory($this->bladePath);

        $blade = file_get_contents(resource_path("stubs/blade.stub"));
        $blade = $this->replaceBladeStubs($blade);

        file_put_contents($this->bladeUrl, $blade);
    }

    /** UPDATED  10/01/2020       */
    /**
     * Add a class file
     */
    public function addClass() : void
    {
        $this->classPathGenerator();

        $this->hasDirectory($this->classModelPath);

        $class = file_get_contents(resource_path("stubs/class.stub"));
        $class = $this->replaceClassStubs($class);

        file_put_contents($this->classModelUrl, $class);
    }

    /** UPDATED  10/01/2020        */
    /**
     * Add a controller in the appropriate directory
     */
    public function addController(){

        $this->controllerPathGenerator();

        echo "Generated paths\n";
        dump($this->controllerPath);
        dump($this->controllerUrl);

        $this->hasDirectory($this->controllerPath);

        $controller = file_get_contents(resource_path('stubs/controller.stub'));
        $controller = $this->replaceControllerStubs($controller);

        dump($controller);

        echo file_put_contents($this->controllerUrl, $controller) . "\n";
    }

    /** UPDATED  10/29/2020       */
    /**
     * Add a request object
     * @param bool $update
     */
    public function addRequest($update = false)
    {
        $file = $this->directory ? $this->directory . $this->file : $this->file;

        Artisan::call("make:request {$file}Request");
        Artisan::call("make:request {$file}UpdateRequest");
    }


    /** UPDATED  10/06/2020          */
    /**
     * Add a migration to create a table
     */
    public function addTableMigration() : void
    {
        $timestamp = Carbon::now()->format('Y_m_d_h_') . 'create_table_';
        $fileName = $timestamp . Str::plural(strtolower($this->file)) .".php";

        $migration = file_get_contents(resource_path("stubs/migration.stub"));

        $migration = $this->replaceMigrationStubs($migration);

        $filePath = self::MIGRATION_PATH . "/" . $fileName;

        file_put_contents($filePath, $migration);
    }

    /** UPDATED  10/06/2020        */
    /**
     * Generates a list vue component with table and pagination,
     * or a vue for a single component
     *
     * @param bool $useListView
     */
    public function addVue($useListView = false) : void
    {
        $this->vuePathGenerator();

        $this->hasDirectory($this->vuePath);

        if($useListView){
            $vue = file_get_contents(resource_path('stubs/model_list_vue.stub'));
        }else{
            $vue = file_get_contents(resource_path('stubs/vue.stub'));
        }

        $vue = $this->replaceVueStubs($vue);

        file_put_contents($this->vueUrl, $vue);

        $this->registerComponent();
    }

    /**
     * generate path & uri for blade templates
     */
    public function bladePathGenerator() : void
    {
        $this->bladePath = resource_path('views/') . strtolower($this->directory);
        $this->bladeUrl = $this->bladePath . Str::snake($this->file) . ".blade.php";
    }

    /**
     * generate path & uri for models
     */
    public function classPathGenerator() : void
    {
        $this->classModelPath = app_path() . "/" . $this->directory;
        $this->classModelUrl = $this->classModelPath . $this->file . ".php";
    }

    /**
     * generate path & uri for controllers
     */
    public function controllerPathGenerator() : void
    {
        $this->controllerPath = app_path() . "/Http/Controllers/" . $this->directory;
        $this->controllerUrl = $this->controllerPath . $this->file . "Controller.php";
    }



    /**
     * Generate the file name, upper case for components,
     * and lower case for vue and blade files
     *
     * @param bool $upperCase
     * @return string
     */
    public function generateFileName(bool $upperCase = false) : String
    {
        die("Using generateFileName\n");

        $fileName = $this->file;

        if($this->directory !== ""){
            $fileName .= $upperCase ? ucfirst($this->directory) : strtolower($this->directory);
        }

        return $fileName;
    }

    /**
     * Generate path to url, upper case for classes,
     * and lower case for vue and blade files
     *
     * @param String $path
     * @param bool|null $upperCase
     * @param String|null $plural
     * @return string
     */
    public function generatePath(String $path, ?bool $upperCase = false, ?String $plural = null) : String
    {
        die("Using generatePath\n");

        if($this->directory){
            $path .= $upperCase ? ( "/" . ucfirst($this->directory)) : ( "/" . strtolower($this->file));
        }

        return $path;
    }

    /** UPDATED  11/02/2020          */
    /**
     * Add route for a single controller
     *
     * @param string $method
     * @param string $action
     */
    public function addRoute($method = 'get', $action = 'index') : void
    {
        $relativePath = $this->directory ? Str::plural(ucfirst($this->rawDirectory)) . "/" . $this->file  : $this->file;
        $relativePath = strtolower($relativePath);
        $namedRoute = $this->directory ? Str::plural(strtolower($this->rawDirectory)) . "." . Str::snake($this->file) : Str::snake($this->file);

        $contents = file_get_contents(base_path('routes/web.php'));
        $contents .= "Route::{$method}('{$relativePath}','{$this->file}Controller@{$action}')->name('{$namedRoute}_{$action}');\n";
        file_put_contents(base_path('routes/web.php'), $contents);
    }


    /** UPDATED  11/02/2020          */
    /**
     * Generate single controller routes
     */
    public function generateRoutes()
    {

        $relativePath = $this->directory ? Str::plural(ucfirst($this->rawDirectory)) . "/" . $this->file  : $this->file;
        $lcRelativePath = strtolower($relativePath);
        $namedRoute = $this->directory ? Str::plural(strtolower($this->rawDirectory)) . "." . Str::snake($this->file) : Str::snake($this->file);

        $contents = file_get_contents(base_path('routes/web.php')) . "\n";

        $contents .= "Route::get('{$lcRelativePath}', '{$this->file}Controller@index')->name('{$namedRoute}_index');\n";
        $contents .= "Route::get('{$lcRelativePath}/{" . strtolower($this->file) . "}', '{$relativePath}Controller@show')->name('{$namedRoute}_show');\n";
        $contents .= "Route::put('{$lcRelativePath}/', '{$relativePath}Controller@put')->name('{$namedRoute}_put');\n";
        $contents .= "Route::patch('{$lcRelativePath}/{" . strtolower($this->file) . "}', '{$relativePath}Controller@patch')->name('{$namedRoute}_patch');\n";
        $contents .= "Route::delete('{$lcRelativePath}/{" . strtolower($this->file) . "}', '{$relativePath}Controller@delete')->name('{$namedRoute}_delete');\n";

        file_put_contents(base_path('routes/web.php'), $contents);
    }

    public function generateResourceRoutes(){
        return;

        $contents = file_get_contents(base_path('routes/web.php'));

        file_put_contents(base_path('routes/web.php'), $contents);
    }

    /** UPDATED  5/30/2020          */
    /**
     * Generate single use controllers
     */
    public function generateSingleResponsibilityControllers(){

        $pathUrl = $this->controllerPath;
        $controllerFileName = $this->file . "Controller.php";
        $fullPathToFile = $pathUrl . "/" . $controllerFileName;

        $index = file_get_contents(resource_path('stubs/index_controller.stub'));
        $index = $this->replacePlaceholders($index);
        file_put_contents("{$fullPathToFile}Controller.php", $index);

        $show = file_get_contents(resource_path('stubs/show_controller.stub'));
        $show = $this->replacePlaceholders($show);
        file_put_contents("{$fullPathToFile}ShowController.php", $show);

        $add = file_get_contents(resource_path('stubs/create_controller.stub'));
        $add = $this->replacePlaceholders($add);
        file_put_contents("{$fullPathToFile}AddController.php", $add);

        $update = file_get_contents(resource_path('stubs/update_controller.stub'));
        $update = $this->replacePlaceholders($update);
        file_put_contents("{$fullPathToFile}UpdateController.php", $update);

        $destroy = file_get_contents(resource_path('stubs/delete_controller.stub'));
        $destroy = $this->replacePlaceholders($destroy);
        file_put_contents("{$fullPathToFile}DestroyController.php", $destroy);
    }

    /** UPDATED  5/30/2020          */
    /**
     * Generate single responsibility routes
     */
    public function generateSingleResponsibilityRoutes(){

        $route = Str::kebab($this->file);
        $routeName = Str::snake($this->vueFileName);
        $controllerFileName = ucfirst($this->controllerFileName);

        if($this->directory !== ""){
            $route = Str::kebab($this->file . $this->directory);
            $controllerFileName = Str::plural(ucfirst($this->directory)) . "/" . ucfirst($this->file);
            $routeName = Str::plural(strtolower($this->directory)) . "." . $routeName;
        }

        $path = base_path('routes/web.php');

        $contents = file_get_contents($path);
        $contents .= "/** {$this->fileName}   **/\n";
        $contents .= "Route::get('{$route}s-show', '{$controllerFileName}Controller@index')->name('{$routeName}_show');\n";
        $contents .= "Route::post('{$route}s-create', '{$controllerFileName}ShowController@create')->name('{$routeName}_create');\n";
        $contents .= "Route::patch('{$route}s-update', '{$controllerFileName}UpdateController@update')->name('{$routeName}_update');\n";
        $contents .= "Route::delete('{$route}s-delete', '{$controllerFileName}AddController@delete')->name('{$routeName}_delete');\n";

        file_put_contents($path, $contents);
    }

    /**
     * Determine if a directory exists. If not, create it.
     *
     * @param $path
     */
    public function hasDirectory($path){

        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }
    }

    /**
     * Write paths to routes when installing list view components
     */
    public function installUtilities(){
        //Vue.component('pagination', require('./components/utilities/Pagination.vue').default);
        //Vue.component('record-count', require('./components/utilities/RecordCount.vue').default);
    }

    /** UPDATED 10/06/2020         */
    /**
     * Register a vue component in app.js
     */
    public function registerComponent() : void
    {
        $vue = $this->directory ? Str::kebab($this->rawDirectory) . "/" . Str::kebab($this->file) : Str::kebab($this->file);
        $appJsRaw = file_get_contents(resource_path('js/app.js'));

        $dataToInsert = 'Vue.component("' . Str::kebab($vue) . '", require("./components/' . Str::kebab($this->file) . '.vue").default);' . "\n";
        $dataToInsert .= $this->placeholder . "\n";

        $appJsRaw = str_replace($this->placeholder, $dataToInsert, $appJsRaw );

        file_put_contents(resource_path('js/app.js'), $appJsRaw);
    }

    /**
     * @param $stub
     * @return String
     */
    public function replaceBladeStubs($stub) : String
    {
        $vue = Str::kebab($this->file);

        return str_replace('%vue%', $vue, $stub );
    }

    /**
     * @param $stub
     * @return String
     */
    public function replaceClassStubs($stub) : String
    {
        $classPathString = 'App';
        $namespace = $this->rawDirectory ? $classPathString . "\\". ucfirst($this->rawDirectory) : $classPathString;

        $stub = str_replace('%CLASS%', $this->file, $stub );
        $stub = str_replace('%NAMESPACE%', $namespace, $stub);
        return $stub;
    }

    /**
     * @param $stub
     * @return String
     */
    public function replaceControllerStubs($stub) : String
    {
        $controllerPathString = 'App\Http\Controllers';
        $namespace = $this->rawDirectory ? $controllerPathString . "\\". ucfirst($this->rawDirectory) : $controllerPathString;
        $vue = $this->directory ? strtolower($this->rawDirectory) . "." . strtolower($this->file) : strtolower($this->file);

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

    /**
     * @param $stub
     * @return String
     */
    public function replaceMigrationStubs($stub) : String
    {
        $vue = Str::snake($this->file);
        $stub = str_replace('%CLASS%', $this->file, $stub );
        return str_replace('%vue%', $vue, $stub );
    }

    /**
     * Replace placeholders in stubs
     *
     * @param $stub
     * @return string|string[]
     */
    public function replacePlaceholders($stub){

        die("In replacePlaceholders\n");

        $vueFileName = $this->file;
        $classFileName = $this->file;
        $vue = Str::kebab($vueFileName);

        if(!$this->directory){
            $vue .= "-vue";
        }

        $namespace = $this->directory ? 'App\\Http\\Controllers\\' . ucfirst($this->rawDirectory): 'App\\Http\\Controllers';


        $import = $this->directory ? "use App\\" . $this->rawDirectory . ";" : '';

        $stub = str_replace('%CLASS%', $classFileName, $stub );
        $stub = str_replace('%VUE%', Str::kebab($vueFileName), $stub );
        $stub = str_replace('%NAMESPACE%', $namespace, $stub);
        $stub = str_replace('%IMPORT%', $import, $stub);
        $stub = str_replace('%class%', strtolower($vueFileName), $stub);
        $stub = str_replace('%vue%', strtolower($this->file), $stub );

        $title = preg_replace('/(?!^)[A-Z]{2,}(?=[A-Z][a-z])|[A-Z][a-z]/', ' $0', $classFileName);

        $stub = str_replace('%TITLE%', $title, $stub);
        $stub = str_replace('%COMPONENT%', Str::snake($classFileName), $stub);

        return $stub;

    }

    public function replaceVueStubs($stub) : String
    {
        $vue = $this->directory ? strtolower($this->rawDirectory) . "." . strtolower($this->file) : strtolower($this->file);
        $stub = str_replace('%CLASS%', $this->file, $stub );
        $stub = str_replace('%class%', strtolower($this->file), $stub);
        return str_replace('%VUE%', $vue, $stub );
    }

    /**
     * Sets global fields
     */
    public function setPaths()
    {
        //$this->vuePathGenerator();
        //$this->bladePathGenerator();
        //$this->classPathGenerator();
        //$this->controllerPathGenerator();
    }

    /**
     * @param $file
     * @param $directory
     */
    public function setup($file, $directory) : void
    {

        $this->file = ucfirst($file);
        $this->rawDirectory = $directory; //save an unformatted version of directory
        $this->directory = $directory ? ucfirst($directory) . "/" : '';
    }


    public function toString(){

        echo "\n\n*****************************************\n";
        echo "FULL CLASS PATH: $this->classPath\n";
        echo "FULL CONTROLLER PATH: $this->controllerPath\n";
        echo "FULL VIEW PATH: $this->bladePath\n";
        echo "FULL VUE PATH: $this->vuePath\n";

        echo "\n\nCLASS URL: $this->classPathUrl\n";
        echo "CONTROLLER URL: $this->controllerPathUrl\n";
        echo "VIEW URL: $this->bladePathUrl\n";
        echo "VUE URL: $this->vuePathUrl\n";

        echo "\n\nCLASS FILE NAME: $this->classFileName\n";
        echo "CONTROLLER FILE NAME: $this->controllerFileName\n";
        echo "VIEW FILE NAME: $this->bladeFileName\n";
        echo "VUE FILE NAME: $this->vueFileName\n";
    }

    /**
     * generate path & uri for vue component
     */
    public function vuePathGenerator() : void
    {
        $this->vuePath = resource_path("js/components/") . strtolower($this->directory);
        $this->vueUrl = $this->vuePath . $this->file . ".vue";
    }

    public function writeOutGeneratedStub($path, $data){

    }


}

