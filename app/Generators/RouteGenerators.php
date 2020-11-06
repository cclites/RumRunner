<?php


namespace App\Generators;


use App\Interfaces\GeneratorInterface;
use Illuminate\Support\Str;

class RouteGenerators extends BaseGenerator implements GeneratorInterface
{
    public function create($method = 'get', $action = 'index')
    {

        $relativePath = $this->directory ? Str::camel($this->rawDirectory) . "/" . Str::snake($this->file)  : Str::snake($this->file);
        $namedRoute = $this->directory ? Str::plural(strtolower($this->rawDirectory)) . "." . Str::snake($this->file) : Str::snake($this->file);

        $contents = file_get_contents(base_path('routes/web.php'));
        $contents .= "\nRoute::{$method}('{$relativePath}','{$this->directory}/{$this->file}Controller@{$action}')->name('" . Str::snake($namedRoute) . "_{$action}');\n";
        file_put_contents(base_path('routes/web.php'), $contents);
    }

    public function createRest(){

        $relativePath = $this->directory ? Str::camel($this->rawDirectory) . "/" . Str::snake($this->file)  : Str::snake($this->file);
        $namedRoute = $this->directory ? Str::plural(strtolower($this->rawDirectory)) . "." . Str::snake($this->file) : Str::snake($this->file);

        $contents = file_get_contents(base_path('routes/web.php'));

        $contents .= "\nRoute::get('{$relativePath}','{$this->directory}/{$this->file}Controller@index')->name('" . Str::snake($namedRoute) . "_index');\n";
        $contents .= "Route::get('{$relativePath}/{id}','{$this->directory}/{$this->file}Controller@show')->name('" . Str::snake($namedRoute) . "_show');\n";
        $contents .= "Route::post('{$relativePath}','{$this->directory}/{$this->file}Controller@create')->name('" . Str::snake($namedRoute) . "_create');\n";
        $contents .= "Route::patch('{$relativePath}/{id}','{$this->directory}/{$this->file}Controller@update')->name('" . Str::snake($namedRoute) . "_update');\n";
        $contents .= "Route::delete('{$relativePath}/{id}','{$this->directory}/{$this->file}Controller@delete')->name('" . Str::snake($namedRoute) . "_delete');\n";


        file_put_contents(base_path('routes/web.php'), $contents);

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
