<?php

namespace App\Http\Controllers;

use App\POS\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function __construct(){

        $this->middleware(['auth']);

    }

    public function index(){

        return view('Food.table');

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=> 'required|string|max:255',
        ]);


        $table = Table::create([
            'name' => $request['name'],
            'dsc' => $request['dsc'],
        ]);
        
        return response()->json(['message' =>"Category's $table->name save compelete."]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'=> 'required|string|max:255',
        ]);

        $table = Table::findOrFail($id);
        $table->update($request->all());

        return response()->json(['message' => 'Completed']);
    }

    public function destroy($id)
    {
        Table::destroy($id);
        
    }

    public function getRow(){
        
        $table = Table::orderBy('id','desc')->paginate(5);

        return $table;
    }
}
