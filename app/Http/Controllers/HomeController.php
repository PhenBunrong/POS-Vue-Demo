<?php

namespace App\Http\Controllers;

use App\Product;

use App\Category;
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $cate = Category::select('id', \DB::raw('concat(name,"-",name_kh) as text'))->get();
        
        $tabl =  Table::select('id','name as text')->get();

        return view('view',['category' => $cate , 'table' => $tabl]);

        /* return view('view'); */
    }

    private function product_order(){
        
        return  Product_order::select('order','product','price','qty')->get();
    }

    
    public function rowsByCate($cate){
        if($cate == "__all"){
           $products = \DB::table('view_product')->get();
           return view('view', compact('products'));
        }else{
            $products = \DB::table('view_product')->where('category' , $cate)->get();
            return view('view', compact('products'));
        }
    }
/*     public function getRow(){
        
        return \DB::table('view_product')->orderBy('id','desc')->paginate(5)
 
         return $product
     } */


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
            'customer' => 1,
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
     
}
