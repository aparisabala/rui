<?php
namespace App\Traits\PxTraits\Commands\PxCrud;
use File;
trait CrudControllers
{

    public function MakeCrudControllers()
    {
        $d = $this->getDefaults();
        $model = $d['model'];
        $properNameSpace = $d['properNameSpace'];
        $prefixs = ["Get", "Post", "Api"];
        for ($i = 0; $i < count($prefixs); $i++) {
            $controller = $model . $prefixs[$i] . "Controller";
            $path = base_path("App\\Http\\Controllers") . "\\" . $properNameSpace."\\";
            if (!is_dir($path)) {
                File::makeDirectory($path, 0755, true);
            }
            $filePath = $path . $controller . '.php';
            if (!File::exists($filePath)) {
                $content = "";
                switch ($prefixs[$i]) {
                    case 'Api':
                        $content = $this->ApiControllerString($controller);
                        break;
                    case 'Get':
                        $content = $this->GetControllerString($controller);
                        break;
                        case 'Post':
                        $content = $this->PostControllerString($controller);
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

    
    public function GetControllerString($controller)
    {   
        $d = $this->getDefaults();
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
                \$this->lang = '$fileDirectory/view$model';
            }
            public function view$model(Request \$request)
            { 
                \$data = getPageDefault("$pageUrl/manage",\$request);
                if(isset(\$request->uuid)) {
                    \$data['item'] = \$this->{$model}->getQuery(['type'=>'first','query'=>['where'=>[[['uuid','=',\$request->uuid]]]]]);
                } else {
                    \$data['items'] = \$this->{$model}->getQuery(['type'=>'get','take'=>1]);
                }
                \$data['lang'] = \$this->lang;
                return view('$pageDotUrl.view$model')->with('data',\$data);
            }
        }
        PHP;
        return $codeString;
    }

    public function ApiControllerString($controller)
    {   
        $d = $this->getDefaults();
        $model = $d['model'];
        $properNameSpace = $d['properNameSpace'];

        $repository = 'I'.$model."Repository";
        $codeString = <<<PHP
        <?php

        namespace App\Http\Controllers\\$properNameSpace;

        use App\Http\Controllers\Controller;
        use App\Repositories\\$properNameSpace\\$repository;
        use App\Traits\BaseTrait;
        use Illuminate\Http\Request;

        class $controller extends Controller
        {
            use BaseTrait;

            public function __construct(public $repository \$I{$model}Repo)
            {
                \$this->LoadModels(['$model']);
            }

            public function list(Request \$request)
            {
                return \$this->I{$model}Repo->list(\$this->{$model}, \$request);
            }
        }
        PHP;
        return $codeString;
    }

    public function PostControllerString($controller)
    {   
        $d = $this->getDefaults();
        $model = $d['model'];
        $properNameSpace = $d['properNameSpace'];

        $repository = 'I'.$model."Repository";
        $codeString = <<<PHP
        <?php

        namespace App\Http\Controllers\\$properNameSpace;
        use App\Http\Controllers\Controller;
        use App\Http\Requests\\$properNameSpace\ValidateCreate$model;
        use App\Repositories\\$properNameSpace\\$repository;
        use App\Traits\BaseTrait;
        use Illuminate\Http\Request;
        class $controller extends Controller
        {
            use BaseTrait;
            public function __construct(public $repository \$I{$model}Repo)
            {
                \$this->LoadModels(['Globuser','$model']);
            }
            public function create(ValidateCreate$model \$request)
            {   
                \$auth = \$this->checkExists(\$request,"Globuser|uuid|created_by",['id','name']);
                if(empty(\$auth)) {
                    return \$this->response(['type'=>'noUpdate','title'=> 'Item not found']);
                }
                return \$this->I{$model}Repo->create(\$request,['created_by'=> \$auth->id]);
            }
            public function delete(Request \$request)
            {
                return \$this->I{$model}Repo->delete(\$request);
            }

            public function updateRow(Request \$request)
            {
                return \$this->I{$model}Repo->updateRow(\$request);
            }

            public function update(Request \$request)
            {
                return \$this->I{$model}Repo->update(\$request);
            }

        }
        PHP;
        return $codeString;
    }
    
}
