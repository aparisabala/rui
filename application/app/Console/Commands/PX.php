<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class PX extends Command
{

    protected $signature = 'px:make {type} {nameSpace} {--name=} {--model=} {--pageNav=} {--formType=}';
    protected $description = 'Command description';

    public function handle()
    {
        $name = $this->option('name') ?? "";
        $model = $this->option('model') ?? "";
        $formType = $this->option('formType') ?? "";
        $type = $this->argument('type');
        $nameSpace = $this->argument('nameSpace') ?? "";
        $nameSpaceCount = count(explode("/",$nameSpace));
        if($nameSpaceCount < 3) {
            $this->error(" Name space count must be 3 or more, given ".$nameSpaceCount);
            return 0;
        }
        switch ($type) {
            case 'crud':
                if ($name != "") {
                    $this->error("  Do not use --name on crud operation");
                } else {
                    if ($model == "") {
                        $this->error(" --model required on crud");
                    } else {
                        $this->InitCrud();
                    }
                }
                break;
            case 'DataTable':
                if ($name == "" || $model == "") {
                    $this->error(" --name  and --model  must be required ");
                } else {
                    if ($name == $model) {
                        $this->error(" --name  and --model  must be unique ");
                    } else {
                        $this->InitDataTable();
                    }
                }
                break;
            case 'form':
                if ($name == "" || $model == "" || $formType == "") {
                    $this->error(" --name  and --model and --formType must be required ");
                    return 0;
                } 
                if ($name == $model) {
                    $this->error(" --name  and --model  must be unique ");
                    return 0;
                }
                if(!in_array($formType,['update','create'])) {
                    $this->error(" --formType  only accept `update` or `create`");
                    return 0;
                }
                $this->InitForm();
                break;
            case 'modal':
                if ($name == "") {
                    $this->error(" --name  required ");
                    return 0;
                } 
                $this->InitModal();
                break;
            case 'loadView':
                if ($name == "") {
                    $this->error(" --name  required ");
                    return 0;
                } 
                $this->InitLoadView();
                break;
            case 'dataView':
                if ($name == "") {
                    $this->error(" --name  required ");
                    return 0;
                } 
                $this->InitDataView();
                break;
            case 'react':
                if ($name == "" || $formType == "") {
                    $this->error(" --name  and --fromType required ");
                    return 0;
                } 
                if(!in_array($formType,['comp','compView'])) {
                    $this->error(" --formType  only accept `comp` or `compView`");
                    return 0;
                }
                $this->InitReact($formType);
                break;
            default:
                $this->error(" Incorrect argumant type, valid types are `crud`,`datatable`,`form`, `modal`, `loadview`, `react` ");
                break;
        }
    }

    public function getDefaultViewPath($nameSpace)
    {
        $array = explode("/", $nameSpace);
        $newArray = [];
        for ($i = 0; $i < count($array); $i++) {
            if ($i == 1) {
                $newArray[] = "pages";
            }
            $newArray[] = strtolower($array[$i]);
        }
        return  implode(".", $newArray);
    }

    public function getDotToUrl($viewPath, $name)
    {
        $newViewPath = explode(".", $viewPath);
        unset($newViewPath[1]);
        $url = implode("/", $newViewPath);
        return $url;
    }

    public function getNavNamespace($pageDotUrl)
    {
        $array = explode(".", $pageDotUrl);
        $array = array_filter($array, function ($value) use ($array) {
            return array_pop($array) != $value;
        });
        return implode("\\", $array);
    }
    public function getDefaults()
    {
        $pageDotUrl = $this->getDefaultViewPath($this->argument('nameSpace'));
        $name =  $this->option('name') ?? $this->option('model')  ?? "ModelName";
        $nameSpace = $this->argument('nameSpace');
        $model = $this->option('model') ?? "ModelName";
        $pageNavNmaSpace =  $this->getNavNamespace($pageDotUrl);
        return [
            "type" => $this->argument('type'),
            "name" => $name,
            "nameSpace" => $nameSpace,
            "properNameSpace" => implode("\\", explode("/", $this->argument('nameSpace'))),
            "pageNavNameSpace" => $pageNavNmaSpace,
            "model" => $model,
            "pageNav" => $this->option('pageNav') ?? "",
            "formType" => $this->option('formType') ?? "",
            "navDotUrl" => implode(".", explode("\\", $pageNavNmaSpace)),
            "pageDotUrl" => $pageDotUrl,
            "pageUrl" => $this->getDotToUrl($pageDotUrl, $name),
            "tableName" => Str::plural(Str::snake($model)),
            "first" => (isset(explode("/",$nameSpace)[0])) ? explode("/",$nameSpace)[0] : "none"
        ];
    }
}
