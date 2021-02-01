<!DOCTYPE html>
<html lang="en">
<head>
  <title>Customers</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Customers</h2>     
  <span><a href="{{ url('customers/import') }}" class="btn btn-success">Import</a></span>     
  <table class="table table-bordered">
    <thead>
      <tr>
        <td>Name</td>
        <td>Email</td>
        <td>note</td>
        <td>Address</td>
        <td>Orders Count</td>
      </tr>
    </thead>
    <tbody>
	@forelse($customers as $customer)
      <tr>
        <td>{{ $customer->first_name. ' ' . $customer->last_name}}</td>
        <td>{{ $customer->email }}</td>
        <td>{{ $customer->note }}</td>
        <td>{{ $customer->address }}</td>
        <td>{{ $customer->orders_count }}</td>
      </tr>
	@empty
	<tr><td colspan="4">No records</td></tr>
	@endforelse
    </tbody>
  </table>
</div>

</body>
</html>
