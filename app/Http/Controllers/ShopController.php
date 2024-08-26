<?php

namespace App\Http\Controllers;

use App\Category;
use App\Gender;
use App\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pagination = 30;
        $categories = Category::all()->sortBy('category');
        $genders = Gender::all();
        //Side bar + header
        if (request()->category) {
            $products = Product::with('categories')->whereHas('categories', function ($query) {
                $query->where('category_slug', request()->category);
            });
            $categoryName = optional($categories->where('category_slug', request()->category)->first())->category;

        } else {
            $products = Product::take(30);
            $categoryName = 'OBLEČENIE:';
        }

        //Sort low_high|high_low
        if (request()->sort == 'low_high') {
            $products = $products->orderBy('product_price')->paginate($pagination);
        } elseif (request()->sort == 'high_low') {
            $products = $products->orderBy('product_price','desc')->paginate($pagination);
        } else {
            $products = $products->paginate($pagination);
        }

        return view('shop')->with([
            'products' => $products,
            'categories' => $categories,
            'categoryName' => $categoryName,
            'genders' => $genders
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $product = Product::where('slug',$slug)->firstOrFail();
        $mightAlsoLike = Product::where('slug','!=',$slug)->mightAlsoLike()->get();

        $stockLevel = getStockLevel($product -> product_quantity);

        return view('product')->with([
            'product'=>$product,
            'stockLevel'=>$stockLevel,
            'mightAlsoLike'=>$mightAlsoLike,
        ]);

    }
    public function search(Request $request)
    {
        $this->validate(
            $request,
            [
                'query' => 'required|min:3',
            ],
            [
                'query.required' => 'Prosím zadajte aspoň 3 znaky.',
                'query.min'      => 'Prosím zadajte aspoň 3 znaky.',
            ]
        );


        $query = $request->input('query');

        $products = Product::search($query)->paginate(10);

        return view('search-results')->with([
            'products'=>$products,
        ]);
    }

    public function searchAlgolia(Request $request)
    {

        return view('search-results-algolia');
    }
}
