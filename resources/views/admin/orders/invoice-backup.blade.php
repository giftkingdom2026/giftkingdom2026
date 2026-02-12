<!DOCTYPE html>
<html>
<head>
 <title>Inovice</title>
</head>

<style>
.wrapper.wrapper2{
  display: block;
}
.wrapper{
  display: none;
}
</style>
<body onload="window.print();">
<table style="width: 100%;; margin:0 auto; background:#fff;border-spacing: 0;font-family: 'Arial', sans-serif;">
        <thead>
            <tr>
                <th style="text-align: center; padding-bottom: 20px;">
                    <img style="width:32%;margin: auto;display: block;" src="{{asset('/')}}assets/images/bling_logo.png">
                </th>
            </tr>
        </thead>
        <tbody>
            <tr style="background-color: #fae4df;">
                <td>
                    @if(isset($data['orders_data'][0]->customer))
                    <h2 style="text-align: center; font-weight: 500;font-size: 22px">Dear {{$data['orders_data'][0]->customer->first_name}}</h2>
                    @else
                    <h2 style="text-align: center;font-weight: 500;font-size: 22px">Dear {{$data['orders_data'][0]->delivery_name}}</h2>
                    @endif
                    <p style="text-align: center;line-height: 1.4;">Thank you for choosing Blingblingsabaya, your Trusted Online Shop for Pre-owned Luxury Goods!
                    </p>
                </td>
            </tr>
            <tr>
                <td><h2 style="text-align:center;">Tax Invoice</h2></td>
            </tr>
            <tr>
                <td style="padding: 0 175px;">
                    <ul style="list-style-type: none; padding: 0; margin: 20px 0;">
                        <li style="margin-bottom: 10px">Invoice Number: <span>{{$data['orders_data'][0]->invoice_no}}</span></li>
                        <li style="margin-bottom: 10px">Order Number: <span>{{$data['orders_data'][0]->orders_id}}</span></li>
                        <li style="margin-bottom: 10px">Order Date: <span>{{date('d-m-Y', strtotime($data['orders_data'][0]->created_at2))}}</span></li>
                    </ul>
                    <!-- <div>
                        <?php $qty = 0; ?>
         
                        @foreach($data['orders_data'][0]->data as $key=>$products)
                        <ul style="list-style-type: none; padding: 0; margin: 0 0 30px;">
                            <div class="product-container" style="display: flex; align-items: center;">
                
                                <div class="image-container" style="flex: 0 0 auto; margin-right: 10px;">
                                    <img class="product-image" src="{{asset($products->path)}}" alt="Product Image" style="width: 100px; height: auto;">
                                </div>
                                
                                <div class="details-container" style="flex: 1;">
                                    <ul class="details-list" style="list-style-type: none;">
                                        <li class="detail-item" style="margin-bottom: 5px;"><strong>Name:</strong> {{ $products->products_name }}</li>
                                        <li class="detail-item" style="margin-bottom: 5px;"><strong>SKU:</strong> {{ $products->products_model }}</li>
                                        <li class="detail-item" style="margin-bottom: 5px;"><strong>Quantity:</strong> {{ $products->products_quantity }}</li>
                                        <li class="detail-item" style="margin: 0 0 5px;text-align: right;"><strong>Price:</strong> {{ $products->products_price }}</li>
                                    </ul>
                                </div>
                            </div>
                        </ul> 
                        <?php $qty += $products->products_quantity*$products->products_price?>
                        @endforeach
                    </div> -->
       
                <div style="display: flex;margin-bottom: 20px;">
                   
                    <div style="flex: 1;">
                        <h3>Customer Details</h3>

                        @if(isset($data['orders_data'][0]->customer))
                        <ul style="list-style-type: none; padding: 0; margin: 0;">
                            <li  style="margin-bottom: 10px"><strong>Name:</strong> {{$data['user_info'][0]->first_name}} {{ $data['orders_data'][0]->customer->last_name }}</li>
                            <li  style="margin-bottom: 10px"><strong>Address:</strong> {{ $data['user_info'][0]->address }}</li>
                            <li  style="margin-bottom: 10px"><strong>Contact:</strong> {{ $data['user_info'][0]->phone }}</li>
                        </ul>
                        @else

                        <ul style="list-style-type: none; padding: 0; margin: 0;">
                            <li  style="margin-bottom: 10px"><strong>Name:</strong> {{ $data['orders_data'][0]->delivery_name }}</li>
                            <li  style="margin-bottom: 10px"><strong>Address:</strong> {{ $data['orders_data'][0]->delivery_street_address }}</li>
                            <li  style="margin-bottom: 10px"><strong>Contact:</strong> {{ $data['orders_data'][0]->delivery_phone }}</li>
                        </ul>
                        @endif

                    </div>
                    
        
                   <div style="flex: 1;">
                        <h3>Shipping Details</h3>
                        <ul style="list-style-type: none; padding: 0; margin: 0;">
                            <li  style="margin-bottom: 10px"><strong>Shipping Country:</strong>{{$data['orders_data'][0]->shipping_info->countries_name}}</li>
                            <li  style="margin-bottom: 10px"><strong>Shipping City:</strong>{{$data['orders_data'][0]->shipping_info->zone_name}}</li>
                        </ul>
                    </div>
                </div> 

                <div style="display: flex;margin-bottom: 20px;">
                   
                    <div style="flex: 1;">
                        <h3>Payement Method</h3>

                        <ul style="list-style-type: none; padding: 0; margin: 0;">
                            <li  style="margin-bottom: 10px">{{$data['orders_data'][0]->payment_method}}</li>

                    </div>
                    
        
                    <div style="flex: 1;">
                        <h3>Shipping Method</h3>
                        <ul style="list-style-type: none; padding: 0; margin: 0;">
                            <li  style="margin-bottom: 10px">{{$data['orders_data'][0]->way_to_recived}}</li>
                            <li  style="margin-bottom: 10px">(Total shipping charges {{$data['orders_data'][0]->shipping_cost}})</li>
                        </ul>
                    </div>
                </div>
            </td>
        </tr>      
    </tbody>
</table>

<table style="width: 80%; margin:auto; background:#fff;border-spacing: 0;font-family: 'Arial', sans-serif;">
  <thead class="thead-light">
    <tr>
      <td>Products</td>
      <td>SKU</td>
      <td>Price</td>
      <td>Qty</td>
      <td>Tax (5%)</td>
      <td>Sub Total</td>
    </tr>
  </thead>
  <tbody>
        <tr></tr>
        <?php $qty = 0; ?>
        @foreach($data['orders_data'][0]->data as $key=>$products)
        <tr>
          <td>{{ $products->products_name }}</td>
          <td>{{ $products->products_model }}</td>
          <td><strong>AED {{ $products->products_price }}</strong></td>
          <td><strong>{{ $products->products_quantity }}</strong></td>
          <td><strong>AED {{ number_format($products->products_price * 0.05, 2) }}</strong></td>
          <td><strong>AED {{ number_format($products->products_price * $products->products_quantity, 2) }}</strong></td>
        </tr>
        <?php $qty += $products->products_quantity*$products->products_price?>
        @endforeach
  </tbody>

<!--   <tfoot>
        <tr style="background-color: #fae4df;">
            <td style="text-align:center;padding-top: 20px;">
                <p style="margin-top: 0;">Sab Bling Trading LLC</p>
                <p>Gold and Diamond Building 6 ,25A St - Al Quoz - Al Quoz Industrial Area 3 - Dubai - United Arab Emirates</p>
                <p>+971 4 280 2313 | +971 50 556 5780</p>
                <p>Tax Reg. No.: 100354233700003</p>
            </td>
        </tr>
    </tfoot> -->
</table>

<div style="text-align: right; margin-right: 210px;">
    <ul style="list-style-type: none;">
        <li><strong>Subtotal:</strong> <span style="margin-left: 10px;"><strong>AED {{ number_format($qty , 2) }}</strong></span></li>
        <li><strong>Grand Total (Excl. Tax):</strong> <span style="margin-left: 10px;"><strong>AED {{ number_format($qty , 2) }}
        </strong></span></li>
        <li><strong>Tax:</strong>
            <span style="margin-left: 10px;">
                <strong>AED {{ $data['orders_data'][0]->total_tax }}</strong>
            </span>
        </li>
        <li><strong>Grand Total (Incl. Tax):</strong>
            <span style="margin-left: 10px;">
                <strong>AED {{$data['orders_data'][0]->order_price}}</strong>
            </span>
        </li>
    </ul>
</div>




</body>


</html>