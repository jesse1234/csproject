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
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
     
      <style>
   

   .checkout-form label {
      font-size:12px;
      font-weight: 700;
   }

   .checkout-form input {
      font-size:14px;
      padding:5px;
      font-weight: 400;
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
      <div class="container mt-5">
         <form action="{{url('payments/mpesa/initiate', ['cart_total'=>$totalprice, 'user_id'=>auth()->id()])}}" method = 'POST'>
         @csrf
         <div class="row">
            <div class="col-md-7">
               <div class="card">
                  <div class="card-body">
                     <h6>Basic Details</h6>
                     <br>
                     <div class="row checkout-form">
                        <div class="col-md-6">
                           <label for="fullname">Full Name</label>
                           <input type="text" class='form-control name' value = "{{ Auth::user()->name }}" placeholder='Enter Full Name' name='name'>
                           
                           <span id='nameError' class=' text-danger'></span>
                        </div>
                        
                        <div class="col-md-6">
                           <label for="fullname">Email</label>
                           <input type="email" class='form-control email' value = "{{ Auth::user()->email }}" placeholder='Enter Full Name' name='email'>
                           <span id='emailError' class=' text-danger'></span>
                        </div>
                        <div class="col-md-6">
                           <label for="phone">Phone Number</label>
                           <input type="text" class='form-control phone' value = "{{ Auth::user()->phone }}" placeholder='Enter Full Name' name='phone'>
                           <span id='phoneError' class=' text-danger'></span>
                        </div>
                        <div class="col-md-6">
                           <label for="address">Address</label>
                           <input type="text" class='form-control address' value = "{{ Auth::user()->address }}" placeholder='Enter Full Name' name='address'>
                           <span id='addressError' class=' text-danger'></span>
                        </div>
                        <div class="col-md-6">
                           <label for="region">Region</label>
                           <input type="text" class='form-control region' value = "{{ Auth::user()->region }}" placeholder='Enter Full Name' name='region'>
                           <span id='regionError' class=' text-danger'></span>
                        </div>
                        <div class="col-md-6">
                           <label for="state">State</label>
                           <input type="text" class='form-control state' value = "{{ Auth::user()->state }}" placeholder='Enter Full Name' name='state'>
                           <span id='stateError' class=' text-danger'></span>
                        </div>
                        <div class="col-md-6">
                           <label for="zip-code">Zip Code</label>
                           <input type="text" class='form-control zip_code' value = "{{ Auth::user()->zip_code }}" placeholder='Enter Full Name' name='zip_code'>
                           <span id='zip_codeError' class=' text-danger'></span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="col-md-5">
               <div class="card">
                  <div class="card-body">
                     <h6>Order Details</h6>
                     <br>
                     @foreach($cartItems as $item)
                     <table class="table table-striped table-bordered">
                        <thead>
                           <tr>
                              <th>Product Title</th>
                              <th>Quantity</th>
                              <th>Price</th>
                              <th>Total Price</th>
                           </tr>
                        </thead>
            
                        <tbody>
                           <tr>
                              <td>{{ $item->products->title }}</td>
                              <td>{{ $item->quantity }}</td>

                              @if( $item->products->total_price != null)
                              <td>{{ $item->products->price}}</td>
                              @else
                              <td>{{ $item->products->discount_price}}</td>
                              @endif
                              <td>{{$totalprice}}</td>
                           </tr>
                           @endforeach 
                        </tbody>
                     </table>
                        <hr>
                     <button  type='submit' class='btn btn-primary float-end w-100'>Lipa na M-Pesa</button>
                  </div>
               </div>
            </div>

         </div>
         </form>
      </div>





</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
   $(document).ready(function (){
      $('.mpesa_btn').click(function(e) {
         e.preventDefault();

         var name = $('.name').val();
         var email = $('.email').val();
         var phone = $('.phone').val();
         var address = $('.address').val();
         var region = $('.region').val();
         var state = $('.state').val();
         var zip_code = $('.zip_code').val();

         if(!name)
         {
            name_error = 'First name required';
            $('#nameError').text('');
            $('#nameError').text(name_error);
         }
         else
         {
            name_error = '';
            $('#nameError').text('');
         }

         if(!email)
         {
            email_error = 'Email required';
            $('#emailError').text('');
            $('#emailError').text(email_error);
         }
         else
         {
            email_error = '';
            $('#emailError').text('');
         }

         if(!phone)
         {
            phone_error = 'Phone required';
            $('#phoneError').text('');
            $('#phoneError').text(phone_error);
         }
         else
         {
            phone_error = '';
            $('#phoneError').text('');
         }

         if(!address)
         {
            address_error = 'Address required';
            $('#addressError').text('');
            $('#addressError').text(address_error);
         }
         else
         {
            address_error = '';
            $('#addressError').text('');
         }

         if(!region)
         {
            region_error = 'Region required';
            $('#regionError').text('');
            $('#regionError').text(region_error);
         }
         else
         {
            region_error = '';
            $('#regionError').text('');
         }
         
         if(!state)
         {
            state_error = 'State required';
            $('#stateError').text('');
            $('#stateError').text(state_error);
         }
         else
         {
            state_error = '';
            $('#stateError').text('');
         }

         if(!zip_code)
         {
            zip_code_error = 'Zip code required';
            $('#zip_codeError').text('');
            $('#zip_codeError').text(zip_code_error);
         }
         else
         {
            zip_code_error = '';
            $('#zip_codeError').text('');
         }

         if(name_error != '' || email_error != '' || address_error != '' || phone_error != '' || region_error != '' || state_error != '' || zip_code_error != '')
         {
            return false;
         }
         else
         {

         }
      });
   }); 
</script>
</html>



