<?php
namespace App\Traits\PxTraits\Commands\PxForm;
use File;
use Str;
trait FormCreateRoute
{
    public function MakeFormRoute()
    {
        $d = $this->getDefaults();
        $model = $d['model'];
        $formType = $d['formType'];
        $name = $d['name'];
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
        $filePath =  $path . Str::camel($name) . '.php';
        if (!File::exists($filePath)) {
            $content = $this->FormRouteAssetsString($name,$properNameSpace,$pageUrl,$formType);
            File::put($filePath, $content);
            $this->info("Route ".Str::camel($name)." created");
        }
    }

    public function FormRouteAssetsString($name,$nameSpace,$url,$formType)
    {
        $formType = ($formType == "create") ? "create" : 'updateRow';
        $codeString = <<<PHP
        <?php

        use Illuminate\Support\Facades\Route;
        use App\Http\Controllers\\$nameSpace\\{$name}GetController;
        use App\Http\Controllers\\$nameSpace\\{$name}PostController;
        //use
    
        //route
        Route::get('{$url}', [{$name}GetController::class, 'view{$name}']);
        Route::post('{$url}/{$formType}', [{$name}PostController::class, '{$formType}']);
        PHP;
        return $codeString;
    }
}
