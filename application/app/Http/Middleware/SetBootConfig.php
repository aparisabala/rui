<?php

namespace App\Http\Middleware;

use App\Models\AppData;
use App\Traits\BaseTrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetBootConfig
{
    use BaseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $app_data = AppData::where('id',1)->select(['*'])->first();
        if(!empty($app_data) ) {
            config(['a' => $app_data]);
            config(['i' => [
                    'service_name' => "Ru Yi Holdings Ltd",
                    "mobile_number"=>"01847440303",
                    'logo'=>url('statics/images/system/logo.png'),
                    'favicon'=>url('statics/images/system/favicon.png'),
                    'service_domain'=>'lac.ummulqura.com.bd',
                    'service_email'=>'hello@lac.ummulqura.com.bd',
                    'theme' => [
                        'nav' => 'topNav'
                    ]
                ]
            ]);
            foreach (uploadsDir() as $key => $value) {
                $this->creatDir($value);
            }
        } else {
            die('Something went wrong, contact webmaster, Error code: system 404');
        }
        return $next($request);
    }
}
