<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
 
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    

    public function index()
    {
        return view('Food.category');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=> 'required|string|max:255',
            'name_kh'=> 'required|string|max:255',
            'dsc'=> 'required|string|max:255',
        ]);
    
    
        $category = Category::create([
            'name' => $request['name'],
            'name_kh' => $request['name_kh'],
            'dsc' => $request['dsc'],
        ]);
        
        return response()->json(['message' =>"Category's $category->name save compelete."]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'=> 'required|string|max:255',
            'name_kh'=> 'required|string|max:255',
            'dsc'=> 'required|string|max:255',
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->all());

        return response()->json(['message' => 'Completed']);
    }

    
    public function destroy($id)
    {
        Category::destroy($id);
        
    }

    public function getRow(){
        
        $category = Category::orderBy('id','desc')->paginate(5);

        return $category;
    }
}
