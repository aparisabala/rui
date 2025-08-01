@php
$r = explode("/", \Route::getFacadeRoot()->current()->uri());
$di = "common";
switch ($r[1]) {
	case 'case':
		$di = "case";
	break;
	default:
		$di = "common";
	break;
}
@endphp
{{ 
    load_assets([
        'scripts'=>
            [
                [
                    "nameSpace" => "app_assets/js",
                    "files" => ["config"]
                ],
                [
                    "nameSpace" => "px_assets/js",
                    "files" =>  [
                        "system/plugins/moment",
                        "system/lib/jq",
                        "system/lib/pdfmake",
                        "system/lib/socket",
                        "config",
                        "system/core/helpers",
                        "global/common",
                        "system/plugins/pdfmake",
                        "system/plugins/vd",
                        "system/plugins/colorpiker",
                        "system/plugins/confirm",
                        "system/plugins/dt/bs5",
                        "system/plugins/select2",
                        "system/plugins/datepiker",
                        "system/plugins/cropper",
                        "system/plugins/xlsx",
                        "system/plugins/underscore",
                        "system/core/setup",
                        "system/core/extends",
                        "system/lib/panel/panelFlat",
                        "system/lib/panel/system/plugins",
                        "system/calls",
                        "system/plugins/summernote/light"
                    ]
                ],
                [
                    "nameSpace" => "app_assets/js",
                    "files" =>  [
						"application/global",
						"application/global/calls",
						"application/site/theme",
                        "application/site/".$di."",
                        "application/site/".$di."/calls"
                    ]
                ]
            ],
        "version"=> V,
        "extension"=>"js"
    ])
}} 
{{
	load_app($react=$react ?? [],V)
}}