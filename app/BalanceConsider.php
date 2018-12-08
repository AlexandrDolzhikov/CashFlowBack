<?php

namespace App;

use App\User;
use App\Operation;
use Illuminate\Database\Eloquent\Model;

class BalanceConsider extends Model
{
    /**
     * Метод сохраняет историю изменения баланса, которую можно увидеть в таблице по всем операциям.
     */
    public static function createbalanceConsider($operation, $user_id) {

        $is_income = User::getCategoryLabel($operation); // Метка, показывающая, это доход или расход
        $user      = User::where('id', '=', $user_id)->first(); // Получаем пользователя, совершившего операцию.

        /**
         * Если доход  - то прибавляем к главному балансу пользователя сумму.
         * Если расход - то отнимаем от главного баланса пользователя сумму.
         */
        if($is_income) {

            $current_balance = $user->budget + $operation->sum;
        } else {

            $current_balance = $user->budget - $operation->sum;
        }

        $operation->balance = $current_balance; // Сохраняем log операции

        $user->budget = $current_balance; // Обновляем главный баланс пользователя
        $operation->save();
        $user->save();

        return $current_balance;
    }

    /**
     * @var $operation    - Информация по операции, которая была залогирована.
     * @var $user_id      - ID текущего пользователя.
     * @var $newOperation - Новые данные для обновления.
     */
    public static function updateBalanceConsider($operation, $user_id, $newOperation) {

         // Возвращаем log балансу операции "начальное состояние", которое было еще ДО ее создания
        $is_income_old = User::getCategoryLabel($operation); // Метка, показывающая, это доход или расход операции который был раньше.
        $user          = User::where('id', '=', $user_id)->first(); // Получаем пользователя, совершившего операцию.
        $old_sum       = $operation->sum; // Переменная содержит прошлую сумму операции. Для сравнения, насколько изменился главный баланс пользователя.

        if($is_income_old) {

            $old_balance = $operation->balance - $operation->sum; // Получаем баланс, который был залогирован, на текущий момент
        } else {

            $old_balance = $operation->balance + $operation->sum; // Изменяем Log операции
        }
        $operation->balance = $old_balance; // Сохраняем log операции
        $operation->save();
        

        // Снова достаем эту же операцию, и теперь задаем ей новые значения
        $operation = Operation::where('id', '=', $operation->id)->first();
        $is_income = User::getCategoryLabel($newOperation); // Проверяем доход это или расход, при новых значениях
        if($is_income) {

            $current_balance = $operation->balance + $newOperation->sum; // Изменяем Log операции
            if($is_income_old) {

                $difference_value = $old_sum - $newOperation->sum;
            } else {

                $difference_value = $old_sum + $newOperation->sum;
            }

        } else {

            $current_balance = $operation->balance - $newOperation->sum; // Изменяем Log операции
            $recovery_value = $old_sum;
            if($is_income_old) {
                
                $difference_value = $old_sum + $newOperation->sum;
            } else {

                $difference_value = $old_sum - $newOperation->sum;
            }
        }
        
        $operation->balance = $current_balance;
        $user->budget = $user->budget + ($difference_value); // Не знаю как правильно сложить положительное и отрицательное число в PHP. Нужно потетстить.
        // Теперь пересчитаем общий баланс пользователя, с учетом изменившихся данных
        $operation->save();
        $user->save();

        return $operation;
    }

    public static function deleteBalanceConsider($operation, $user_id) {

        $is_income = User::getCategoryLabel($operation); // Метка, показывающая, это доход или расход операции который был раньше.
        $user      = User::where('id', '=', $user_id)->first(); // Получаем пользователя, совершившего операцию.

        if($is_income) {

            $user->budget = $user->budget - $operation->sum; // Получаем баланс, который был залогирован, на текущий момент
        } else {

            $user->budget = $user->budget + $operation->sum; // Изменяем Log операции
        }
        
        $operation->delete();
        $user->save();
    }
}