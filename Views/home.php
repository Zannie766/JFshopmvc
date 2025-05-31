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
<body>
        <!--home section starts-->
 <section class="home" id="home">
    <div class="content">
     
  </div>
  
      </section>
      
      <!--home section ends-->
  
     <!--about section starts-->
     
     <section class="about" id="about">
      <h1 class="heading"><span> About </span>Us</h1>
    <div class="row">
      <div class="video-container">
      <img src="<?= $base ?>assets/Images/8.webp" alt="">
  <h3>best Teddy sellers</h3>
      </div>
      <div class="content">
          <h3>why choose us?</h3>
          <p>orem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus aliquet semper dui, vitae tincidunt dolor facilisis id. Nullam ac aliquet nulla.</p>
          <p>orem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus aliquet semper dui, vitae tincidunt dolor facilisis id. Nullam ac aliquet nulla.</p>
          <a href="#" class="btn">learn more</a>  
      </div>
    </div>
     </section>
     <!--about section ends-->
  
     <!--icons section starts-->
  <section class="icons-container">
      <div class="icon-box">
          <i class="fas fa-truck"></i>
              <p> free delivery</p>
      <p class="subtext">On All Orders</p>
          </div>
          <div class="icon-box">
              <i class="fas fa-money-bill-wave"></i>
                  <p> moneyback garantee</p>
                  <p class="subtext">10 days returns</p>
              </div>
              <div class="icon-box">
                  <i class="fas fa-gift"></i>
                      <p> offer & gifts</p>
                      <p class="subtext">on all orders</p>
                  </div>
                  <div class="icon-box">
                      <i class="fas fa-credit-card"></i>
                          <p> secure payments</p>
                          <p class="subtext">protected by paypal</p>
                      </div>
                      
      </div>
  </section>
  
  
  
     <!--icons section ends-->
  
     <!--products section starts-->
      <!-- Products section -->
    <section class="products" id="products">
        <h1 class="heading">Latest <span>Products</span></h1>
        <div class="product-container">
        <?php if (empty($productList)): ?>

            <?php else: ?>
                <?php foreach ($productList as $product): ?>
                    <div class="product-item">
                        <img src="<?=$assets . $product['image'] ?>" alt="">
                        <div class="product-name"><?= htmlspecialchars($product['name']) ?></div>
                        <div class="price">$<?= htmlspecialchars(number_format($product['price'], 2)) ?></div>
                        <a href="#" class="fas fa-heart"></a>
                        <form action="<?= $baseURL ?>cart/add" method="post">
                              <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                              <button type="submit" class="btn btn-default add-to-cart">
                                <i class="fa fa-shopping-cart"></i> Thêm vào giỏ
                              </button>
                            </form>
                        <a href="#" class="fas fa-share"></a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
  
             
   
   <!--products section ends-->
<!--Review section starts-->
<!--Review section starts-->
<section class="review" id="review">
    <h1 class="heading">Customer's <span>Review</span></h1>
    <div class="box-container">
      
      <div class="box">
        <div class="stars">
          <i class="fas fa-star" style="color: #e84393;"></i>
          <i class="fas fa-star" style="color: #e84393;"></i>
          <i class="fas fa-star" style="color: #e84393;"></i>
          <i class="fas fa-star" style="color: #e84393;"></i>
          <i class="fas fa-star" style="color: #e84393;"></i>
        </div>
        <p>Lorem Ipsum Dolor Sit Amet Consectetur Adipisicing Elit. Corrupti Asperiores Laboriosam Praesentium Enim Maiores? Ad Repellat Voluptates Alias Facere Repudiandae Dolor Accusamus Enim Ut Odit, Aliquam Nesciunt Eaque Nulla Dignissimos.</p>
        <div class="user">
          <img src="<?= $base ?>assets/Images/4.jpg" alt="">
          <div class="user-info">
            <h3>Cá rô</h3>
            <span>Legit Customer</span>
          </div>
        </div>
      </div>
  
      <div class="box">
        <div class="stars">
          <i class="fas fa-star" style="color: #e84393;"></i>
          <i class="fas fa-star" style="color: #e84393;"></i>
          <i class="fas fa-star" style="color: #e84393;"></i>
          <i class="fas fa-star" style="color: #e84393;"></i>
          <i class="fas fa-star" style="color: #e84393;"></i>
        </div>
        <p>Lorem Ipsum Dolor Sit Amet Consectetur Adipisicing Elit. Corrupti Asperiores Laboriosam Praesentium Enim Maiores? Ad Repellat Voluptates Alias Facere Repudiandae Dolor Accusamus Enim Ut Odit, Aliquam Nesciunt Eaque Nulla Dignissimos.</p>
        <div class="user">
          <img src="<?= $base ?>assets/Images/5.jpg" alt="">
          <div class="user-info">
            <h3>Nước lèo vị sữa</h3>
            <span>Normal Customer</span>
          </div>
        </div>
      </div>
  
      <div class="box">
        <div class="stars">
          <i class="fas fa-star" style="color: #e84393;"></i>
          <i class="fas fa-star" style="color: #e84393;"></i>
          <i class="fas fa-star" style="color: #e84393;"></i>
          <i class="fas fa-star" style="color: #e84393;"></i>
          <i class="fas fa-star" style="color: #e84393;"></i>
        </div>
        <p>Lorem Ipsum Dolor Sit Amet Consectetur Adipisicing Elit. Corrupti Asperiores Laboriosam Praesentium Enim Maiores? Ad Repellat Voluptates Alias Facere Repudiandae Dolor Accusamus Enim Ut Odit, Aliquam Nesciunt Eaque Nulla Dignissimos.</p>
        <div class="user">
          <img src="<?= $base ?>assets/Images/6.jpg" alt="">
          <div class="user-info">
            <h3>Minh Hạnh</h3>
            <span>VIP Customer</span>
          </div>
        </div>
      </div>
  
    </div>
  </section>
  <!--Review section ends-->
  

<!--Review section ends-->

     <script src="<?= $base ?>Assets/js/scripts.js"></script>
</body>
</html>