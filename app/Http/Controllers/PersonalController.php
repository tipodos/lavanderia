<?php

namespace App\Http\Controllers;

use App\Models\order;
use App\Models\orderDetail;
use Illuminate\Http\Request;
use App\Models\personal;
use App\Models\product;

class PersonalController extends Controller
{
    public function index(){

        $order = Order::where('estado', '!=', 1)->paginate(10);
        $detail= OrderDetail::all();
        $productos=Product::all();
        

        return view('index', compact('order','detail', 'productos'));
    }

    public function store(Request $request){

        $request->validate([
            'name'=>'required|min:3',
            'celular'=>'required',
            'dni'=>'required'
        ]);

        $order= new order();
        $order->name=$request->input('name');
        $order->celular=$request->input('celular');
        $order->dni=$request->input('dni');
        $order->adelanto=$request->input('adelanto',0);
        $order->total=0;
        $order->save();

        $productos = $request->input('productos');
        $cantidades = $request->input('cantidad');
        $totales = $request->input('total');

        $totalPagar = 0;
        foreach ($productos as $key => $producto_id) {
            $orderDetail = new OrderDetail();
            $orderDetail->order_id = $order->id;
            $orderDetail->product_id = $producto_id;
            $orderDetail->quantity = $cantidades[$key];
            $orderDetail->price = $totales[$key] / $cantidades[$key];
            $orderDetail->save();

            $totalPagar += $totales[$key];
        }
        $order->total = $totalPagar;
        $order->save();
        
        return redirect()->route('index')->with('success', 'Personal created successfully.');
    }
    public function show($id){
        $detalle= Order::findOrFail($id);
        $productos = orderDetail::where('order_id', $id)->get();
        return view('show', compact('detalle', 'productos'));
    }

    public function update(Request $request, $id){
        $order= Order::FindOrFail($id);
        $order->estado=$request->estado;
        $order->save();

        return redirect()->route('index')->with('success', 'Estado actualizado correctamente.');
    }
    
    public function delete(Request $request){
        $order=Order::find($request->id);
        if (!$order) {
            return redirect()->route('index')->with('error', 'Orden no encontrada.');
        }
        $details= orderDetail::where('order_id', $order->id)->get();
        foreach ($details as $detail) {
            $detail->delete();
        }
        $order->delete();
        return redirect()->route('index')->with('success', 'Personal created successfully.');
    }
}
