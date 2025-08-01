<?php
namespace App\Traits\PxTraits\Commands\PxCrud;
use File;
trait CrudRepository
{
    public function MakeCrudRepository()
    {
        $d = $this->getDefaults();
        $model = $d['model'];
        $properNameSpace = $d['properNameSpace'];
        $repository = $model."Repository";
        $path = base_path("App\\Repositories") . "\\" . $properNameSpace . "\\";
        if (!is_dir($path)) {
            File::makeDirectory($path, 0755, true);
        }
        $interface = "I".$repository;
        $intefacePath = $path .$interface. '.php';
        $repositoryPath = $path . $repository . '.php';
        if (!File::exists($intefacePath)) {
            $content = $this->InterFaceString($model,$properNameSpace);
            File::put($intefacePath, $content);
            $this->info("Interface " . $interface . " created ");
        } 
        if (!File::exists($repositoryPath)) {
            $content = $this->RepositoryString($model,$properNameSpace);
            File::put($repositoryPath, $content);
            $this->info("Repository " . $repository . " created ");

            $provider = base_path("App\\Providers\\RepositoryServiceProvider.php");
            $content = File::get($provider);
            $contentArray = explode("//use",$content);
            $newContent =<<<PHP
            $contentArray[0]//use
            use App\Repositories\\$properNameSpace\\{$model}Repository;
            use App\Repositories\\$properNameSpace\\I{$model}Repository;
            $contentArray[1]
            PHP;

            $contentArray = explode("//bind",$newContent);
            $newContent =<<<PHP
            $contentArray[0]//bind
                            \$this->app->bind(abstract: I{$model}Repository::class, concrete: {$model}Repository::class);
            $contentArray[1]
            PHP;
            File::put($provider,$newContent);
        }
    }

    public function InterFaceString($model, $nameSpace)
    {
        $codeString = <<<PHP
        <?php

        namespace App\Repositories\\$nameSpace;

        interface I{$model}Repository
        {
            public function create(\$request,\$data);
            public function delete(\$request);
            public function updateRow(\$request);
            public function update(\$request);
            public function list(\$model,\$request);
        }

        PHP;
        return $codeString;
    }

    public function RepositoryString($model, $nameSpace)
    {
        $codeString = <<<PHP
        <?php

        namespace App\Repositories\\$nameSpace;
        
        use App\Http\Requests\\$nameSpace\ValidateUpdate$model;
        use App\Models\\$model;
        use App\Repositories\BaseRepository;
        use App\Traits\BaseTrait;
        use Carbon\Carbon;
        use Webpatser\Uuid\Uuid;
        use DataTables;
        use Illuminate\Support\Facades\Validator;
        use DB;
        use Lang;
        class {$model}Repository extends BaseRepository implements I{$model}Repository
        {
            use BaseTrait;
            public function __construct()
            {
                \$this->LoadModels(['$model']);
            }
            public function list(\$model, \$request)
            {   
                \$model = \$model::query();
                return DataTables::of(\$model)
                ->editColumn('created_at', function(\$item) {
                    return  Carbon::parse(\$item->created_at)->format('d-m-Y');
                })
                ->escapeColumns([])
                ->make(true);
            }
            public function create(\$request,\$data) {
                try {
                    \$m = new $model;
                    \$m->uuid = (string)Uuid::generate(4);
                    \$m->name = \$request->name;
                    \$m->save();
                    \$reposne['extraData'] = [
                        "inflate" => Lang::get('common.action_success')
                    ];
                    return \$this->response(['type'=>'success',"data"=>\$reposne]);
                } catch (\Exception \$e) {
                    \$this->saveError(\$this->getSystemError(['name'=>'{$model}_store_error']), \$e);
                    return \$this->response(["type"=>"wrong","lang"=> "server_wrong" ]);
                }
            }
            public function delete(\$request)
            {
                \$errors = [];
                \$i = \$this->{$model}->getQuery(['type'=>'get','query' => ['whereIn'=>[['id',\$request->ids]]]]);
                if (count(\$i) > 0) {
                    // \$errors = \$this->checkInUse([
                    //     "rows" => \$i,
                    //     "search" => ["id",],
                    //     "denined" => ["name","name"],
                    //     "targetModel" => [\$this->{$model},\$this->TargetModel],
                    //     "targetCol" => ["foreign_id"],
                    //     "exists" => ["Model Name"],
                    //     "in" => ["Model Name","To Be deleted"]
                    // ]);
                    if (count(\$errors) > 0) {
                        return \$this->response(['type'=>'bigError','errors'=>\$errors]);
                    }
                    foreach (\$i as \$key => \$value) {
                        \$value->delete();
                    }
                    \$data['extraData'] = [
                        "inflate" => Lang::get('common.action_delete_success'),
                        "redirect" => null
                    ];
                    return \$this->response(['type' => 'success',"data"=>\$data]);
                } else {
                    return \$this->response(['type' => 'noUpdate', 'title' => Lang::get('common.went_wrong') ]);
                }
            }
            public function updateRow(\$request)
            {
                \$row = \$this->{$model}->getQuery(['type'=>'first','select'=>['*'] ,'query'=>['where'=>[[['uuid','=',\$request->uuid]]]]]);
                if(empty(\$row)) {
                    return \$this->response(['type' => 'noUpdate', 'title' =>  '<span class="text-danger"> Item not found, try again</span>']);
                }
                \$row->name = \$request->name;
                if (\$row->isDirty()) {
                    \$validator = Validator::make(\$request->all(), (new ValidateUpdate$model())->rules(\$row,\$request));
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
            public function update(\$request)
            {
                \$i = \$this->{$model}->getQuery(['type'=>'get','query'=>['whereIn'=>[['id',\$request->ids]]],'select'=>['id','name','serial']]);
                \$dirty = [];
                if (count(\$i) > 0) {
                    foreach (\$i as \$key => \$value) {
                        \$value->serial = \$request->serial[\$value->id];
                        if (\$value->isDirty()) {
                            \$dirty[\$key] = "yes";
                        }
                    }
                    if (count(\$dirty) > 0) {
                        foreach (\$i as \$key => \$value) {
                            \$value->save();
                        }
                        \$data['extraData'] = [
                            "inflate" => Lang::get('common.action_update_success')
                        ];
                        return \$this->response(['type' => 'success','data' => \$data]);
                    } else {
                        return \$this->response(['type' => 'noUpdate', 'title' =>  '<span class="text-success"> '.Lang::get('common.no_change').' </span>']);
                    }

                } else {
                    return \$this->response(['type' => 'noUpdate', 'title' => Lang::get('common.went_wrong')]);
                }
            }
        }
        PHP;
        return $codeString;
    }
}
