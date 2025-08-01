<?php
namespace App\Traits\PxTraits\Commands\PxForm;
use File;
trait FormCreateController
{
    public function MakeFormController()
    {
        $d = $this->getDefaults();
        $model = $d['model'];
        $name = $d['name'];
        $properNameSpace = $d['properNameSpace'];
        $pageUrl = $d['pageUrl'];
        $d = $this->getDefaults();
        $properNameSpace = $d['properNameSpace'];
        $prefixs = ["Get", "Post"];
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
                    case 'Post':
                        $content = $this->FormPostControllerString($controller);
                        break;
                    case 'Get':
                        $content = $this->FormGetControllerString($controller);
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

    public function FormGetControllerString($controller)
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
                \$this->LoadModels(['$model']);
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

    public function FormPostControllerString($controller)
    {   
        
        $d = $this->getDefaults();
        $name = $d['name'];
        $model = $d['model'];
        $formType = $d['formType'];
        $properNameSpace = $d['properNameSpace'];

        $validator = ($formType == "update") ? 'Request' : 'Validate'.$name;

        $methodName = ($formType == "create") ? "create" : 'updateRow';

        $repository = 'I'.$name."Repository";
        $codeString = <<<PHP
        <?php

        namespace App\Http\Controllers\\$properNameSpace;

        use App\Http\Controllers\Controller;
        use App\Repositories\\$properNameSpace\\$repository;
        //vd
        use App\Traits\BaseTrait;
        use Illuminate\Http\Request;

        class $controller extends Controller
        {
            use BaseTrait;

            public function __construct(public $repository \$I{$name}Repo)
            {
                \$this->LoadModels(['$model']);
            }

            public function $methodName($validator \$request)
            {
                return \$this->I{$name}Repo->{$methodName}(\$request);
            }
        }
        PHP;

        if($formType == "create") {
            $contentArray = explode("//vd",$codeString);
            $codeString =<<<PHP
            $contentArray[0]
            use App\Http\Requests\\$properNameSpace\\$validator;
            $contentArray[1]
            PHP;
        }
        return $codeString;
    }
}
