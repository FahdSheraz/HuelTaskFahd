<!DOCTYPE html>
<html lang="en">
<head>
  <title>Orders</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Orders</h2>     
  <span><a href="{{ url('orders/import') }}" class="btn btn-success">Import</a></span>     
  <table class="table table-bordered">
    <thead>
      <tr>
        <td>Order Id</td>
        <td>Email</td>
        <td>Total price</td>
        <td>Status</td>
        <td>Payment</td>
        <td>Address</td>
        <td>Created at</td>
      </tr>
    </thead>
    <tbody>
	@foreach($orders as $order)
      <tr>
        <td>{{ $order->name }}</td>
        <td>{{ $order->email }}</td>
        <td>${{ $order->total_price }}</td>
        <td>{{ $order->financial_status }}</td>
        <td>{{ $order->gateway }}</td>
        <td>
			Billing Address: 
			@php
				$billing_address = unserialize($order->billing_address);
			@endphp
			<address>{{ $billing_address->first_name }}, {{ $billing_address->last_name }}, {{ $billing_address->address1 }}</address>
			Shipping Address: 
			@php
				$shipping_address = unserialize($order->shipping_address);
			@endphp
			<address>{{ $shipping_address->first_name }}, {{ $shipping_address->last_name }}, {{ $shipping_address->address1 }}</address>
		</td>
        <td>{{ $order->order_created_at }}</td>
      </tr>
	@endforeach
    </tbody>
  </table>
</div>

</body>
</html>
