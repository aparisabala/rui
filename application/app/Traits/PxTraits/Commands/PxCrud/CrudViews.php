<?php
namespace App\Traits\PxTraits\Commands\PxCrud;
use File;
use Illuminate\Support\Str;
trait CrudViews
{
    public function MakeCrudViews()
    {
        $d = $this->getDefaults();
        $model = $d['model'];
        $pageDotUrl  = $d['pageDotUrl'];
        $viewFile = "view".$model;
        $addFile = "viewAdd";
        $editFile = "viewEdit";
        $pageNav = $d['pageNav'];
        $pageUrl = $d['pageUrl'];
        $pageNavNameSpace = $d['pageNavNameSpace'];
        $fileDirectory = implode("\\",explode(".",$pageDotUrl));
        $path = base_path("resources\\views") . "\\" . $fileDirectory;
        if (!is_dir($path)) {
            File::makeDirectory($path."\\", 0755, true);
            File::makeDirectory($path.'\\includes', 0755, true);
        }
        $filePath =  $path ."\\". $viewFile . '.blade.php';
        if (!File::exists($filePath)) {
            $content = $this->ViewFileSting($model,$pageDotUrl);
            File::put($filePath, $content);
            $this->info("View " . $viewFile . " created ");
        }
        $filePath =  $path."\\includes\\". $addFile . '.blade.php';
        if (!File::exists($filePath)) {
            $content = $this->ViewAddFileSting($model,$pageDotUrl);
            File::put($filePath, $content);
            $this->info("Add file " . $addFile . " created ");
        } 

        $filePath =  $path."\\includes\\". $editFile . '.blade.php';
        if (!File::exists($filePath)) {
            $content = $this->ViewEditFileSting($model,$pageDotUrl);
            File::put($filePath, $content);
            $this->info("Edit file " . $editFile . " created ");
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
                <a href="{{ url('{$pageUrl}/manage') }}" class="p-2 p-link">{$model}</a>
                PHP;
                File::put($filePath, $content);
                $this->info("Nav file modifiled ");
            }
        }
    }

    public function ViewFileSting($model,$pageDotUrl)
    {   
        $string = implode(" ",explode("_",Str::snake($model)));
        $d = $this->getDefaults();
        $pageNav = $d['pageNav'];
        $navDotUrl = strtolower($d['navDotUrl']);
        $first = strtolower($d['first']);
        $codeString = <<<PHP
        @extends('{$first}.layout.main_layout',["tabTitle" => config('i.service_name')." | ".Lang::get(\$data['lang'].'.breadCum.tabTitle') ])

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
                    @if(\$data['item'] == null && \$data['type'] != "edit")
                        <div id="defaultPage" class="pages">
                            <div class="tool-box d-flex flex-row justify-content-end align-items-center">
                                <button data-prop='{"page": "addPage","server": "no"}' class="btn btn-sm rounded-pill btn-primary d-flex viewAction"><span class="bx bx-plus"></span> <span class="d-none d-md-block ms-1"> {{Lang::get('common.btns.glob_add')}} </span></button>
                                @if(count(\$data['items']) > 0)
                                    <button class="btn btn-sm rounded-pill btn-success d-flex ms-2 updateAll$model"><span class="bx bx-save"></span> <span class="d-none d-md-block ms-1">  {{Lang::get('common.btns.glob_update')}}  </span> </button>
                                    <button class="btn btn-sm rounded-pill btn-danger d-flex ms-2 deleteAll$model"><span class="bx bx-trash"></span> <span class="d-none d-md-block ms-1">  {{Lang::get('common.btns.glob_delete')}}  </span> </button>
                                    <button class="btn btn-sm rounded-pill btn-info d-flex ms-2" id="download{$model}Pdf"  data-pdf-op='{"file_name":"{{ config('i.service_domain').'_{$string}_list'  }}"}'><span class="bx bxs-file-pdf"></span> <span class="d-none d-md-block ms-1">  {{Lang::get('common.btns.glob_pdf')}} </span> </button>
                                    <button class="btn btn-sm rounded-pill btn-info d-flex ms-2" id="download{$model}Excel"  data-excel-op='{"file_name":"{{ config('i.service_domain').'_{$string}_list'  }}"}'><span class="bx bxs-file-export"></span> <span class="d-none d-md-block ms-1">  {{Lang::get('common.btns.glob_excel')}}  </span> </button>
                                @endif
                            </div>
                            <div class="card rounded-0 pb-3 mt-3">
                                {{-- pageNav --}}
                                <h2 class="text-center text-uppercase fs-20 m-0 p-0 pt-2">  {{ Lang::get(\$data['lang'].'.titles.main_title') }} </h2>
                                <hr class="m-0 mt-2">
                                <div class="mt-2 p-2 p-md-4">
                                    @if(count(\$data['items']) > 0)
                                        @include('common.view.fragments.SelectedShow')
                                        <input type="hidden"  value="{{ json_encode(Lang::get(explode(".",\$data['lang'])[0])) }}" id="pageLang"/>
                                        @include('common.view.pdf.layout',['docTitle' => '$model List'])
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="dt$model">
                                            </table>
                                        </div>
                                        @else
                                        @include('common.view.fragments.NoDataFound',
                                        [
                                            'title' => Lang::get('common.errors.no_data_title'),
                                            'message' => Lang::get('common.errors.no_data_mgs'),
                                            'url' => 'no',
                                            'btn_text' => ''
                                        ]
                                        )
                                        @endif
                                </div>
                            </div>
                        </div>
                        <div id="addPage" class="d-none pages">
                            @include('$pageDotUrl.includes.viewAdd') 
                        </div>
                    @else
                        <div id="editPage" class="pages">
                            <div class="card rounded-0 pb-3">
                                <div id="loadEdit" class="w-100">
                                    @include('$pageDotUrl.includes.viewEdit')
                                </div>
                            </div>
                        </div>
                    @endif
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
    public function ViewAddFileSting($model)
    {
        $codeString = <<<PHP
        <div class="card rounded-0 pb-3">
            <div class="bg-dark pl-2">
                <span class="text-light"> <a href=""><span class="badge badge-info cursor-pointer"> <i class='bx bxs-left-arrow-circle'></i></span></a> <span class="pt-1"> {{ Lang::get(\$data['lang'].'.titles.add_title') }} </span> </span>
            </div>
            <div class="mt-4 p-3">
                <form id="frmCreate$model" autocomplete="off">
                    <input type="hidden" name="created_by" value="{{ Auth::user()->uuid }}" />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4 offset-md-4">
                                    <div class="form-group text-left mb-3">
                                        <label class="form-label" > <b> {{ Lang::get(\$data['lang'].'.inputs.name') }}   </b> <em class="required">*</em> <span id="name_error"> </span></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="name" id="name">
                                        </div>
                                    </div>
                                    <div class="mb-3 mt-3 text-end">
                                        <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-plus"></i>  {{ Lang::get('common.btns.add') }}   </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        PHP;
        return $codeString;
    }

    public function ViewEditFileSting($model)
    {
        $codeString = <<<PHP
        <div class="bg-dark pl-2">
            <span class="text-light"> <a href="{{url(\$data['base'])}}"><span class="badge badge-info cursor-pointer"> <i class='bx bxs-left-arrow-circle'></i></span></a> <span class="pt-1">  {{ Lang::get(\$data['lang'].'.titles.update_title') }}   </span> </span>
        </div>
        <div class="p-3">
            @if(\$data['item'] != null)
            <form id="frmUpdate$model" autocomplete="off">
                <input type="hidden" name="uuid" value="{{\$data['item']->uuid}}">
                <div class="row">
                    <div class="col-md-4 offset-md-4">
                        <div class="form-group text-left mb-3">
                            <label class="form-label" > <b> {{ Lang::get(\$data['lang'].'.inputs.name') }}   </b> <em class="required">*</em> <span id="name_error"></span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="name" id="name" value="{{\$data['item']->name}}">
                            </div>
                        </div>
                        <div class="mb-3 mt-3 text-end">
                            <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-save"></i>  {{Lang::get('common.btns.glob_update')}}   </button>
                        </div>
                    </div>
                </div>
            </form>
            @else
                @include('common.view.fragments.NotFoundFragment')
            @endif
        </div>
        PHP;
        return $codeString;
    }
}
