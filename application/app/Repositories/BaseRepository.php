<?php

namespace App\Repositories;

use App\Traits\BaseTrait;

class BaseRepository implements IBaseRepository
{
    use BaseTrait;
    public function __construct()
    {
        //
    }
    public function findByField($model,$data=[])
    {
        $where = isset($data['where']) ? $data['where'] : [];
        $select = isset($data['select']) ? $data['select'] : ['*'];
        $q = [
            'type'=>'first',
            'query' => [],
            'select' => $select
        ];
        if(count($where)) {
            $q['query'] = [
                'where' => [$where]
            ];
        }
        return $model->getQuery($q);
    }
    public function facSrWc($model,$data=[])
    {
        $serial = 1;
        $s = $model->getQuery([
                'type'=>'first',
                'query'=>[
                    'latest'=>['serial']
                ],
                'select' => ['id','serial']
            ]
        );
        if(empty($s)) {
            $serial = 1;
        } else {
            $serial = $s->serial+1;
        }
        return $serial;
    }
}
