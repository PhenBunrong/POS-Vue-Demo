<?php

namespace App\Http\Controllers;

use App\Product;

use App\Category;
use App\Customer;
use App\POS\Order;
use App\POS\Table;
use App\POS\Product_order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Intervention\Image\Facades\Image;




class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cate = Category::select('id', \DB::raw('concat(name,"-",name_kh) as text'))->get();
        
        $tabl =  Table::select('id','name as text')->get();

        $customer =  Customer::select('id','name as text')->get();

        return view('view',['category' => $cate , 'table' => $tabl, 'customer' => $customer]);
    }

    public function category_json()
    {
        $collection = Category::select('id', \DB::raw('concat(name,"-",name_kh) as text'))->get();
        return  $collection;
    }
    public function table_json()
    {
        $collection = Table::select('id','name')->get();
        return  $collection;
    }

    public function search_product_json(Request $request, $limit, $key)
    {
        $collection = Product::where('name_kh', $key)
            ->orWhere('price', $key)
            ->orWhere('name_kh', 'LIKE', '%'. $key . '%')
            ->orderBy('id','DESC')->paginate($limit);
        return $collection;
    }

    public function latest_product_json(Request $request)
    {
        $collection = \DB::table('view_product')
            ->orderBy('id', 'DESC')->paginate(6);
        return $collection;
    }

    public function json_customer_rows(){
        $collection = Customer::select('id', \DB::raw('name'))->get();
        return  $collection;
    }

    public function save(Request $request)
    {
        $request->validate([
            'TotalPay' => 'required|numeric|min:100',
            'CashIn' => 'required|numeric|min:100|gte:TotalPay',
        ]);
    
        $order = Order::create([
            'order_date' => now(),
            'table' => $request->table,
            'user' => auth()->user()->id,
            'customer' => $request->customer,
            'totalPay' => $request->TotalPay,
            'cashIn' => $request->CashIn,
        ]);

        $data = [];
        
        foreach ($request->orders as $k) {
            
            $nest = [];
            $nest['order'] = $order->id;
            $nest['product'] = $k['id'];
            $nest['price'] = $k['price'];
            $nest['qty'] = $k['qty'];

            $data[] = $nest;
        }

        $order->product()->sync($data);

        return response()->json($order);
    }

    public function exportIndex(){

        return view('Food.export');

    }

    public function exportOrder(Request $request){
        
        $orders = new Order();
        
        if($request->start_date){
            $orders = $orders->where('created_at', '>=', $request->start_date);
        }
        if($request->end_date){
            $orders = $orders->where('created_at', '<=', $request->end_date);
        }

        $orders  = $orders->with(['tables','customers','users'])->latest()->paginate(10);

        $total = $orders->map(function ($i){
            return $i->totalPay;
        })->sum();
        
        return $orders;
    }

    // private function product_order()
    // {
    //     return  Product_order::select('order','product','price','qty')->get()
    // }

    
    // public function rowsByCate($cate)
    // {
    //     if($cate == "__all"){
    //        $products = \DB::table('view_product')->get()
    //        return view('view', compact('products'))
    //     }else{
    //         $products = \DB::table('view_product')->where('category' , $cate)->get()
    //         return view('view', compact('products'))
    //     }
    // }

     /* public function getRow(){
        
        return \DB::table('view_product')->orderBy('id','desc')->paginate(5)
 
         return $product
     } */
}
