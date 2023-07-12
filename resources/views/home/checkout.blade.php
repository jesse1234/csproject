<!DOCTYPE html>
<html>
   <head>
      <!-- Basic -->
      <base href='/public'>
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
<div class="checkout-form">
         <h2>Checkout Page</h2>
         <br>
         <form method="POST" action="{{ url('payments/mpesa/initiate',[$totalprice, 'user_id'=>auth()->id()]) }}">
    @csrf
    <input type="text" name="name" placeholder="Name" required>
    <br>
    <input type="text" name="phone" placeholder="Phone Number" required>
    <br>
    <input type="text" name="address" placeholder="Address" required>
    <br>
    <input type="text" name="region" placeholder="Region" required>

    <!-- Other form fields if necessary -->

    <button type="submit">Place Order</button>
</form>
      </div>
</body>
</html>




