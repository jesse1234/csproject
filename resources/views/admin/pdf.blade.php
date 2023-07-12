<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order PDF</title>

</head>
<body>
    <h1>Order Details</h1>

    Customer Name: <h3>{{$order->name}}</h3>
    Customer Email:<h3>{{$order->email}}</h3>
    Customer Address: <h3>{{$order->address}}</h3>
    Region: <h3>{{$order->region}}</h3>
    User ID: <h3>{{$order->user_id}}</h3>
    <br><br>
    <img src="product/{{$order->image}}" alt="" height='150' width='150'>
    Product Title:<h3>Product Title:{{$order->product_title}}</h3>
    <!-- <h3>{{$order->quantity}}</h3> -->
    Product ID:<h3>{{$order->product_id}}</h3>
    Payment Status:<h3> Paid</h3>


    
</body>
</html>