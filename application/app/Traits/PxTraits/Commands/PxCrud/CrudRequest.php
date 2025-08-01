<?php
namespace App\Traits\PxTraits\Commands\PxCrud;
use File;
trait CrudRequest
{
    public function MakeCrudRequest()
    {
        $d = $this->getDefaults();
        $model = $d['model'];
        $properNameSpace = $d['properNameSpace'];
        $createValidation = "ValidateCreate".$model;
        $updateValidation = "ValidateUpdate".$model;
        $path = base_path("App\\Http\\Requests") . "\\" . $properNameSpace . "\\";
        if (!is_dir($path)) {
            File::makeDirectory($path, 0755, true);
        }
        $createPath = $path . $createValidation . '.php';
        if (!File::exists($createPath)) {
            $content = $this->CreateValidationString($model,$properNameSpace);
            File::put($createPath, $content);
            $this->info("Request " . $createValidation . " created ");
        }
        $updatePath = $path . $updateValidation . '.php';
        if (!File::exists($updatePath)) {
            $content = $this->UpdateValidationString($model,$properNameSpace);
            File::put($updatePath, $content);
            $this->info("Request " . $updateValidation . " created ");
        } 
    }

    public function CreateValidationString($model, $nameSpace)
    {
        $codeString = <<<PHP
        <?php

        namespace App\Http\Requests\\$nameSpace;

        use Illuminate\Contracts\Validation\Validator;
        use Illuminate\Foundation\Http\FormRequest;
        use Illuminate\Support\Facades\Lang;
        use Illuminate\Validation\ValidationException;

        class ValidateCreate$model extends FormRequest
        {
            public function authorize(): bool
            {
                return true;
            }

            public function message() : array
            {
                return [
                ];
            }
            public function rules(): array
            {
                return [
                    "name" => "required|string|max:253",
                ];
            }

            protected function failedValidation(Validator \$validator)
            {
                \$response = response()->json([
                    'success' => false,
                    'errors'  => \$validator->errors(),
                ]);
                throw (new ValidationException(\$validator, \$response))->errorBag(\$this->errorBag);
            }
        }

        PHP;
        return $codeString;
    }

    public function UpdateValidationString($model, $nameSpace)
    {
        $codeString = <<<PHP
        <?php

        namespace App\Http\Requests\\$nameSpace;

        use Illuminate\Contracts\Validation\Validator;
        use Illuminate\Foundation\Http\FormRequest;
        use Illuminate\Support\Facades\Lang;
        use Illuminate\Validation\ValidationException;

        class ValidateUpdate$model extends FormRequest
        {
            public function authorize(): bool
            {
                return true;
            }

            public function message() : array
            {
                return [
                ];
            }
            public function rules(\$row,\$request): array
            {
                \$rules = [
                ];
                \$rules['name'] = 'required|string|max:253';
                return \$rules;
            }

            protected function failedValidation(Validator \$validator)
            {
                \$response = response()->json([
                    'success' => false,
                    'errors'  => \$validator->errors(),
                ]);
                throw (new ValidationException(\$validator, \$response))->errorBag(\$this->errorBag);
            }
        }

        PHP;
        return $codeString;
    }

}
