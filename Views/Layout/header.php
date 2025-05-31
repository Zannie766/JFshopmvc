<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$config = require 'config.php';
$base = $config['base'];
$baseURL = $config['baseURL'];
$assets = $config['assets'];

?>
<!DOCTYPE html>
<html lang="eng">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width-device-width, initial-scale=1.0">
        <title>JellyFish website</title>
        <link rel="stylesheet" href="<?= $base ?>Assets/css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    </head>
   
 <header>
    <input type="checkbox" name="" id="toggler">
  <label for="toggler" class="fas fa-bars"></label>
    <a href="#" class="logo">JellyFish<span>.</span></a>
 <nav class="navbar">
    <a href="#home">Home</a>
    <a href="#about">About</a>
    <a href="#products">Products</a>
    <a href="#review">Review</a>
  

 </nav>
 <div class="icons">
 <a href="<?=$base?>admin/index" class="fa-brands fa-bluesky"></a>
  <a href="#" class="fas fa-heart"></a>
  <a href="<?= $base?>cart/index"><i class="fas fa-shopping-cart"></i></a>
  <a href="<?=$base?>User/register"><i class="fas fa-user"></i></a>
</div>

</header>       