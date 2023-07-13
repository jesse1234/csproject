<!DOCTYPE html>
<html>
   <head>
      <!-- Basic -->
      
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <!-- Mobile Metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <!-- Site Metas -->
      <meta name="keywords" content="" />
      <meta name="description" content="" />
      <meta name="author" content="" />
      <link rel="shortcut icon" href="images/favicon.png" type="">
      <title>Famms - Fashion HTML Template</title>
      <!-- bootstrap core css -->
      <link rel="stylesheet" type="text/css" href="{{asset('home/css/bootstrap.css')}}" />
      <!-- font awesome style -->
      <link href="{{asset('home/css/font-awesome.min.css')}}" rel="stylesheet" />
      <!-- Custom styles for this template -->
      <link href="{{asset('home/css/style.css')}}" rel="stylesheet" />
      <!-- responsive style -->
      <link href="{{asset('home/css/responsive.css')}}" rel="stylesheet" />
      <script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>
    <script nomodule src="https://unpkg.com/@google/model-viewer/dist/model-viewer-legacy.js"></script>
</head>
<body>


         <!-- header section strats -->
         @include('home.header')
         <!-- end header section -->
         <br>
<main class="container">
 
 <!-- Left Column /  Image -->
 <div id="aSide">
 <model-viewer src="/product/{{$product->image_3d}}" alt="Yoruba Mask" auto-rotate camera-controls ar ios-src="product/{{$product->image_3d}}" class='img'></model-viewer>   
 </div>


 <!-- Right Column -->
 <div class="right-column">

   <!-- Product Description -->
   <div class="product-description">
     <span>Product Details</span>
     <h1>{{$product->title}}</h1>
     <br>
     <p>{{$product->description}}</p>
     <br>
     <p>Stock: {{$product->stock}}</p>
</div>

     

     

   <!-- Product Pricing -->
   <div class="product-price">
   @if($product->discount_price != null)
            
            <span>Kes. {{$product->discount_price}}</span>
                        
                        @else
                        
                        <span>Kes. {{$product->price}}</span>
                     @endif
     <a href="#" class="cart-btn">Add to cart</a>
   </div>
 </div>
</main>

      
      <!-- jQery -->
      <script src="home/js/jquery-3.4.1.min.js"></script>
      <!-- popper js -->
      <script src="home/js/popper.min.js"></script>
      <!-- bootstrap js -->
      <script src="home/js/bootstrap.js"></script>
      <!-- custom js -->
      <script src="home/js/custom.js"></script>
   </body>
</html>
