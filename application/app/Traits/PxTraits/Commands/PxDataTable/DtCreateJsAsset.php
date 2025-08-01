<?php
namespace App\Traits\PxTraits\Commands\PxDataTable;
use File;
use Str;
trait DtCreateJsAsset
{
    public function MakeDtJsAsset()
    {
        $d = $this->getDefaults();
        $properNameSpace = $d['properNameSpace'];
        $model = $d['model'];
        $name = $d['name'];
        $pageUrl = $d['pageUrl'];
        $path = base_path("..\\public_html\\app_assets\\js\\application\\" .strtolower(explode("\\",$properNameSpace)[0])."\\". strtolower(explode("\\",$properNameSpace)[1]) . "\\calls\\");
        if (!is_dir($path)) {
            File::makeDirectory($path, 0755, true);
        }
        $jsFilePath =  $path . 'dt'.ucfirst($name) . '.js';
        if (!File::exists($jsFilePath)) {
            $content = $this->DtJsAssetsString($name,$pageUrl);
            File::put($jsFilePath, $content);
            $this->info("Asset " . 'dt'.ucfirst($name) . ".js created ");
        }
    }

    public function DtJsAssetsString($name,$url)
    {   
        $codeString = <<<PHP
        \$(document).ready(function () {

            if (\$("#dt$name").length > 0) {
                const lang = G.pageLang;
                const {table} = lang;
                let col_draft = [
                    {
                        data: 'id',
                        title: table?.col?.id
                    },
                    {
                        data: 'name',
                        title: table?.col?.name
                    },
                    
                    {
                        data: 'created_at',
                        title: table?.col?.created
                    },

                    {
                        data: null,
                        title: table?.col?.action,
                        class: 'text-end',
                        render: function (data, type, row) {
                            return `
                            <span class="badge rounded-pill bg-info cursor-pointer me-2">
                                <span class="bx bxs-edit text-white"></span>
                                <span>Action</span>
                            </span>
                            `;
                        }
                    },
                ];
                makeAjaxDataTable('dt$name', {
                    select: false,
                    url: '{$url}/list',
                    columns: col_draft,
                });
            }
        });
        PHP;
        return $codeString;
    }
}
