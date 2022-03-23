<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAllProducts()
    {
        return Product::all();
    }

    public function getProductById($productId)
    {
        return Product::find($productId);
    }

    public function createProduct($details)
    {
        return Product::create([
            'name' => $details['name'],
            'slug' => $details['slug'],
            'description' => $details['description'],
            'price' => $details['price'],
        ]);
    }

    public function updateProduct($productId, $newDetails)
    {
        $product = Product::find($productId);
        $product->update($newDetails);
        return $product;
    }

    public function deleteProduct($productId)
    {
        return Product::destroy($productId);
    }

    public function searchProductByName($name)
    {
        return Product::where('name', 'like', '%'.$name.'%')->get();
    }
}
