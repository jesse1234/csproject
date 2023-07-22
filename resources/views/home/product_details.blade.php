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
      <meta name="csrf-token" content="{{ csrf_token() }}">
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
@include('sweetalert::alert')
@if(session()->has('info'))

<div class='alert alert-danger'>
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
    {{session()->get('info')}}
</div>
@endif

@if(session()->has('success'))

<div class='alert alert-danger'>
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
    {{session()->get('success')}}
</div>
@endif


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
   <div class="product-description product_data">
     <span>Product Details</span>
     <h1>{{$product->title}}</h1>
     <br>
     <p>{{$product->description}}</p>
     <br>
     @if($product->stock >0)
      <label class='badge bg-success' style='color:white;'>In stock</label>
     @else
      <label class="badge bg-danger" style='color:white;'>Out Of Stock</label>
   
     @endif
     <br>
     <p>Available Quantity: {{$product->stock}}</p>
     


     

     

   <!-- Product Pricing -->
   <div class="product-price">
   @if($product->discount_price != null)
            
            <span>Kes. {{$product->discount_price}}</span>
                        
                        @else
                        
                        <span>Kes. {{$product->price}}</span>
                     @endif

         
   </div>
   <br>
   
                              <div class='row mt-2'>
                                 <div class='col-md-2'>
                                    <div class='input-group text-center mb-3'>
                                    <input type="hidden" value='{{$product->id}}' class='prod_id'>
                                       <label for="quantity">Quantity</label>
                                       <span class=''>-</span>
                                       <input type="number" name='quantity' value='1' min=1 max='10' class='form-control qty-input text-center' style='width:50px;'>
                    

                                    </div>
                                    <br>
                                    @if($product->stock >0)
                                    <input type="submit" value='Add to Cart' class='btn btn-outline-success me-3 addToCartBtn float-start'>
                                 @else
                                    
                                    </div>
                                 @endif
                                 
                              </div>
                              </div>
                 
 </div>
</main>

      
    <!-- jQery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.addToCartBtn').click(function(e) {
            e.preventDefault();

            var product_id = $(this).closest('.product_data').find('.prod_id').val();
            var product_qty = $(this).closest('.product_data').find('.qty-input').val();

            $.ajaxSetup({
               headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
            });
            // Send an AJAX request to add the product to the cart
            $.ajax({
                url: '{{ url("add_to_cart_table") }}',
                method: 'POST',
                data: {
                    'product_id': product_id,
                    'product_qty': product_qty,
                },
                success: function (response)
                {
                  alert(response.status)
                }
            });
           
            });
        
        
        });
</script>
      <!-- jQery -->
      <!-- jQery -->
      <script src="{{asset('home/js/jquery-3.4.1.min.js')}}"></script>
      <!-- popper js -->
      <script src="{{asset('home/js/popper.min.js')}}"></script>
      <!-- bootstrap js -->
      <script src="{{asset('home/js/bootstrap.js')}}"></script>
      <!-- custom js -->
      <script src="{{asset('home/js/custom.js')}}"></script>
   </body>
</html>
