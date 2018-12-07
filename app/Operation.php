<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'operations';

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = ['name', 'operation_date', 'balance', 'details', 'type_operation_id', 'author_id'];
}
