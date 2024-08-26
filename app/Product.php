<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Nicolaslopezj\Searchable\SearchableTrait;


class Product extends Model
{
    use SearchableTrait, Searchable;

    protected $fillable = ['product_quantity'];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'products.product_name' => 10,
            'products.product_size' => 5,
            'products.product_color' => 5,
            'products.product_details' => 2,
            'products.genders' => 6,
            'products.categories' => 6,
            'products.product_price' => 6,



        ],
    ];

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    public function genders()
    {
        return $this->belongsToMany('App\Gender');
    }

    public function scopeMightAlsoLike($query)
    {
        return $query->inRandomOrder()->take(4);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        $extraFields = [
            'categories' => $this->categories->pluck('category')->toArray(),
            'genders' => $this->genders->pluck('name')->toArray(),
        ];

        return array_merge($array, $extraFields);
    }
}
