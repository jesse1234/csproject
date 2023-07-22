<section class="product_section layout_padding">
         <div class="container">
            <div class="heading_container heading_center">
              

               <div>
                  <form action="{{url('search_product')}}" method='get'>
                     @csrf
                     <input style='width:500px;' type="text" name = 'search' placeholder='Search For Products'>
                     <input type="submit" value='Search' >
                  </form>
               </div>
            </div>
            
            <div class="row">
            @foreach($product as $products)
               <div class="col-sm-6 col-md-4 col-lg-4">
                  
                  <div class="box">
                  
                     <div class="option_container">
                        <div class="options">
                           <a href="{{ url('product_details',$products->id) }}" class="option1">
                           Details
                           </a>
                           
                           <form action="{{ route('add_to_cart',$products->id) }}" method='POST'>
                              @csrf
                              
                              </div>
                           </form>

                        </div>
                     </div>
                     <div class="img-box">
                        <img src="product/{{$products->image}}" alt="">
                     </div>
                     <div class="detail-box">
                        <h5>
                          {{$products->title}}
                        </h5>

                        @if($products->discount_price !=null)
                        <h6 style='color:red;'>
                        Discount Price
                        <br>
                           Ksh {{$products->discount_price}}
                        </h6>

                        <h6 style ='text-decoration: line-through; color:blue;'>
                         Price
                        <br>
            
                           Ksh {{$products->price}}
                        </h6>

                        @else

                        <h6 style ='color:blue;'>
                         Price
                        <br>
                           Ksh {{$products->price}}
                        </h6>


                        @endif
                        
                     </div>
                  </div>
               </div>
               
        
            @endforeach

            {!! $product->withQueryString()->links('pagination::bootstrap-5') !!}
            

            
         </div>
      </section>