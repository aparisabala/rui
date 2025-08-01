<?php
namespace App\Traits\PxTraits\Commands\PxForm;
use File;
use Str;
trait FormCreateRepositoy
{
    public function MakeFormRepository()
    {
        $d = $this->getDefaults();
        $model = $d['model'];
        $name = $d['name'];
        $formType = $d['formType'];
        $properNameSpace = $d['properNameSpace'];
        $repository = $name."Repository";
        $path = base_path("App\\Repositories") . "\\" . $properNameSpace . "\\";
        if (!is_dir($path)) {
            File::makeDirectory($path, 0755, true);
        }
        $interface = "I".$repository;
        $intefacePath = $path .$interface. '.php';
        $repositoryPath = $path . $repository . '.php';
        if (!File::exists($intefacePath)) {
            $content = $this->FormInterFaceString($model,$properNameSpace,$name,$formType);
            File::put($intefacePath, $content);
            $this->info("Interface " . $interface . " created ");
        } 
        if (!File::exists($repositoryPath)) {
            $content = $this->FormRepositoryString($model,$properNameSpace,$name,$formType);
            File::put($repositoryPath, $content);
            $this->info("Repository " . $repository . " created ");

            $provider = base_path("App\\Providers\\RepositoryServiceProvider.php");
            $content = File::get($provider);
            $contentArray = explode("//use",$content);
            $newContent =<<<PHP
            $contentArray[0]//use
            use App\Repositories\\$properNameSpace\\{$name}Repository;
            use App\Repositories\\$properNameSpace\\I{$name}Repository;
            $contentArray[1]
            PHP;

            $contentArray = explode("//bind",$newContent);
            $newContent =<<<PHP
            $contentArray[0]//bind
                            \$this->app->bind(abstract: I{$name}Repository::class, concrete: {$name}Repository::class);
            $contentArray[1]
            PHP;
            File::put($provider,$newContent);
        }
    }

    public function FormInterFaceString($model,$nameSpace,$name,$formType)
    {   
        $methodName = ($formType == "create") ? "create" : 'updateRow';

        $codeString = <<<PHP
        <?php

        namespace App\Repositories\\$nameSpace;

        interface I{$name}Repository
        {
            public function {$methodName}(\$request);
        }

        PHP;
        return $codeString;
    }

    public function FormRepositoryString($model, $nameSpace ,$name, $formType)
    {   
        $methodName = ($formType == "create") ? "create" : 'updateRow';

        $codeString = <<<PHP
        <?php

        namespace App\Repositories\\$nameSpace;

        use App\Models\\$model;
        use App\Repositories\BaseRepository;
        {{-- validator --}}
        use App\Traits\BaseTrait;
        use Carbon\Carbon;
        use Webpatser\Uuid\Uuid;
        use DataTables;
        use Illuminate\Support\Facades\Validator;
        use DB;
        use Lang;
        class {$name}Repository extends BaseRepository implements I{$name}Repository
        {
            use BaseTrait;
            public function __construct()
            {
                \$this->LoadModels(['$model']);
            }
            {{-- method --}}
        }
        PHP;

        if($formType == "create") {
           
            $contentArray = explode("{{-- validator --}}",$codeString);
            $codeString =<<<PHP
            $contentArray[0]
            use App\Http\Requests\\$nameSpace\Validate$name;
            $contentArray[1]
            PHP;

            $contentArray = explode("{{-- method --}}",$codeString);
            $codeString = <<<PHP
            $contentArray[0]
                public function create(\$request) {
                    try {
                        \$m = new $model;
                        \$m->uuid = (string)Uuid::generate(4);
                        \$m->name = \$request->name;
                        \$m->save();
                        \$reposne['extraData'] = [
                            "inflate" =>  Lang::get('common.action_success')
                        ];
                        return \$this->response(['type'=>'success',"data"=>\$reposne]);
                    } catch (\Exception \$e) {
                        \$this->saveError(\$this->getSystemError(['name'=>'{$model}_store_error']), \$e);
                        return \$this->response(["type"=>"wrong","lang"=>"server_wrong"]);
                    }
                }
            $contentArray[1]
            PHP;
        }

        if($formType == "update") {

            $contentArray = explode("{{-- validator --}}",$codeString);
            $codeString =<<<PHP
            $contentArray[0]
            use App\Http\Requests\\$nameSpace\Validate$name;
            $contentArray[1]
            PHP;

            $contentArray = explode("{{-- method --}}",$codeString);
            $codeString =<<<PHP
            $contentArray[0]
                public function updateRow(\$request)
                {
                    \$row = \$this->{$model}->getQuery(['type'=>'first','select'=>['*'] ,'query'=>['where'=>[[['uuid','=',\$request->uuid]]]]]);
                    if(empty(\$row)) {
                        return \$this->response(['type' => 'noUpdate', 'title' =>  '<span class="text-danger"> '.Lang::get('common.page_not_found').' </span>']);
                    }
                    \$row->name = \$request->name;
                    if (\$row->isDirty()) {
                        \$validator = Validator::make(\$request->all(), (new Validate$name())->rules(\$row));
                        if (\$validator->fails()) {
                            return \$this->response(['type' => 'validation','errors' => \$validator->errors()]);
                        }
                        try {
                            \$row->save();
                            \$data['extraData'] = [
                                "inflate" => Lang::get('common.action_update_success')
                            ];
                            return \$this->response(['type' => 'success','data' => \$data]);
                        } catch (\Exception \$e) {
                            \$this->saveError(\$this->getSystemError(['name'=>'{$model}_update_error']), \$e);
                            return \$this->response(["type"=>"wrong","lang"=>"server_wrong"]);
                        }
                    } else {
                        return \$this->response(['type' => 'noUpdate', 'title' =>  '<span class="text-success">'.Lang::get('common.no_change').'</span>']);
                    }
                }
            $contentArray[1]
            PHP;
        }
        

        return $codeString;
    }
}
