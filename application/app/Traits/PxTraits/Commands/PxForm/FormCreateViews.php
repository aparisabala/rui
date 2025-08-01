<?php
namespace App\Traits\PxTraits\Commands\PxForm;
use File;
use Str;
trait FormCreateViews
{
    public function MakeFormViews()
    {
        $d = $this->getDefaults();
        $name = $d['name'];
        $model = $d['model'];
        $pageDotUrl  = $d['pageDotUrl'];
        $viewFile = "view".$name;
        $pageNav = $d['pageNav'];
        $pageUrl = $d['pageUrl'];
        $pageNavNameSpace = $d['pageNavNameSpace'];
        $fileDirectory = implode("\\",explode(".",$pageDotUrl));
        $path = base_path("resources\\views") . "\\" . $fileDirectory;
        if (!is_dir($path)) {
            File::makeDirectory($path."\\", 0755, true);
        }

        $filePath =  $path ."\\". $viewFile . '.blade.php';
        if (!File::exists($filePath)) {
            $content = $this->FormViewFileSting($model,$pageDotUrl);
            File::put($filePath, $content);
            $this->info("View " . $viewFile . " created ");
        }

        
        //language
        foreach (['en','bn'] as $key => $value) {
            $path = base_path("resources\\lang\\".$value) . "\\" . $fileDirectory;
            if (!is_dir($path)) {
                File::makeDirectory($path."\\", 0755, true);
            }
            $filePath =  $path."\\".$viewFile . '.php';
            if (!File::exists($filePath)) {
                $content = $this->LangFileString($model,$pageDotUrl);
                File::put($filePath, $content);
                $this->info($value." lang  " . $viewFile . " created ");
            }
        }
        
        if($pageNav == "yes") {
            $path = base_path("resources\\views") . "\\" . strtolower($pageNavNameSpace) . "\\navs\\";
            if (!is_dir($path)) {
                File::makeDirectory($path, 0755, true);
                $this->info("Nav file created ");
            }
            $filePath =  $path."navs.blade.php";
            if (!File::exists($filePath)) {
                $content = <<<PHP
                <a href="{{ url('{$pageUrl}') }}" class="p-2 p-link">{$name}</a>
                PHP;
                File::put($filePath, $content);
                $this->info("Nav file modifiled ");
            }
        }
    }
    public function FormViewFileSting($model)
    {
        $string = implode(" ",explode("_",Str::snake($model)));
        $d = $this->getDefaults();
        $pageNav = $d['pageNav'];
        $name = $d['name'];
        $formType =  ($d['formType']  == "create") ? "add":"glob_update";
        $icon = ($d['formType']  == "create") ? "plus":"save";
        $navDotUrl = strtolower($d['navDotUrl']);
        $first = strtolower($d['first']);
        $codeString = <<<PHP
        @extends('{$first}.layout.main_layout',["tabTitle" => config('i.service_name')." | ".Lang::get(\$data['lang'].'.breadCum.tabTitle')])

        @section('breadCum')
            <div class="py-2">
                <a href="#" class="breadcrumb-item">{{Lang::get(\$data['lang'].'.breadCum.B1')}}</a>
                <span class="breadcrumb-item">{{Lang::get(\$data['lang'].'.breadCum.B2')}}</span>
                <span class="breadcrumb-item active">{{Lang::get(\$data['lang'].'.breadCum.B3')}}</span>
            </div>
        @endsection

        @section('page')
            <div class="row">
                <div class="col-md-12">
                    <div id="defaultPage" class="pages">
                        <div class="card rounded-0 pb-3">
                            {{-- pageNav --}}
                            <h2 class="text-center text-uppercase fs-20 m-0 p-0 pt-2">  {{ Lang::get(\$data['lang'].'.titles.main_title') }}  </h2>
                            <hr class="m-0 mt-2">
                            <div class="mt-2 p-2 p-md-4">
                                <form id="frm{$name}" autocomplete="off">
                                    <input type="hidden" name="created_by" value="{{ Auth::user()->uuid }}" />
                                    <div class="row">
                                        <div class="col-md-4 offset-md-4">
                                            <div class="form-group text-left mb-3">
                                                <label class="form-label"> <b>  {{ Lang::get(\$data['lang'].'.inputs.name') }} </b> <em class="required">*</em> <span id="name_error"> </span></label>
                                                <div class="input-group">
                                                    <input type='text' class="form-control" name="name" id="name" />
                                                </div>
                                            </div>
                                            <div class="mb-3 mt-3 text-end">
                                                <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-{$icon}"></i>
                                                    {{Lang::get('common.btns.$formType')}}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endsection
        PHP;
        if($pageNav == "yes") {
            $contentArray = explode("{{-- pageNav --}}",$codeString);
            $codeString =<<<PHP
            $contentArray[0]{{-- pageNav --}}
                            <div class="pageNav">
                                <div id="pageSideBar" class="pageSideBar">
                                    <a href="javascript:void(0)" class="closebtn" onclick="closeNav('pageSideBar')">×</a>
                                    @include('{$navDotUrl}.navs.navs')
                                </div>
                                <div class="d-none d-md-block">
                                    @include('{$navDotUrl}.navs.navs')
                                </div>
                                <div class="d-block d-md-none">
                                    <div class="d-flex flex-row justify-content-end align-items-center p-2">
                                        <span style="font-size:30px;cursor:pointer" onclick="openNav('pageSideBar')">&#9776;</span>
                                    </div>
                                </div>
                            </div>
            $contentArray[1]
            PHP;
        }
        return $codeString;
    }
}
