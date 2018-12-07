<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OperationType extends Model
{
    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'operation_types';

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = ['title', 'details', 'author_id', 'is_income'];

    public function operations()
    {
        return $this->hasMany('App\Operation', 'type_operation_id', 'id');
    }
}
