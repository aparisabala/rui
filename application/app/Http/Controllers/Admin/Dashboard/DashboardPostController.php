<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Dashboard\Password\ValidateUpdatePassword;
use App\Models\Schedule;
use App\Traits\BaseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Lang;
use Hash;
class DashboardPostController extends Controller
{
    use BaseTrait;
    public function __construct()
    {
        $this->LoadMiddleware('',['SetAdminLanguage']);
        $this->LoadModels(['Globuser']);
    }

    public function updatePassword(Request $request)
    {
        $user = $this->checkExists($request,"Globuser|uuid|uuid",['id','name','password']);
        if(empty($user)) {
            return $this->response(['type'=>'noUpdate','title'=>  'User not found, try again']);
        }
        $validator = Validator::make($request->all(), (new ValidateUpdatePassword())->rules($user));
        if ($validator->fails()) {
            return $this->response(['type' => 'validation', 'errors' => $validator->errors()]);
        }
        $user->password = Hash::make($request->confirm_password);
        $user->save();
        $reposne['extraData'] = [
            "inflate" => 'Updated successfully',
            "redirect" => 'admin/logout'
        ];
        return $this->response(['type' => 'success', "data" => $reposne]);
    }

    // calendar 
    public function update(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->update([
            'start' => Carbon::parse($request->input('start_date'))->setTimezone('UTC'),
            'end' => Carbon::parse($request->input('end_date'))->setTimezone('UTC'),
        ]);
        return response()->json(['message' => 'Event moved successfully']);
    }
    public function resize(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);
        $newEndDate = Carbon::parse($request->input('end_date'))->setTimezone('UTC');
        $schedule->update(['end' => $newEndDate]);
        return response()->json(['message' => 'Event resized successfully.']);
    }

    public function create(Request $request)
    {
        $item = new Schedule();
        $item->title = $request->title;
        $item->start = $request->start;
        $item->end = $request->end;
        $item->description = $request->description;
        $item->color = $request->color;
        $item->save();
        return redirect('admin/dashboard');
    }
}
