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
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

      <style>
        .order-details label{
            font-size:16px;
            font-weight:700;
        }

        .order-details div{
            font-size:14px;
            padding:5px;
        }
      </style>
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
         
      <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h4 class="text-white">Order View
                            
                        </h4>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 order-details">
                                <h4>Shipping Details</h4>
                                <br>
                                <hr>
                                <label for="">First Name</label>
                                <div class="border p-2">{{ $orders->name}}</div>
                                <label for="">Email</label>
                                <div class="border p-2">{{ $orders->email}}</div>
                                <label for="">Address</label>
                                <div class="border p-2">{{ $orders->address}}</div>
                                <label for="">Phone</label>
                                <div class="border p-2">{{ $orders->phone}}</div>
                                <label for="">State</label>
                                <div class="border p-2">{{ $orders->state}}</div>
                                <label for="">Zip Code</label>
                                <div class="border p-2">{{ $orders->zip_code}}</div>
                                <label for="">Region</label>
                                <div class="border p-2">{{ $orders->region}}</div>
                            </div>
                            <div class="col-md-6">
                            <h4>Order Details</h4>
                            <br>
                                <hr>
                            <table class="table table-bordered">
                    <thead>
                        <tr>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Image</th>
                        </tr>   
                    </thead>
                    
                    <tbody>
                    @foreach($orders->orderitems as $item)
                        <tr>
                          <td>{{ $item->products->title}}</td>
                          <td>{{ $item->quantity}}</td>
                          <td>{{ $item->price}}</td>

                          <td>
                            <img src="{{asset('product/'.$item->products->image) }}" alt="">
                        </td>
                        
                        </tr>
                        @endforeach    
                    </tbody>
                    
</table>
                    <h4 class='px-2'>Grand Total: <span class='float-end'>{{ $orders->total_price}}</span></h4>
                            </div>
                        </div>
                    </div>

                    </div>
                </div>
               
            </div>
        </div>
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
                  swal(response.status)
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
      <script src="home/js/jquery-3.4.1.min.js"></script>
      <!-- popper js -->
      <script src="home/js/popper.min.js"></script>
      <!-- bootstrap js -->
      <script src="home/js/bootstrap.js"></script>
      <!-- custom js -->
      <script src="home/js/custom.js"></script>
   </body>
</html>