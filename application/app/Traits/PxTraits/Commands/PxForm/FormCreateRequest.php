<?php
namespace App\Traits\PxTraits\Commands\PxForm;
use File;
use Str;
trait FormCreateRequest
{
    public function MakeFormRequest()
    {
        $d = $this->getDefaults();
        $model = $d['model'];
        $formType = $d['formType'];
        $name = $d['name'];
        $properNameSpace = $d['properNameSpace'];
        $createValidation = "Validate".$name;
        $updateValidation = "Validate".$name;
    
        if($formType == "create") {
            $path = base_path("App\\Http\\Requests") . "\\" . $properNameSpace . "\\";
            if (!is_dir($path)) {
                File::makeDirectory($path, 0755, true);
            }
            $createPath = $path . $createValidation . '.php';
            if (!File::exists($createPath)) {
                $content = $this->FormCreateValidationString($model,$properNameSpace,$name);
                File::put($createPath, $content);
                $this->info("Request " . $createValidation . " created ");
            }
        }
        if($formType == "update") {
            $path = base_path("App\\Http\\Requests") . "\\" . $properNameSpace . "\\";
            if (!is_dir($path)) {
                File::makeDirectory($path, 0755, true);
            }
            $updatePath = $path . $updateValidation . '.php';
            if (!File::exists($updatePath)) {
                $content = $this->FormUpdateValidationString($model,$properNameSpace, $name);
                File::put($updatePath, $content);
                $this->info("Request " . $updateValidation . " created ");
            } 
        }
    }

    public function FormCreateValidationString($model, $nameSpace, $name)
    {
        $codeString = <<<PHP
        <?php

        namespace App\Http\Requests\\$nameSpace;

        use Illuminate\Contracts\Validation\Validator;
        use Illuminate\Foundation\Http\FormRequest;
        use Illuminate\Support\Facades\Lang;
        use Illuminate\Validation\ValidationException;

        class Validate$name extends FormRequest
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

    public function FormUpdateValidationString($model, $nameSpace,$name)
    {
        $codeString = <<<PHP
        <?php

        namespace App\Http\Requests\\$nameSpace;

        use Illuminate\Contracts\Validation\Validator;
        use Illuminate\Foundation\Http\FormRequest;
        use Illuminate\Support\Facades\Lang;
        use Illuminate\Validation\ValidationException;

        class Validate$name extends FormRequest
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
