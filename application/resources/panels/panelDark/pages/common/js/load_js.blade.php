@php
$r = explode("/", \Route::getFacadeRoot()->current()->uri());
$di = "common";
switch ($r[1]) {
	case 'login':
		$di = "login";
	break;
	case 'setup':
		$di = "setup";
	break;
	case 'reset':
		$di = "reset";
	break;
	case 'dashboard':
		$di = "dashboard";
	break;
	case 'systemsettings':
		$di = "systemsettings";
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
                        "system/lib/panel/panelDark",
                        "system/lib/panel/panelDark/app",
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
                        "system/plugins/tree",
                        "system/core/setup",
                        "system/core/extends",
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
                        "application/admin/".$di."",
                        "application/admin/".$di."/calls"
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