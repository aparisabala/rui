<?php
namespace App\Traits\PxTraits\Commands\PxForm;
use File;
use Str;
trait FormCreateJsAsset
{
    public function MakeFromJsAsset()
    {   
        $d = $this->getDefaults();
        $properNameSpace = $d['properNameSpace'];
        $model = $d['model'];
        $name = $d['name'];
        $formType = $d['formType'];
        $pageUrl = $d['pageUrl'];
        $path = base_path("..\\public_html\\app_assets\\js\\application\\" .strtolower(explode("\\",$properNameSpace)[0])."\\". strtolower(explode("\\",$properNameSpace)[1]) . "\\calls\\");
        if (!is_dir($path)) {
            File::makeDirectory($path, 0755, true);
        }
        $jsFilePath =  $path . Str::camel($name) . '.js';
        if (!File::exists($jsFilePath)) {
            $content = $this->FormJsAssetsString($name,$pageUrl,$formType);
            File::put($jsFilePath, $content);
            $this->info("Asset " . Str::camel($name) . ".js created ");
        }
    }

    public function FormJsAssetsString($name,$url,$formType)
    {   
        $formType = ($formType == "create") ? "create" : 'updateRow';

        $codeString = <<<PHP
        \$(document).ready(function () {
            {{-- call --}}
        });
        PHP;
        if($formType == "create") {
            $contentArray = explode("{{-- call --}}",$codeString);
            $codeString =<<<PHP
            $contentArray[0]
                if (\$("#frm$name").length > 0) {
                    let rules = {
                        name: {
                            required: true,
                            maxlength: 253
                        }
                    };
                    ajaxRequest({
                        element: "frm$name",
                        validation: true,
                        script: "{$url}/{$formType}",
                        rules,
                        afterSuccess: {
                            type: "inflate_reset_response_data"
                        },
                    });

                }
            $contentArray[1]
            PHP;
        }

        if($formType == "updateRow") {
            $contentArray = explode("{{-- call --}}",$codeString);
            $codeString =<<<PHP
            $contentArray[0]
                if (\$("#frm$name").length > 0) {
                    let rules = {
                        name: {
                            required: true,
                            maxlength: 253
                        }
                    };
                    ajaxRequest({
                        element: "frm$name",
                        validation: true,
                        script: "{$url}/{$formType}",
                        rules,
                        afterSuccess: {
                            type: "inflate_response_data"
                        }
                    });

                }
            $contentArray[1]
            PHP;
        }
        return $codeString;
    }
}
