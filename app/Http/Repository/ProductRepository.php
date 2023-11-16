<?php

namespace App\Http\Repository;

use App\Models\Product;

class ProductRepository{

    public static function paginateAdminData($keyword = '', $filterBy = null, $count = 20){

        $products = Product::where(function ($query) use ($keyword){
            $query->where('description', 'LIKE', '%'. $keyword .'%')
            ->orWhere('name', 'LIKE', '%'. $keyword .'%');
        });

        if($filterBy){
            $products = $products->where('category_id', $filterBy);
        }

        return $products->with('category')->orderBy('created_at', 'DESC')->paginate($count);
    }

    
}