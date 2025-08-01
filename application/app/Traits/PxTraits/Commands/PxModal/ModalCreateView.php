<?php

namespace App\Traits\PxTraits\Commands\PxModal;

use File;

trait ModalCreateView
{
    public function MakeModalView()
    {
        $d = $this->getDefaults();
        $name = $d['name'];
        $model = $d['model'];
        $pageDotUrl  = $d['pageDotUrl'];
        $viewFile = $name;
        $fileDirectory = implode("\\", explode(".", $pageDotUrl));
        $path = base_path("resources\\views\\")  . $fileDirectory . "\\loads\\";
        if (!is_dir($path)) {
            File::makeDirectory($path, 0755, true);
        }
        $filePath =  $path . $viewFile . '.blade.php';
        if (!File::exists($filePath)) {
            $content = "Modal Content";
            File::put($filePath, $content);
            $this->info("View " . $viewFile . " created ");
        }

        //language
        foreach (['en', 'bn'] as $key => $value) {
            $path = base_path("resources\\lang\\" . $value) . "\\" . $fileDirectory . "\\loads\\";
            if (!is_dir($path)) {
                File::makeDirectory($path . "\\", 0755, true);
            }
            $filePath =  $path . "\\" . $viewFile . '.php';
            if (!File::exists($filePath)) {
                $content = $this->LangFileString($model, $pageDotUrl);
                File::put($filePath, $content);
                $this->info($value . " lang  " . $viewFile . " created ");
            }
        }
    }
}
