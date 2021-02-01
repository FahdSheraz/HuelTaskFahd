<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
	public $key;
	public $secret;
	
	public function __construct(){
		$this->key = '706efc50a2d87c931dbaeabedcae6856';
		$this->secret = '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';
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$customers = json_decode(file_get_contents('https://'.$this->key.':'.$this->secret.'@technical-be-74176.myshopify.com/admin/api/2021-01/customers.json'));
		$orders = json_decode(file_get_contents('https://'.$this->key.':'.$this->secret.'@technical-be-74176.myshopify.com/admin/api/2021-01/orders.json'));
		$products = json_decode(file_get_contents('https://'.$this->key.':'.$this->secret.'@technical-be-74176.myshopify.com/admin/api/2021-01/products.json'));
		$total_orders = count($orders->orders);
		$all_price = 0;
		foreach($orders->orders as $order){
			$all_price += $order->total_price;
		}
		$all_order_mean_value = round(($all_price / $total_orders),2);
        return view('welcome', compact('customers', 'all_order_mean_value', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function products(){
		$products = \DB::table('products')->get();
		return view('products', compact('products'));
    }
	
    public function productsImport(){
		$data = json_decode(file_get_contents('https://'.$this->key.':'.$this->secret.'@technical-be-74176.myshopify.com/admin/api/2021-01/products.json'));
		$products = [];
		$pro = $data->products;
    $exist = false;
		foreach($data->products as $product){
			$p_count = \DB::table('products')->where('product_id',$product->id)->count();
			if(!$p_count){
				$products[] = array(
					'product_id' => $product->id,
					'title' => $product->title,
					'product_type' => $product->product_type,
					'vendor' => $product->vendor,
					'tags' => $product->tags,
					'handle' => $product->title,
					'variants' => serialize($product->variants),
					'published_at' => date('Y-m-d h:i:s', strtotime($product->published_at))
				);
			}else{
        $exist = true;
      }
		}
		\DB::table('products')->insert($products);
     if($exist){
       return redirect()->route('products')->with('message', 'Duplicate products found  in external database.');
     }
     return redirect()->route('products')->with('message', 'Products imported succesfully!');
		
    }
	
	public function getProducts(){
		$products = \DB::table('products')->get();
		return \Response::json($products);
	}
	
	public function customers(){
		$customers = \DB::table('customers')->get();
		return view('customers', compact('customers'));
	}
	
    public function customersImport(){
		$data = json_decode(file_get_contents('https://'.$this->key.':'.$this->secret.'@technical-be-74176.myshopify.com/admin/api/2021-01/customers.json'));
		$customers = [];
		foreach($data->customers as $customer){
			$p_count = \DB::table('customers')->where('email',$customer->email)->count();
			if(!$p_count){
				$customers[] = array(
					'first_name' => $customer->first_name,
					'last_name' => $customer->last_name,
					'email' => $customer->email,
					'verified_email' => $customer->verified_email,
					'accepts_marketing' => $customer->accepts_marketing,
					'note' => $customer->note,
					'state' => $customer->state,
					'tags' => $customer->tags,
					'tax_exempt' => $customer->tax_exempt,
					'address' => !empty($customer->default_address) ? $customer->default_address->address1 : null,
					'orders_count' => $customer->orders_count,
				);
			}
		}
		\DB::table('customers')->insert($customers);
		return redirect()->route('customers');
    }
	
	public function getCustomers(){
		$customers = \DB::table('customers')->get();
		return \Response::json($customers);
	}
	
	public function getOrders(Request $request){
		$orders = \DB::table('orders');//->get();
		if($request->has('customer')){
			$email = $request->get('customer');
			$orders->where('email', $email);
		}
		if($request->has('product')){
			$product = $request->get('product');
			$orders->where('line_items', 'LIKE', '%'.$product.'%');
		}
		return \Response::json($orders->get());
	}
	
	public function orders(Request $request){
		$orders = \DB::table('orders');//->get();
		if($request->has('customer')){
			$email = $request->get('customer');
			$orders->where('email', $email);
		}
		if($request->has('product')){
			$product = $request->get('product');
			$orders->where('line_items', 'LIKE', '%'.$product.'%');
		}
		$orders = $orders->get();
		return view('orders', compact('orders'));
	}
	
    public function ordersImport(){
		$data = json_decode(file_get_contents('https://'.$this->key.':'.$this->secret.'@technical-be-74176.myshopify.com/admin/api/2021-01/orders.json'));
		$orders = [];
		foreach($data->orders as $order){
			$p_count = \DB::table('orders')->where('order_number',$order->order_number)->count();
			if(!$p_count){
				$orders[] = array(
					'email' => $order->email,
					'order_created_at' => $order->created_at,
					'total_price' => $order->total_price,
					'financial_status' => $order->financial_status,
					'name' => $order->name,
					'order_number' => $order->order_number,
					'gateway' => $order->gateway,
					'order_status_url' => $order->order_status_url,
					'line_items' => isset($order->billing_address) ? serialize($order->line_items) : '',
					'billing_address' => isset($order->billing_address) ? serialize($order->billing_address) : '',
					'shipping_address' => isset($order->shipping_address) ? serialize($order->shipping_address) : '',
					'customer' => isset($order->customer) ? serialize($order->customer) : ''
				);
			}
		}
		\DB::table('orders')->insert($orders);
		return redirect()->route('orders');
    }
	
	public function filterOrders($filter, $id){
		if($filter == "bycustomer"){
			$orders = json_decode(file_get_contents('https://'.$this->key.':'.$this->secret.'@technical-be-74176.myshopify.com/admin/api/2021-01/orders.json?email='.$id));
			$total_orders = count($orders->orders);
			$all_order_mean_value = 0;
			if($total_orders > 0){
				$all_price = 0;
				foreach($orders->orders as $order){
					$all_price += $order->total_price;
				}
				$all_order_mean_value = number_format(($all_price / $total_orders),2);			
			}
			return \Response::json(["success" => true, 'order_value' => $all_order_mean_value]);
		}else if($filter == "byvariant"){
			$orders = \DB::table('orders')->where('line_items', 'LIKE', '%'.$id.'%')->get();
			$total_orders = $orders->count();
			$all_order_mean_value = 0;
			if($total_orders > 0){
				$all_price = 0;
				foreach($orders as $order){
					$all_price += $order->total_price;
				}
				$all_order_mean_value = number_format(($all_price / $total_orders),2);			
			}

			return \Response::json(["success" => true, 'order_value' => $all_order_mean_value]);
		}

	}
}
