<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
			
			.box-list {
				margin-top: 60px;
			}			
			.box-list ul{
				list-style: none;
				display: flex;
			}
			
			.box-list ul li{
				padding: 25px 25px;
				border: 1px solid #ccc;
				cursor: pointer;
			}
			
			.box-list ul li:nth-child(2) {
				margin: 0 62px;
			}
			
			.bold {
				font-size: 14px;
				font-weight: 700;
				margin-top: 5px;
			}
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Task
                </div>

                <div class="links">
                    <p>1. Save customers, orders and products to a third party database ( MySQL ) </p>
                    <a href="{{ url('products') }}">Products</a>
                    <a href="{{ url('customers') }}">Customers</a>
                    <a href="{{ url('orders') }}">Orders</a>
                </div>
				
				<div class="box-list">
					<ul>
						<li>2. Average order value across all customers <div class="bold">${{$all_order_mean_value}}</div></li>
						<li>
							<div style="margin-bottom: 5px;">
                <div>3. Average order value of a specific customer</div>
								<select id="bycustomer">
									<option selected disabled>Select Customer</option>
									@foreach($customers->customers as $customer)
									<option value="{{ $customer->email }}">{{ $customer->first_name.' '.$customer->last_name }}</option>
									@endforeach
								</select>
							</div>
							<div class="bold" id="forcustomer">$00.00</div>
						</li>
						<li>
							<div style="margin-bottom: 5px;">
                 <div>4. Average order value of a specific variant</div>
								<select id="byvariant">
									<option selected disabled>Select Product</option>
									@foreach($products->products as $product)
									<optgroup label="{{ $product->title }}">
										@foreach($product->variants as $variant)
											<option value="{{ $variant->id }}">{{ $variant->title }}</option>
										@endforeach
									</optgroup>
									@endforeach
								</select>
							</div>
							<div class="bold" id="forvariant">$00.00</div>
						</li>
					</ul>
				</div>
            </div>
        </div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
		<script>
			jQuery(document).ready(function(){
				jQuery("#bycustomer").change(function(){
					var id = jQuery(this).val();
					jQuery.ajax({
						url: '{{ url("/") }}/orders/bycustomer/'+id,
						success: function(response){
							jQuery("#forcustomer").html("$"+response.order_value);
						}
					});
				});
				jQuery("#byvariant").change(function(){
					var id = jQuery(this).val();
					jQuery.ajax({
						url: '{{ url("/") }}/orders/byvariant/'+id,
						success: function(response){
							jQuery("#forvariant").html("$"+response.order_value);
						}
					});
				});
			});
		</script>
    </body>
</html>
