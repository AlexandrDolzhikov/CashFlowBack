<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function operations() 
    {
        return $this->hasMany('App\Operation', 'author_id', 'id');
    }

    public function type_operations() 
    {
        return $this->hasMany('App\OperationType', 'author_id', 'id');
    }

    /**
     * Метод проверяет к какому типу относится операция. Доход либо расход. Этот метод работает только для таблицы со всеми операциями.
     * Потому что здесь дается информация - это либо расход, либо доход. А у нас есть много категорий операций.
     */
    public function getCategoryLabel($operations) {

        foreach($operations as $operation) {

            $category = OperationType::where('id', '=', $operation->type_operation_id)->first();

            if(1 == $category['is_income']) {

                $operation = $operation->type_operation_id = 1;
            } else {

                $operation = $operation->type_operation_id = 0;
            }

        }

        return $operations;
    }
}