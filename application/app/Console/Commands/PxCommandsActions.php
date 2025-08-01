<?php 

namespace App\Console\Commands;

use App\Traits\PxTraits\Commands\BaseCommand;
use File;
class PxCommandsActions extends PX {

    use BaseCommand;
    public function InitCrud()
    {
        try {

            $this->MakeModelMigration();
            $d = $this->getDefaults();
            $model = $d['model'];
            $path = base_path("App\\Models") . "\\" . $model . '.php';
            $content = File::get($path);
            $contentArray = explode("//crud",$content);
            if(count($contentArray) == 1) {
                $this->MakeCrudControllers();
                $this->MakeCrudViews();
                $this->MakeCrudRequest();
                $this->MakeCrudRepository();
                $this->MakeCrudJsAsset();
                $this->MakeCrudRoute();

                $content = File::get($path);
                $contentArray = explode("//place",$content);
                $newContent =<<<PHP
                $contentArray[0]//crud
                $contentArray[1]
                PHP;
                File::put($path,$newContent);
            } else {
                $this->error("Model `{$model}` crud exists, try creating manual  crud, over-writing model crud can be destructive and not recomended");
            }

        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function InitDataTable()
    {
        try {

            $this->MakeModelMigration();
            $this->MakeDtRoute();
            $this->MakeDtRepository();
            $this->MakeDtController();
            $this->MakeDtViews();
            $this->MakeDtJsAsset();

        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function InitForm()
    {
        try {

            $this->MakeModelMigration();
            $this->MakeFormRoute();
            $this->MakeFormController();
            $this->MakeFormViews();
            $this->MakeFormRepository();
            $this->MakeFromJsAsset();
            $this->MakeFormRequest();

        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
       
    }

    public function InitDataView()
    {
        try {
            $this->MakeDataViewRoute();
            $this->MakeDataViewController();
            $this->MakeDataViewViews();
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function InitModal()
    {
        try {
            
            $this->MakeModalRoute();
            $this->MakeModalController();
            $this->MakeModalView();
            $this->MakeModalJsAsset();
            
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function InitLoadView()
    {
        try {
           
            $this->MakeLoadViewRoute();
            $this->MakeLoadViewController();
            $this->MakeLoadViewView();
            $this->MakeLoadViewJsAsset();
            
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function InitReact($formType)
    {

        try {
            $this->MakeReactCreateComponent();
            if($formType == "compView") {
                $this->MakeReactRoute();
                $this->MakeReactControler();
                $this->MakeReactView(); 
            }
            
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

    }

}