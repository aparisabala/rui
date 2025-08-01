<?php
namespace App\Traits\PxTraits\Commands\PxModal;
use File;
use Str;
trait ModalCreateRoute
{
    public function MakeModalRoute()
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
        $filePath =  $path .'modal'.ucfirst($name) . '.php';
        if (!File::exists($filePath)) {
            $content = $this->ModalRouteAssetsString($name,$properNameSpace,$pageUrl,$formType);
            File::put($filePath, $content);
            $this->info("Route ".'modal'.ucfirst($name)." created");
        }
    }

    public function ModalRouteAssetsString($name,$nameSpace,$url,$formType)
    {
        $nameUp = ucFirst($name);

        $codeString = <<<PHP
        <?php

        use Illuminate\Support\Facades\Route;
        use App\Http\Controllers\\$nameSpace\\{$nameUp}LoadController;
        //use
    
        //route
        Route::post('{$url}/{$name}', [{$nameUp}LoadController::class, '{$nameUp}']);
        PHP;
        return $codeString;
    }
}
