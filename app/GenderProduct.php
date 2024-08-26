<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GenderProduct extends Model
{
    protected $table = 'gender_product';

    protected $fillable = ['product_id','gender_id'];
}
