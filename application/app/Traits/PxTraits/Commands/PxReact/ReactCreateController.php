<?php
namespace App\Traits\PxTraits\Commands\PxReact;
use File;
use Str;
trait ReactCreateController
{
    public function MakeReactControler()
    {
        $d = $this->getDefaults();
        $model = $d['model'];
        $name =  ucfirst($d['name']);
        $pageUrl = $d['pageUrl'];
        $d = $this->getDefaults();
        $properNameSpace = $d['properNameSpace'];
        $prefixs = ["Get"];
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
                        $content = $this->ReactGetontrollerString($controller);
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

    public function ReactGetontrollerString($controller)
    {   
        $d = $this->getDefaults();
        $name = $d['name'];
        $model = $d['model'];
        $pageDotUrl = $d['pageDotUrl'];
        $pageUrl = $d['pageUrl'];
        $properNameSpace = $d['properNameSpace'];
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
            }
            public function view$name(Request \$request)
            { 
                \$data = getPageDefault("$pageUrl/manage",\$request);
                return view('$pageDotUrl.view$name')->with('data',\$data);
            }
        }
        PHP;
        return $codeString;
    }

}
