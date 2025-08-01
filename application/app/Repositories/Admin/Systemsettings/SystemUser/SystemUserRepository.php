<?php

namespace App\Repositories\Admin\Systemsettings\SystemUser;

use App\Http\Requests\Admin\Config\Session\ValidateUpdateSession;
use App\Http\Requests\Admin\Systemsettings\User\ValidateUpdateSystemUser;
use App\Models\Globuser;
use App\Repositories\Admin\Systemsettings\SystemUser\ISystemUserRepository;
use App\Repositories\BaseRepository;
use App\Traits\BaseTrait;
use Illuminate\Support\Facades\Lang;
use Webpatser\Uuid\Uuid;
use DataTables;
use View;
use Response;
use Hash;
use Image;
use File;
use Illuminate\Support\Facades\Validator;

class SystemUserRepository extends BaseRepository implements ISystemUserRepository
{
    use BaseTrait;
    public function __construct()
    {
        $this->LoadModels(['Globuser']);
    }
    public function list($model, $request)
    {
        $model = $model::where([['admin_type', '=', 'system']]);
        return DataTables::of($model)->make(true);
    }
    public function create($request, $data)
    {
        try {
            $m = new Globuser;
            $m->uuid = (string)Uuid::generate(4);
            $m->name = $request->name;
            $m->mobile_number = $request->mobile_number;
            $m->email = $request->email;
            $m->admin_type = "system";
            $m->password = Hash::make('123456789');
            $path = 'uploads/app/' . config('i.service_domain') . '/user/';
            $this->creatDir($path);
            $image = $request->file('user_image');
            if (!empty($image)) {
                $image_link = (string) Uuid::generate(4);
                $extension = $image->getClientOriginalExtension();
                $img = Image::make($image)->encode('jpg', 10);
                $img->resize(600, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $img->save($path . $image_link . '.' . $extension);
                $m->user_image = $image_link.'.'.$extension;
            }
            $m->save();
            $reposne['extraData'] = [
                "inflate" => Lang::get('common.action_success')
            ];
            return $this->response(['type' => 'success', "data" => $reposne]);
        } catch (\Exception $e) {
            $this->saveError($this->getSystemError(['name' => 'system_user_store_error']), $e);
            return $this->response(["type" => "wrong", "lang" => "server_wrong"]);
        }
    }
    public function delete($request)
    {
        $errors = [];
        $i = $this->Globuser->getQuery(['type' => 'get', 'query' => ['whereIn' => [['id', $request->ids]]]]);
        if (count($i) > 0) {
            try {
                foreach ($i as $key => $value) {
                    $path = 'uploads/app/' . config('i.service_domain') . '/user/';
                    $img_path = $path . $value->user_image;
                    if ($value->user_image != null && file_exists($img_path)) {
                        File::delete($img_path);
                    }
                    $value->delete();
                }
                $data['extraData'] = [
                    "inflate" => 'Deleted succesfully',
                    "redirect" => null
                ];
                return $this->response(['type' => 'success', "data" => $data]);
            } catch (\Exception $e) {
                $this->saveError($this->getSystemError(['name' => 'delete_egent_error']), $e);
                return $this->response(["type" => "wrong", "lang" => "server_wrong"]);
            }
        } else {
            return $this->response(['type' => 'noUpdate', 'title' =>  Lang::get('common.not_found', ['attribute' =>  Lang::get($this->agentLang . 'inputs.name')])]);
        }
    }
    public function updateRow($request)
    {
        $row = $this->Globuser->getQuery(['type' => 'first', 'select' => ['*'], 'query' => ['where' => [[['uuid', '=', $request->uuid]]]]]);
        if (empty($row)) {
            return $this->response(['type' => 'noUpdate', 'title' =>  '<span class="text-success"> ' . Lang::get('common.not_found', ['attribute' => Lang::get($this->agentLang . 'inputs.name')]) . '</span>']);
        }
        try {
            $row->name = $request->name;
            $row->mobile_number = $request->mobile_number;
            $row->email = $request->email;
            $path = 'uploads/app/' . config('i.service_domain') . '/user/';
            $image = $request->file('user_image');
            $original_size = "_original";
            if ($row->user_image != null && !empty($image)) {
                $delPath = $path . $row->user_image;
                if (File::exists($delPath)) {
                    File::delete($delPath);
                }
                if (!empty($image)) {
                    $image_link = (string) Uuid::generate(4);
                    $extension = $image->getClientOriginalExtension();
                    $img = Image::make($image)->encode('jpg', 10);
                    $img->resize(600, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $img->save($path . $image_link . '.' . $extension);
                    $row->user_image = $image_link . '.' . $extension;
                }
            }
            if ($row->isDirty()) {
                $validator = Validator::make($request->all(), (new ValidateUpdateSystemUser())->rules($request, $row));
                if ($validator->fails()) {
                    return $this->response(['type' => 'validation', 'errors' => $validator->errors()]);
                }
                $row->save();
                $data['extraData'] = [
                    "inflate" => 'Updated succesfully'
                ];
                return $this->response(['type' => 'success', 'data' => $data]);
            } else {
                return $this->response(['type' => 'noUpdate', 'title' =>  '<span class="text-success"> You made no changes </span>']);
            }
        } catch (\Exception $e) {
            $this->saveError($this->getSystemError(['name' => 'update_agent_error']), $e);
            return $this->response(["type" => "wrong", "lang" => "server_wrong"]);
        }
    }
    public function update($request)
    {
        $i = $this->Globuser->getQuery(['type' => 'get', 'query' => ['whereIn' => [['id', $request->ids]]], 'select' => ['id', 'name', 'serial']]);
        $dirty = [];
        if (count($i) > 0) {
            foreach ($i as $key => $value) {
                $value->serial = $request->serial[$value->id];
                if ($value->isDirty()) {
                    $dirty[$key] = "yes";
                }
            }
            if (count($dirty) > 0) {
                foreach ($i as $key => $value) {
                    $value->save();
                }
                $data['extraData'] = [
                    "inflate" => Lang::get('common.inflate', ['type' => Lang::get($this->agentLang . 'response.update')])
                ];
                return $this->response(['type' => 'success', 'data' => $data]);
            } else {
                return $this->response(['type' => 'noUpdate', 'title' =>  '<span class="text-success"> ' . Lang::get('common.no_change') . '</span>']);
            }
        } else {
            return $this->response(['type' => 'noUpdate', 'title' =>  Lang::get('common.went_wrong')]);
        }
    }

    public function loadEdit($request)
    {
        $data['lang'] = $this->sessionLang;
        $data['item'] = $this->LibSession->getQuery(['type' => 'first', 'select' => ['id', 'name', 'uuid'], 'query' => ['where' => [[['uuid', '=', $request->uuid]]]]]);
        if (empty($data['item'])) {
            return $this->response(['type' => 'noUpdate', 'title' =>  '<span class="text-success"> ' . Lang::get('common.not_found', ['attribute' => Lang::get($this->sessionLang . 'inputs.name')]) . '</span>']);
        }
        $view = View::make('admin.pages.config.session.loads.loadEdit', compact('data'))->render();
        $data = [
            "extraData" => [
                "inflate" => Lang::get('common.inflate', ['type' => Lang::get($this->sessionLang . 'response.update')]),
            ],
            "data" => $data,
            "view" => $view,
        ];
        return $this->response(['type' => 'load_html', 'data' => $data]);
    }
}
