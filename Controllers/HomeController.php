<?php
require_once __DIR__ . '/../Models/ProductModel.php';
class HomeController
{
    public function index()
    {
        $product = new ProductModel();
        $productList = $product->getAllProducts();
         include 'App/Views/home.php';
    }
}
