<?php
namespace App\Traits\PxTraits\Commands\PxLoadView;
use File;
use Str;
trait LoadViewJsAsset
{
    public function MakeLoadViewJsAsset()
    {
        $d = $this->getDefaults();
        $properNameSpace = $d['properNameSpace'];
        $model = $d['model'];
        $name = $d['name'];
        $pageUrl = $d['pageUrl'];
        $path = base_path("..\\public_html\\app_assets\\js\\application\\" .strtolower(explode("\\",$properNameSpace)[0])."\\". strtolower(explode("\\",$properNameSpace)[1]) . "\\calls\\");
        if (!is_dir($path)) {
            File::makeDirectory($path, 0755, true);
        }
        $jsFilePath =  $path . Str::camel($name) . '.js';
        if (!File::exists($jsFilePath)) {
            $content = $this->LoadViewJsAssetsString($name,$pageUrl);
            File::put($jsFilePath, $content);
            $this->info("Asset " . Str::camel($name) . ".js created ");
        }
    }

    public function LoadViewJsAssetsString($name,$url)
    {   
        $nameUp = ucfirst($name);

        $codeString = <<<PHP
        \$(document).ready(function () {

            if ($("#frm{$nameUp}").length > 0) {
                let rules = {
                    name: {
                        required: true
                    }
                };
                ajaxRequest({
                    element: "frm{$nameUp}",
                    validation: true,
                    script: "{$url}/{$name}",
                    rules,
                    afterSuccess: {
                        type: "load_html",
                        target: "{$nameUp}InterFace",
                        reload: true,
                        afterLoad: () => {}
                    },
                });
            }
        });
        PHP;
        return $codeString;
    }
}
