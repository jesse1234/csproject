<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='{{asset("css/app.css")}}'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <meta name='csrf-token' content='{{ csrf_token() }}'>
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="row mt-5">
            <div class="col-sm-8 mx-auto">
                <div class="card">
                
                    <div class="card-header">
                    STK Transction
                    </div>
                <div class="card-body">
                    <div id='stk_response'></div>
                    <form action="">
                        @csrf
                        <div class="form-group">
                            <label for="phone_number">Phone Number</label>
                            <input type="number" name='phone' id='phone'>
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" name='amount' id='amount'>
                        </div>
                        <div class="form-group">
                            <label for="account">Account</label>
                            <input type="text" name='account' id='account'>
                        </div>
                    
                    <button class='btn btn-primary' id='stkpush'>Simulate STK</button>
                    </form>    
                </div>
                </div>

                
        
        </div>
    </div>
</body>

<script src='{{asset("js/app.js")}}'></script>
<script>
//     document.getElementById('getAccessToken').addEventListener('click',(event)=> {
//     event.preventDefault()

//     axios.post('/get-token',{})
//     .then((response) =>{
//         console.log(response.data);  
//         document.getElementById('access_token').innerHTML = response.data  
//     })
//     .catch((error) =>{
//         console.log(error);
//     })
// });



document.getElementById('stkpush').addEventListener('click',(event)=>{
   event.preventDefault()
   
   const requestBody = {
amount: document.getElementById('amount').value,
account: document.getElementById('account').value,
phone: document.getElementById('phone').value
   }

   axios.post('/stkpush', requestBody)
   .then((response) => {

    if(response.data.RespnseDescription){
        document.getElementById('stk_response').innerHTML = response.data.RespnseDescription
    }
    else{
        document.getElementById('stk_response').innerHTML = response.data.errorMessage 
    }
   })
   .catch((error) => {
    console.log(error);
   })
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</html>