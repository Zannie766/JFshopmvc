<?php
// Mảng chứa danh sách sản phẩm
$products = [
    [
        'id' => 1,
        'name' => 'Sản phẩm 1',
        'description' => NULL,
        'price' => '100000.00',
        'stock' => 0,
        'image' => 'https://via.placeholder.com/150', // Sử dụng placeholder nếu không có ảnh
        'created_at' => '2025-05-11 23:51:38'
    ],
    [
        'id' => 2,
        'name' => 'Sản phẩm 2',
        'description' => NULL,
        'price' => '200000.00',
        'stock' => 0,
        'image' => 'Assets/Images/1.jpg',
        'created_at' => '2025-05-11 23:51:38'
    ],
    [
        'id' => 3,
        'name' => 'Sản phẩm 3',
        'description' => NULL,
        'price' => '300000.00',
        'stock' => 0,
        'image' => 'https://via.placeholder.com/150',
        'created_at' => '2025-05-11 23:51:38'
    ],
    [
        'id' => 4,
        'name' => 'Sản phẩm 4',
        'description' => NULL,
        'price' => '400000.00',
        'stock' => 0,
        'image' => 'https://via.placeholder.com/150',
        'created_at' => '2025-05-11 23:51:38'
    ]
];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Sản Phẩm</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .product-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
        .product-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 250px;
            padding: 15px;
            text-align: center;
            transition: transform 0.2s;
        }
        .product-card:hover {
            transform: translateY(-5px);
        }
        .product-card img {
            max-width: 100%;
            border-radius: 8px;
        }
        .product