<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\URL;
use App\Category;
use App\POS\Product_order;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){

        $this->middleware(['auth']);

    }
    //
    public function index()
    {
        return view('Food.product', ['category' => $this->category()]);
    }

    
    private function category(){
        return  Category::select('id','name','name_kh')->get();
        return  Product_order::select('order','product','price','qty')->get();
        return  Category::select('id',\DB::raw('concat(name, "-" ,name_kh )as text'))->get();
    }

    public function getRow(){
        
        return \DB::table('view_product')->orderBy('id','desc')->paginate(5);
    }

    public function rowsByCate($cate){
        if($cate == "__all"){
            return \DB::table('view_product')->get();
        }else{
            return \DB::table('view_product')->where('category' , $cate)->get();
        }
    }

/*     private function categories(){
        return Category::select('id', \DB::raw('concat(name, "-" , name_nk) as text'))->get();
    } */
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=> 'required|string|max:255',
            'name_kh'=> 'required|string|max:255',
            'price'=> 'required|numeric',
            'dsc'=> 'required|string|max:255',
            'photo'=> 'required|image64:jpeg,jpg,png,gif,svg',
            'category'=> 'required',
            
        ]);

        if($request->photo){
            $name = now()->format('dmY.His'). "-" . time(). '.' . explode( '/' , explode( ':' , substr($request->photo,0, strpos($request->photo, ";")))[1])[1];
            Image::make($request->photo)->save(public_path('img/food/').$name);
        }


        $product = Product::create([
            'name' => $request->name,
            'name_kh' => $request->name_kh,
            'price' => $request->price,
            'dsc' => $request->dsc,
            'photo' => $name,
            'category' =>$request->category,
            
        ]);
        
        return response()->json(['message' =>"Product's $product->name save compelete."]);
    }

    /**|max:2048
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

        $product = Product::find($id);

        $this->validate($request, [
            'name'=> 'required|string|max:255',
            'name_kh'=> 'required|string|max:255',
            'price'=> 'required|numeric',
            'dsc'=> 'required|string|max:255',
            'category'=> 'required',
            
        ]);


        $curPhoto = $product->photo;

        if($request->photo != $curPhoto){

            $this->validate($request, [
                'photo'=> 'required|image64:jpeg,jpg,png,gif,svg',
            ]);

            $name = now()->format('dmY.His'). "-" . time(). '.' . explode( '/' , explode( ':' , substr($request->photo,0, strpos($request->photo, ";")))[1])[1];
            Image::make($request->photo)->save(public_path('img/food/').$name);
            $request->merge(['photo' => $name]);

            $photo = public_path('img/food/') . $curPhoto;
            if(file_exists($photo)){
                @unlink($photo);
            }
        }

        
        $product->update($request->all());

        return response()->json(['message' => 'Completed']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::destroy($id);
    }

}
