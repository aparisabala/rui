<?php
namespace App\Traits\PxTraits\Commands\PxDataTable;
use File;
use Str;
trait DtCreateViews
{
    public function MakeDtViews()
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
            $content = $this->DtViewFileSting($model,$pageDotUrl);
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
                <a href="{{ url('{$pageUrl}/list') }}" class="p-2 p-link">{$name}</a>
                PHP;
                File::put($filePath, $content);
                $this->info("Nav file modifiled ");
            }
        }
    }

    public function DtViewFileSting($model)
    {
        $string = implode(" ",explode("_",Str::snake($model)));
        $d = $this->getDefaults();
        $pageNav = $d['pageNav'];
        $name = $d['name'];
        $first = strtolower($d['first']);
        $navDotUrl = strtolower($d['navDotUrl']);
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
                                @if(count(\$data['items']) > 0)
                                    @include('common.view.fragments.SelectedShow')
                                    <input type="hidden"  value="{{ json_encode(Lang::get(explode(".",\$data['lang'])[0])) }}" id="pageLang"/>
                                    @include('common.view.pdf.layout',['docTitle' => '$model List'])
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="dt$name">
                                        </table>
                                    </div>
                                @else
                                    @include('common.view.fragments.NoDataFound',
                                    [
                                        'title' => Lang::get('common.errors.no_data_title'),
                                        'message' => Lang::get('common.errors.no_data_mgs'),
                                        'url' => 'no',
                                        'btn_text' => ''
                                    ])
                                @endif
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
