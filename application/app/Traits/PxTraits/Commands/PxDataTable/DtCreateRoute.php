<?php
namespace App\Traits\PxTraits\Commands\PxDataTable;
use File;
use Str;
trait DtCreateRoute
{
    public function MakeDtRoute()
    {
        $d = $this->getDefaults();
        $model = $d['model'];
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
        $filePath =  $path . 'dt'.ucfirst($name) . '.php';
        if (!File::exists($filePath)) {
            $content = $this->DtRouteAssetsString($name,$properNameSpace,$pageUrl);
            File::put($filePath, $content);
            $this->info("Route ". 'dt'.ucfirst($name) ." created");
        }
    }

    public function DtRouteAssetsString($name,$nameSpace,$url)
    {
        $codeString = <<<PHP
        <?php

        use Illuminate\Support\Facades\Route;
        use App\Http\Controllers\\$nameSpace\\{$name}GetController;
        use App\Http\Controllers\\$nameSpace\\{$name}ApiController;
        //use
    
        //route
        Route::get('{$url}/list', [{$name}GetController::class, 'view{$name}']);
        Route::post('{$url}/list', [{$name}ApiController::class, 'list']);
        PHP;
        return $codeString;
    }
}
