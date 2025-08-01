<?php
namespace App\Traits\PxTraits\Commands\PxModal;
use File;
use Str;
trait ModalCreateController
{
    public function MakeModalController()
    {
        $d = $this->getDefaults();
        $model = $d['model'];
        $name =  ucfirst($d['name']);
        $properNameSpace = $d['properNameSpace'];
        $pageUrl = $d['pageUrl'];
        $pageDotUrl = $d['pageDotUrl'];
        $d = $this->getDefaults();
        $properNameSpace = $d['properNameSpace'];
        $prefixs = ["Load"];
        for ($i = 0; $i < count($prefixs); $i++) {
            $controller = $name . $prefixs[$i] . "Controller";
            $path = base_path("App\\Http\\Controllers") . "\\" . $properNameSpace."\\";
            if (!is_dir($path)) {
                File::makeDirectory($path, 0755, true);
            }
            $filePath = $path . $controller . '.php';
            if (!File::exists($filePath)) {
                $content = "";
                switch ($prefixs[$i]) {
                    case 'Load':
                        $content = $this->ModalLoadControllerString($controller);
                        break;
                    default:
                        # code...
                        break;
                }
                File::put($filePath, $content);
                $this->info("Controller " . $controller . " created ");
            }
        }
    }

    public function ModalLoadControllerString($controller)
    {   
        $d = $this->getDefaults();
        $name= $d['name'];
        $nameUp =  ucfirst($name);
        $model = $d['model'];
        $pageDotUrl = $d['pageDotUrl'];
        $properNameSpace = $d['properNameSpace'];
        $repository = $nameUp."Repository";
        $fileDirectory = implode("/",explode(".",$pageDotUrl));
        $codeString = <<<PHP
        <?php

        namespace App\Http\Controllers\\$properNameSpace;

        use App\Http\Controllers\Controller;
        use App\Traits\BaseTrait;
        use Illuminate\Http\Request;
        use View;
        use Lang;
        class $controller extends Controller
        {
            use BaseTrait;
            public function __construct()
            {
                \$this->lang = '$fileDirectory/loads/$name';
            }

            public function $nameUp(Request \$request)
            {
                \$data = [];
                \$view = View::make('{$pageDotUrl}.loads.{$name}', compact('data'))->render();
                \$response = [
                    'extraData' => [
                        'inflate' =>  Lang::get('common.response_success')
                    ],
                    'view'=>\$view
                ];
                return \$this->response(['type'=>'success','data'=>\$response]);
            }
        }
        PHP;
        return $codeString;
    }
}
