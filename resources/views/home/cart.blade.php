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
      <title>Artifacts Website</title>
      <!-- bootstrap core css -->
      <link rel="stylesheet" type="text/css" href="home/css/bootstrap.css" />
      <!-- font awesome style -->
      <link href="home/css/font-awesome.min.css" rel="stylesheet" />
      <!-- Custom styles for this template -->
      <link href="home/css/style.css" rel="stylesheet" />
      <!-- responsive style -->
      <link href="home/css/responsive.css" rel="stylesheet" />
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
      <style>
   .checkout-form {
      max-width: 500px;
      margin: 0 auto;
   }

   .checkout-form label {
      display: block;
      margin-bottom: 5px;
   }

   .checkout-form select,
   .checkout-form input[type="text"],
   .checkout-form input[type="email"],
   .checkout-form textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
      margin-bottom: 10px;
   }

   .checkout-form button {
      background-color: #4CAF50;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
   }

   .checkout-form button:hover {
      background-color: #45a049;
   }
</style>
   </head>
   <body>

   @if(session()->has('message'))

<div class='alert alert-success'>
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
    {{session()->get('message')}}
</div>
@endif

@if(session()->has('success'))

    <div class='alert alert-success'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
        {{session()->get('success')}}
    </div>
    @endif
     
         <!-- header section strats -->
         @include('home.header')
         <!-- end header section -->
         <!-- slider section -->
         
      
         <div class="cart-small-container">
    <form action="{{ route('cart.update') }}" method="POST">
        @csrf
        <table>
            <tr>
                <th>Product Details</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total Price</th>
                <th>Action</th>
            </tr>

            <?php $totalprice = 0; ?>

            @foreach($cart as $item)
            <tr>
                <td>
                    <div class="cart-page-info">
                        <img src="product/{{$item->image}}" alt="">
                        <div>
                            <p>{{$item->title}}</p>
                            <small>Price: Kes {{$item->price}}</small>
                            <a href="{{ url('/remove_cart',$item->id)}}" onclick="return confirm('Are you sure you want to remove the product?')">Remove</a>
                        </div>
                    </div>
                </td>

                <?php
                $itemTotal = $item->price * $item->quantity;
                $totalprice += $itemTotal;
                ?>

                <td>
                    <input type="number" name="quantity[]" value="{{$item->quantity}}">
                    <input type="hidden" name="itemId[]" value="{{$item->id}}">
                </td>
                <td>{{$item->price}}</td>
                <td>{{$itemTotal}}</td>
                <td><button type="submit" class='btn btn-success' name="update">Update Product</button></td>
            </tr>
            @endforeach
        </table>

        <div class="total-price">
            <table>
                <tr>
                    <td>Subtotal</td>
                    <td>{{$totalprice}}</td>
                </tr>
            </table>
        </div>
    </form>
</div>



    <a href="{{ route('checkout',$totalprice) }}" class='btn btn-success'>Place Order</a>

     
      
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