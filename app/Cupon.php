<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Cupon extends Model
{
    public static function findByCode($code){
        return self::where('code', $code) -> first();
    }

    public function discount($total){
        if($this->type == 'fixed'){

            return $this->value;

        } elseif ($this->type == 'percent'){

            return round((($this->percent_off / 100) * $total),2);

        } else {

            return 0;

        }
    }
}
