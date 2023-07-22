!DOCTYPE html>
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
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

   </head>
   <body>
   @include('sweetalert::alert')
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
        
            <table>
                <tr>
                    <th>Product Details</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total Price</th>
                
                </tr>

                <?php $totalprice = 0; ?>

                @foreach($cart as $item)
                <div class = 'container '>
                    <tr>
                        <td>
                            <div class="cart-page-info">
                                <img src="{{ asset('product/'.$item->products->image )}}" alt="">
                                <div>
                                    <p>{{$item->products->title}}</p>
                                    <small>Price: Kes {{$item->products->price}}</small>
                                    <a href="{{ url('/remove_cart',$item->id)}}" onclick="confirmation(event)">Remove</a>
                                </div>
                            </div>
                        </td>

                        <?php

                        if($item->products->discount_price != null)
                        $itemTotal = $item->products->discount_price * $item->quantity;
                        else
                        $itemTotal = $item->products->price * $item->quantity;
                    
                        $totalprice += $itemTotal;
                        
                        ?>

                        <td>
                        <div class="input-group text-center mb-3 product_data" style="width: 120px;">
                        @if($item->products->stock >= $item->quantity)
                        <input type="hidden" class='prod_id' value='{{$item->product_id}}'>
                            <button class="input-group-text changeQuantity decrement-btn">-</button>
                            <input type="text" name="quantity" value="{{$item->quantity}}" class="form-control qty-input text-center" >  
                            <button class="input-group-text changeQuantity increment-btn">+</button>
                            
                          
                        </div>
                         
                        </td>

                        @if($item->products->discount_price != null)
                            <td>{{$item->products->discount_price}}</td>
                        @else
                            <td>{{$item->products->price}}</td>
                        @endif

                        
                        <td>{{$itemTotal}}</td>
                        @else
                        <td>Out of Stock</td>
                        @endif 
                        
                    </tr>
                </div>
                
                @endforeach
            </table>

            <div class="total-price">
                <table>
                    <tr>
                        <td>Subtotal</td>
                        <td>Kes. {{$totalprice}}</td>
                    </tr>
                    
                </table>
                <br>
                
            </div>
            <a href='{{url("checkout_details",$totalprice) }}' class='btn btn-outline-success float-end'>Proceed to Checkout</a>
        </div>
         


     
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.increment-btn').click(function(e) {
            e.preventDefault();
            // var inc_value = $('.qty-input').val();
            var inc_value = $(this).closest('.product_data').find('.qty-input').val();
            var value = parseInt(inc_value,10);
            value = isNaN(value) ? 0: value;
            if(value < 10)
            {
                value++;
                $(this).closest('.product_data').find('.qty-input').val(value);
            }
        });

        $('.decrement-btn').click(function(e) {
            e.preventDefault();
            var dec_value = $(this).closest('.product_data').find('.qty-input').val();
            var value = parseInt(dec_value,10);
            value = isNaN(value) ? 0: value;
            if(value > 1)
            {
                value--;
                $(this).closest('.product_data').find('.qty-input').val(value);

            }
        });



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

        $('.changeQuantity').click(function(e){
            e.preventDefault();

            var prod_id = $(this).closest('.product_data').find('.prod_id').val();
            var qty = $(this).closest('.product_data').find('.qty-input').val();
            data = {
                    'product_id': prod_id,
                    'quantity' : qty,
                }
                $.ajaxSetup({
               headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
            });
            $.ajax({
                    method:'POST',
                    url:'{{ url("update-cart") }}',
                    data:data,            
                    success: function (response)
                    {
                        window.location.reload();
                    }
                });
        });

    });
</script>

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
