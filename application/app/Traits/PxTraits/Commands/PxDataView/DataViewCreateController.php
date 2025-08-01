<?php
namespace App\Traits\PxTraits\Commands\PxDataView;
use File;
trait DataViewCreateController
{
    public function MakeDataViewController()
    {
        $d = $this->getDefaults();
        $model = $d['model'];
        $name = $d['name'];
        $properNameSpace = $d['properNameSpace'];
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
                        $content = $this->DataViewGetControllerString($controller);
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

    public function DataViewGetControllerString($controller)
    {   
        $d = $this->getDefaults();
        $name = $d['name'];
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
                \$this->lang = '$fileDirectory/view$name';
            }
            public function view$name(Request \$request)
            { 
                \$data = getPageDefault("$pageUrl/manage",\$request);
                \$data['lang'] = \$this->lang;
                return view('$pageDotUrl.view$name')->with('data',\$data);
            }
        }
        PHP;
        return $codeString;
    }
}
