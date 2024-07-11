<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;


class ProductoController extends Controller
{
    public function index(){

        $producto= product::all();

        return view('products/index', compact('producto'));
    }
    public function store(Request $request){

        $request->validate([
            'name'=>'required|min:3',
            'price'=>'required'
        ]);

        $producto= new product();
        $producto->name=$request->input('name');
        $producto->price=$request->input('price');
        $producto->save();
        
        return redirect()->route('producto.index')->with('success', 'Personal created successfully.');
    }
    public function edit($id){

        $producto= product::findOrFail($id);
        $productos= product::all();

        return view('products/edit', compact('producto','productos'));
    }
    public function update(Request $request, $id){
        $producto= Product::findOrFail($id);
        $producto->name=$request->input('name');
        $producto->price=$request->input('price');
        $producto->save();

        return redirect()->route('producto.index')->with('success', 'Personal created successfully.');
    }
    public function delete(Request $request){
        $producto=product::find($request->id);
        $producto->delete();
        return redirect()->route('producto.index')->with('success', 'Personal created successfully.');
    }
}
