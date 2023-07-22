

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

body{
    padding:0;
    width:100%;
    font-size:16px;
    font-weight: 300;
    margin: 0;
    font-family: 'Roboto Condensed', sans-serif;
}

h2, h4, p{
    margin:0;
}

.page_1{
    background: #fff;
    display:block;
    margin: 3rem auto 3rem auto;
    position: relative;
    box-shadow: 0 0 5px rgba(0,0,0,0.1);
}

.page_1[size = 'A4']{
    width:21cm;
    height:29.7cm;
    overflow-x: hidden;
}

/* Header Section */
.top_section{
    color: #fff;
    padding: 20px;
    height: 115px;
    background-color: gray;
}

.top_section h2{
    font-size:42px;
    margin-bottom:10px;
    font-weight: 400;
}

.top_section .address{
    width: 50%;
    height: 100%;
    float: left;
}

.top_section .address_content{
    max-width: 275px;
}

.contact .contact_content{
    max-width: 220px;
    float:right;
    margin-top: 32px;
}

.contact_content .email, .contact_content .numbers{
    display:block;
}

.contact_content .email span, .contact_content .numbers span{
    float: right;
    margin-left:30px;
}

.billing_invoice .title{
    font-weight:400;
    float: left;
} 

.billing_invoice{
    padding: 20px;
    font-size:20px;
    margin-bottom:15px;
}


.billed_to{
    padding:20px;
    margin-top:40px;
}

.billed_to .title{
    font-weight:400;
    font-size:20px;
    margin-bottom:7px;
}

.billed_to .billed_section{
    width:50%;
    float:left;
    font-size:18px;
    margin-bottom:25px;
}

/* Invoice Table */
.table{
    padding: 0 20px;
}

.table table{
    width:100%;
}

.table table,th, td {
    padding: 5px;
    text-align:center;
    border:1px solid gray;
    border-collapse: collapse;
}

.table tr th{
    font-size: 18px;
    font-weight:400;
}

.table tr:first-child{
    color:#fff;
    background-color: grey;
}

.table tr th:nth-child(2), .table tr td:nth-child(2){
    text-align: left;
    width:230px;
}

/* Bottom Section */
.bottom_section{
    margin-top:15px;
    padding:20px;
    position:absolute;
    bottom:0;
    left:0;
    right:0;
}

.bottom_section .status_content h4{
    font-size:22px;
    font-weight:700;
    margin-bottom:10px;
}

.bottom_section .status.free::before, .bottom_section .status.paid::before{
    padding: 5px;
    border-radius: 5px;
    margin-bottom:8px;
    display:inline-block;
    text-transform: uppercase;
}
</style>

    <title>Invoice</title>
</head>
<body>
    <div class="page_1" size = "A4">
        <div class="top_section">
            <div class="address">
                <div class="address_content">
                    <h2>Artifact Inc.</h2>
                    
                </div>
            </div>
            <div class="contact">
                <div class="contact_content">
                    
                </div>
            </div>
        </div>
        <div class="billing_invoice">
            <div class="title">
                Billing Invoice
                <br>
                <div class="name">
                <p>Customer Name: {{$order->name}}</p>
                <p>User ID: {{$order->user_id}}</p>
                <p>Email address: {{$order->email}}</p>
                <p>Region: {{$order->region}}</p>
                </div>
            </div>
        </div>
        <br><br>


       
        
        <div class="billed_to">
            <div class="title">Billed To</div>
            <div class="billed_section">
                <div class="name">
                </div>
                
            </div>
        </div>
        

        <div class="table">
          
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Title</th>
                <th>Product ID</th>
                
                <th>Total Price</th>
                <th>Payment Status</th>
            </tr>
            <tr>
                <td>{{$order->id}}</td>
                <td>{{$order->name}}</td>
                <td>{{$order->products->title}}</td>
                <td>{{$order->product_id}}</td>
                
                <td>{{$order->total_price}}</td>
                <td> Paid </td>
            </tr>
        </table>
    </div>

    
    
                 
                        

                   

</body>
</html>