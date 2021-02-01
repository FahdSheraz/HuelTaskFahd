<!DOCTYPE html>
<html lang="en">
<head>
  <title>Products</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Products</h2>
  @if(session()->has('message'))
      <div class="alert alert-success">
          {{ session()->get('message') }}
      </div>
  @endif
  <span><a href="{{ url('products/import') }}" class="btn btn-success">Import</a></span>     
  <table class="table table-bordered">
    <thead>
      <tr>
        <td>TITLE</td>
        <td>Product type</td>
        <td>Vendor</td>
        <td>Tags</td>
        <td>Handle</td>
        <td>Published at</td>
      </tr>
    </thead>
    <tbody>
	@foreach($products as $product)
      <tr>
        <td>{{ $product->title }}</td>
        <td>{{ $product->product_type }}</td>
        <td>{{ $product->vendor }}</td>
        <td>{{ $product->tags }}</td>
        <td>{{ $product->handle }}</td>
        <td>{{ $product->published_at }}</td>
      </tr>
	@endforeach
    </tbody>
  </table>
</div>

</body>
</html>
