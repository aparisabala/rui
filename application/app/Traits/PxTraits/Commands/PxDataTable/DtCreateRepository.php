<?php
namespace App\Traits\PxTraits\Commands\PxDataTable;
use File;
trait DtCreateRepository
{
    public function MakeDtRepository()
    {
        $d = $this->getDefaults();
        $model = $d['model'];
        $name = $d['name'];
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
            $content = $this->DtInterFaceString($model,$properNameSpace,$name);
            File::put($intefacePath, $content);
            $this->info("Interface " . $interface . " created ");
        } 
        if (!File::exists($repositoryPath)) {
            $content = $this->DtRepositoryString($model,$properNameSpace,$name);
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

    public function DtInterFaceString($model,$nameSpace,$name)
    {
        $codeString = <<<PHP
        <?php

        namespace App\Repositories\\$nameSpace;

        interface I{$name}Repository
        {
            public function list(\$model,\$request);
        }

        PHP;
        return $codeString;
    }

    public function DtRepositoryString($model, $nameSpace ,$name)
    {
        $codeString = <<<PHP
        <?php

        namespace App\Repositories\\$nameSpace;

        use App\Models\\$model;
        use App\Repositories\BaseRepository;
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
        }
        PHP;
        return $codeString;
    }
}
