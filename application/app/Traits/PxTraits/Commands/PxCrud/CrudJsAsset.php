<?php
namespace App\Traits\PxTraits\Commands\PxCrud;
use File;
use Str;
trait CrudJsAsset
{
    public function MakeCrudJsAsset()
    {
        $d = $this->getDefaults();
        $properNameSpace = $d['properNameSpace'];
        $model = $d['model'];
        $pageUrl = $d['pageUrl'];
        $path = base_path("..\\public_html\\app_assets\\js\\application\\" .strtolower(explode("\\",$properNameSpace)[0])."\\". strtolower(explode("\\",$properNameSpace)[1]) . "\\calls\\");
        if (!is_dir($path)) {
            File::makeDirectory($path, 0755, true);
        }
        $jsFilePath =  $path . Str::camel($model) . '.js';
        if (!File::exists($jsFilePath)) {
            $content = $this->JsAssetsString($model,$pageUrl);
            File::put($jsFilePath, $content);
            $this->info("Asset " . $model . ".js created ");
        }
    }


    public function JsAssetsString($model,$url)
    {   
        $codeString = <<<PHP
        \$(document).ready(function () {
            if (\$("#frmCreate$model").length > 0) {
                let rules = {
                    name: {
                        required: true,
                        maxlength: 253
                    }
                };
                ajaxRequest({
                    element: "frmCreate$model",
                    validation: true,
                    script: "{$url}/create",
                    rules,
                    afterSuccess: {
                        type: "inflate_reset_response_data"
                    },
                });

            }

            if (\$("#frmUpdate$model").length > 0) {
                let rules = {
                    name: {
                        required: true,
                        maxlength: 253
                    }
                };
                ajaxRequest({
                    element: "frmUpdate$model",
                    validation: true,
                    script: "{$url}/updateRow",
                    rules,
                    afterSuccess: {
                        type: "inflate_response_data"
                    }
                });

            }

            if (\$("#dt$model").length > 0) {
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
                        title:  table?.col?.created
                    },

                    {
                        data: null,
                        title: table?.col?.action,
                        class: 'text-end',
                        render: function (data, type, row) {
                            return `<a href="\${baseurl}{$url}/edit/\${data.uuid}" 
                                <span class="badge rounded-pill bg-info cursor-pointer me-2">
                                    <span class="bx bxs-edit text-white"></span>
                                </span>
                            </a>`;
                        }
                    },
                ];
                makeAjaxDataTable('dt$model', {
                    select: true,
                    url: '{$url}/list',
                    columns: col_draft,
                    pdf: [1, 2]
                });
            }
        });

        function dt$model(table, api, op) {
            G.deleteAll({
                element: "deleteAll$model",
                script: "{$url}/delete",
                confirm: true,
                api,
            });
            G.updateAll({
                element: "updateAll$model",
                script: "{$url}/update",
                confirm: true,
                dataCols: {
                    key: "ids",
                    items: [
                        {
                            index: 1,
                            name: "ids",
                            type: "input",
                            data: [],
                        },
                        {
                            index: 1,
                            name: "serial",
                            type: "input",
                            data: []
                        }
                    ]
                },
                api,
                afterSuccess: {
                    type: "inflate_response_data"
                }
            });
            dowloadPdf({ ...op, btn: "download{$model}Pdf", dataTable: "yes" });
            dowloadExcel({ ...op, btn: "download{$model}Excel", dataTable: "yes" });
        }
        PHP;
        return $codeString;
    }

}
