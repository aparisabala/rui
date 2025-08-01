<?php

namespace App\Repositories;

interface IBaseRepository
{
    public function findByField($model,$data);
    public function facSrWc($model,$data);
}
