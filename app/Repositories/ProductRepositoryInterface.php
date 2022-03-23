<?php

namespace App\Repositories;

interface ProductRepositoryInterface
{
    public function getAllProducts();
    public function getProductById($productId);
    public function createProduct($details);
    public function updateProduct($productId, $newDetails);
    public function deleteProduct($productId);
    public function searchProductByName($productName);
}
