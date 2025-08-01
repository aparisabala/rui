<?php
function load_assets($op)
{
    $scripts = $op['scripts'] ?? [];
    $version = $op['version'] ?? "1.1";
    $extension = $op['extension'] ?? "";
    if (count($scripts) > 0) {
        foreach ($scripts as $key => $item) {
            $nameSpace = $item['nameSpace'] ?? "px_assets/js";
            $files = $item['files'] ?? [];
            foreach ($files as $key => $file) {
                $paths = array(
                    __DIR__ . '/../../../public_html/' . $nameSpace . '/' . $file . '/*.' . $extension,
                );
                for ($p = 0; $p < count($paths); $p++) {
                    $s = glob($paths[$p]);
                    for ($i = 0; $i < count($s); $i++) {
                        if ($extension == "css") {
                            print '<link href="' . url('/') . substr($s[$i], strpos($s[$i], "/" . $nameSpace)) . '?ver=' . $version . '"  rel="stylesheet"  />' . PHP_EOL;
                        } else {
                            print '<script  src="' . url('/') . substr($s[$i], strpos($s[$i], "/" . $nameSpace)) . '?ver=' . $version . '" ></script>' . PHP_EOL;
                        }
                    }
                }
            }
        }
    }
}

function load_app($compo = [], $versionFinal = "")
{
    if (count($compo) > 0) {
        foreach ($compo as $key => $value) {
            print '<script src="' . url('resources/js/app/' . $value) . '?ver=' . $versionFinal . '"></script>' . PHP_EOL;
        }
    }
}

function getFilesRecursively($directory, $prepend)
{
    $files = [];
    $iterator = new \RecursiveIteratorIterator(
        new \RecursiveDirectoryIterator($directory, \RecursiveDirectoryIterator::SKIP_DOTS),
        \RecursiveIteratorIterator::SELF_FIRST
    );
    foreach ($iterator as $fileInfo) {
        if ($fileInfo->isFile()) {
            $relativePath = $prepend . "/" . ltrim(str_replace($directory, '', $fileInfo->getPathname()), DIRECTORY_SEPARATOR);
            $files[] = $relativePath;
        }
    }

    return $files;
}
function getPageDefault($base, $request)
{
    return [
        "base" => $base,
        "item" => null,
        "items" => [],
        "lang" => null,
        "type" => (isset($request->uuid)) ? "edit" : "page"
    ];
}

function lang()
{

    return config('a.local');
}

function getAccessName($r)
{

    return implode(",", array_map(function ($tr) {

        return getRole($tr);
    },  json_decode($r)->access_level));
}
function getRole($r)
{

    switch ($r) {

        case 'AD':
            return 'Admin';
            break;

        case 'ACC':
            return 'Accountant';
            break;

        default:
            return 'Super Admin';
            break;
    }
}

function local()
{
    return app()->getLocale();
}
function getStartEndDateMax($request, $max = 30)
{
    $start_date = Carbon::now();
    $end_date   = Carbon::now();

    if (Carbon::parse($request->start_date) > Carbon::parse($request->end_date)) {

        return Response::json(array(
            "success"  => false,
            "noUpdate" => true,
            "msg"      => '<span class="gray fs-14">Start date can not be greater than end date</span>',
            "mobMgs"   => "Error",
            "mobDes"   => "Start date can not be greater than end date",
        ));
    }

    $diff = Carbon::parse($request->end_date)->diffInDays(Carbon::parse($request->start_date));

    if ($diff >= $max) {

        return Response::json(array(
            "success"  => false,
            "noUpdate" => true,
            "msg"      => '<span class="gray fs-14">Please select between ' . $max . ' days, given ' . $diff . ' days</span>',
            "mobMgs"   => "Error",
            "mobDes"   => "Please select between " . $max . " days, given " . $diff . " days",
        ));
    }

    $start_date = Carbon::parse($request->start_date);
    $end_date   = Carbon::parse($request->end_date);

    return [
        "0" => $start_date,
        "1" => $end_date,
    ];
}
