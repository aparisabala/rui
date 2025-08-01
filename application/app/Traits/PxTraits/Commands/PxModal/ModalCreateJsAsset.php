<?php
namespace App\Traits\PxTraits\Commands\PxModal;
use File;
use Str;
trait ModalCreateJsAsset
{
    public function MakeModalJsAsset()
    {
        $d = $this->getDefaults();
        $properNameSpace = $d['properNameSpace'];
        $name = $d['name'];
        $path = base_path("..\\public_html\\app_assets\\js\\application\\" .strtolower(explode("\\",$properNameSpace)[0])."\\". strtolower(explode("\\",$properNameSpace)[1]) . "\\calls\\");
        if (!is_dir($path)) {
            File::makeDirectory($path, 0755, true);
        }
        $jsFilePath =  $path . 'modal'.ucfirst($name) . '.js';
        if (!File::exists($jsFilePath)) {
            $content = $this->ModalJsAssetsString($name);
            File::put($jsFilePath, $content);
            $this->info("Asset " . 'modal'.ucfirst($name) . ".js created ");
        }
    }

    public function ModalJsAssetsString($name)
    {   
        $codeString = <<<PHP
        \$(document).ready(function () {
        });
        function {$name}(op) {

            console.log(op)
        }
        PHP;
        return $codeString;
    }
}