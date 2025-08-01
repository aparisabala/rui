{{ 
    load_assets([
        'scripts'=>
            [
                [
                    "nameSpace" => "px_assets/css",
                    "files" =>  [
                        'system/fonts',
                        'system/plugins/confirm',
                        "system/plugins/colorpiker",
                        'system/plugins/summernote/light',
                        'system/plugins/select2',
                        'system/plugins/datepiker',
                        'system/plugins/croppie',
                        'system/plugins/dt/bs5',
                        'system/plugins/cropper',
                        'system/icons/fa/css',
                        'system/icons/fa5/css',
                        'system/icons/boxicons/css',
                        'system/plugins/util',
                    ]
                ],
                [
                    "nameSpace" => "app_assets/css",
                    "files" =>  [
                        'site/theme',
                    ]
                ]
            ],
        "version"=> V,
        "extension"=>"css"
    ])
}} 