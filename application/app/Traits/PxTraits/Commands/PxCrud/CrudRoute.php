<?php
namespace App\Traits\PxTraits\Commands\PxCrud;
use File;
use Str;
trait CrudRoute
{
    public function MakeCrudRoute()
    {
        $d = $this->getDefaults();
        $model = $d['model'];
        $properNameSpace = $d['properNameSpace'];
        $pageUrl = $d['pageUrl'];
        $nameSpaceArray = explode("\\",$properNameSpace);
        $routePath = $nameSpaceArray[0].'\\';
        if(isset($nameSpaceArray[1])) {
            $routePath .= $nameSpaceArray[1].'\\';
        }

        $path = base_path("routes\\").strtolower($routePath)."\\";
        if (!is_dir($path)) {
            File::makeDirectory($path, 0755, true);
        }
        $filePath =  $path . Str::camel($model) . '.php';
        if (!File::exists($filePath)) {
            $content = $this->RouteAssetsString($model,$properNameSpace,$pageUrl);
            File::put($filePath, $content);
            $this->info("Route ".strtolower($model)." created");
        }
    }

    public function RouteAssetsString($model,$nameSpace,$url)
    {   
        $codeString = <<<PHP
        <?php

        use Illuminate\Support\Facades\Route;
        use App\Http\Controllers\\$nameSpace\\{$model}GetController;
        use App\Http\Controllers\\$nameSpace\\{$model}ApiController;
        use App\Http\Controllers\\$nameSpace\\{$model}PostController;
        //use
    
        //route
        Route::get('{$url}/manage', [{$model}GetController::class, 'view{$model}']);
        Route::get('{$url}/edit/{uuid}', [{$model}GetController::class, 'view{$model}']);
        Route::post('{$url}/create', [{$model}PostController::class, 'create']);
        Route::post('{$url}/list', [{$model}ApiController::class, 'list']);
        Route::post('{$url}/delete', [{$model}PostController::class, 'delete']);
        Route::post('{$url}/updateRow', [{$model}PostController::class, 'updateRow']);
        Route::post('{$url}/update', [{$model}PostController::class, 'update']);
        PHP;
        return $codeString;
    }
}
