<?php

namespace App\Repositories\Admin\Systemsettings\SystemUser;

interface ISystemUserRepository
{
    public function create($request,$data);
    public function delete($request);
    public function updateRow($request);
    public function update($request);
    public function list($model,$request);
    public function loadEdit($request);
}
