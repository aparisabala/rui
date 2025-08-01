<?php
namespace App\Traits\PxTraits\Commands\PxLoadView;
use File;
use Str;
trait LoadViewRoute
{
    public function MakeLoadViewRoute()
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
            $content = $this->LoadViewRouteAssetsString($name,$properNameSpace,$pageUrl,$formType);
            File::put($filePath, $content);
            $this->info("Route ".Str::camel($name)." created");
        }
    }

    public function LoadViewRouteAssetsString($name,$nameSpace,$url,$formType)
    {
        $nameUp = ucfirst($name);

        $codeString = <<<PHP
        <?php

        use Illuminate\Support\Facades\Route;
        use App\Http\Controllers\\$nameSpace\\{$nameUp}GetController;
        use App\Http\Controllers\\$nameSpace\\{$nameUp}LoadController;
        //use
        
        //route
        Route::get('{$url}', [{$nameUp}GetController::class, 'view{$nameUp}']);
        Route::post('{$url}/{$name}', [{$nameUp}LoadController::class, '{$nameUp}']);
        PHP;
        return $codeString;
    }
}
