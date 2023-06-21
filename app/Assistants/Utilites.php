<?php

namespace App\Assistants;

use Illuminate\Database\Eloquent\Model;

trait Utilites
{
    public function fetchArrFromModel(Model $model, string $relation, string $field): array
    {
        $result = [];
        $arr = $model->$relation->toArray();
        foreach ($arr as $item) {
            if (isset($item[$field])) {
                $result[] = $item[$field];
            }
        }

        return $result;
    }
}