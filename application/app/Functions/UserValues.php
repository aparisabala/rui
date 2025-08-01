<?php

use Webpatser\Uuid\Uuid;
use App\Models\LibSession;
use Carbon\Carbon;

function uploadsDir()
{

    return [
        "uploads",
        "uploads/app",
        "uploads/app/" . config('i.service_domain'),
        "uploads/app/" . config('i.service_domain') . "/user",
        "uploads/app/" . config('i.service_domain') . "/dyn",
        "uploads/app/" . config('i.service_domain') . "/dyn/images",
        "uploads/app/" . config('i.service_domain') . "/summernote",
    ];
}
function imagePaths()
{
    return [
        "def_male" => "statics/images/system/img.jpg",
        "user_image" => "uploads/app/" . config('i.service_domain') . "/user/",
        "dyn_image" => "uploads/app/" . config('i.service_domain') . "/dyn/images/",
        "summernote" => "uploads/app/" . config('i.service_domain') . "/summernote/",
    ];
}
