<?php
namespace App\Traits\PxTraits\Commands\PxLoadView;
use File;
use Str;
trait LoadViewController
{
    public function MakeLoadViewController()
    {
        $d = $this->getDefaults();
        $model = $d['model'];
        $name =  ucfirst($d['name']);
        $properNameSpace = $d['properNameSpace'];
        $pageUrl = $d['pageUrl'];
        $d = $this->getDefaults();
        $properNameSpace = $d['properNameSpace'];
        $prefixs = ["Get","Load"];
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
                    case 'Get':
                        $content = $this->LoadViewGetControllerString($controller);
                        break;
                    case 'Load':
                        $content = $this->LoadViewLoadControllerString($controller);
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

    public function LoadViewGetControllerString($controller)
    {   
        $d = $this->getDefaults();
        $name = $d['name'];
        $nameUp = ucfirst($name);
        $model = $d['model'];
        $pageDotUrl = $d['pageDotUrl'];
        $pageUrl = $d['pageUrl'];
        $properNameSpace = $d['properNameSpace'];
        $fileDirectory = implode("/",explode(".",$pageDotUrl));
        $codeString = <<<PHP
        <?php

        namespace App\Http\Controllers\\$properNameSpace;

        use App\Http\Controllers\Controller;
        use App\Traits\BaseTrait;
        use Illuminate\Http\Request;
        class $controller extends Controller
        {
            use BaseTrait;
            public function __construct()
            {
                \$this->LoadMiddleware('auth:globuser',['HasSetPassword']);
                \$this->lang = '$fileDirectory/view$nameUp';
            }
            public function view$nameUp(Request \$request)
            { 
                \$data = getPageDefault("$pageUrl/manage",\$request);
                \$data['lang'] = \$this->lang;
                return view('$pageDotUrl.view$nameUp')->with('data',\$data);
            }
        }
        PHP;
        return $codeString;
    }

    public function LoadViewLoadControllerString($controller)
    {   
        $d = $this->getDefaults();
        $name= $d['name'];
        $nameUp =  ucfirst($name);
        $pageDotUrl = $d['pageDotUrl'];
        $properNameSpace = $d['properNameSpace'];
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
                \$this->lang = '$fileDirectory/view$nameUp';
            }

            public function $nameUp(Request \$request)
            {
                \$data = [];
                \$data['lang'] = \$this->lang;
                \$view = View::make('{$pageDotUrl}.loads.{$name}', compact('data'))->render();
                \$response = [
                    'extraData' => [
                        'inflate' => Lang::get('common.action_success')
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
